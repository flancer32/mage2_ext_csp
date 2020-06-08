<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Plugin\Magento\Csp\Observer;

use Flancer32\Csp\Config as Cfg;

/**
 * Clean up headers after Magento processing of CSP (report-uri is deprecated but works).
 */
class Render
{
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress */
    private $remoteAddr;
    /** @var \Magento\Framework\App\State */
    private $state;
    /** @var \Magento\Backend\Model\Url */
    private $urlBack;
    /** @var \Magento\Framework\Url */
    private $urlFront;

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddr,
        \Magento\Backend\Model\Url $urlBack,
        \Magento\Framework\Url $urlFront,
        \Flancer32\Csp\Helper\Config $hlpCfg
    ) {
        $this->state = $state;
        $this->remoteAddr = $remoteAddr;
        $this->urlBack = $urlBack;
        $this->urlFront = $urlFront;
        $this->hlpCfg = $hlpCfg;
    }

    /**
     * Clean up headers after Magento processing of CSP (report-uri is deprecated but works).
     *
     * @param \Magento\Csp\Observer\Render $subject
     * @param callable $proceed
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function aroundExecute(
        \Magento\Csp\Observer\Render $subject,
        callable $proceed,
        \Magento\Framework\Event\Observer $observer
    ) {
        // Collect all CSP rules and compose HTTP header.
        $proceed($observer);
        // ... then modify HTTP header
        /** @var \Magento\Framework\App\Response\HttpInterface $response */
        $response = $observer->getEvent()->getData('response');
        if ($this->hlpCfg->getEnabled()) {
            if ($this->shouldAddReporting()) {
                /* setup CSP reporting (replace Magento added directives) */
                $this->setupReporting($response);
            } else {
                /* clean CSP reporting added by Magento */
                $this->setupReporting($response, true);
            }
        }
    }

    private function getReportUri()
    {
        $area = $this->state->getAreaCode();
        if ($area === \Magento\Framework\App\Area::AREA_ADMINHTML) {
            $result = $this->urlBack->getUrl(Cfg::ROUTE_REPORT);
        } else {
            $result = $this->urlFront->getUrl(Cfg::ROUTE_REPORT);
        }
        return $result;
    }

    /**
     * Modify HTTP headers to setup CSP reporting.
     *
     * @param \Magento\Framework\App\Response\HttpInterface $response
     * @param bool $justClear
     */
    private function setupReporting(&$response, $justClear = false)
    {
        // URI to get CSP violation reports for admin/front areas
        $uri = $this->getReportUri();
        // 'Report-To' is not widely supported yet, so remove it. Use 'report-uri' directive instead.
        // (https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-to)
        $response->clearHeader('Report-To');
        // Get current CSP header and clear it.
        $cspHeader = $response->getHeader(Cfg::HTTP_HEAD_CSP_REPORT_ONLY);
        if ($cspHeader) {
            $response->clearHeader(Cfg::HTTP_HEAD_CSP_REPORT_ONLY);
        } else {
            $cspHeader = $response->getHeader(Cfg::HTTP_HEAD_CSP);
            $response->clearHeader(Cfg::HTTP_HEAD_CSP);
        }
        // Modify CSP header if exists.
        if ($cspHeader) {
            $value = $cspHeader->getFieldValue();
            // use deprecated 'report-uri' instead of 'report-to' because Chrome doesn't work correctly with
            // new 'report'to' or with both directives.
            $value = str_replace('report-to report-endpoint;', '', $value);
            // only one 'report-uri' directive is allowed
            $pattern = '/report-uri\s*.*;/';
            $value = preg_replace($pattern, '', $value);
            if (!$justClear) {
                $value .= "report-uri $uri;";
            }
            $header = $this->hlpCfg->getRulesReportOnly() ? Cfg::HTTP_HEAD_CSP_REPORT_ONLY : Cfg::HTTP_HEAD_CSP;
            $response->setHeader($header, $value);
        }
    }

    /**
     * Validate visitor's IP address if reporting is allowed for developers only.
     *
     * @return bool
     */
    private function shouldAddReporting()
    {
        $result = true;
        if ($this->hlpCfg->getReportsDeveloperOnly()) {
            /* CSP reports are allowed for developers only, we need to check IP address of visitor. */
            $ip = $this->remoteAddr->getRemoteAddress();
            $allowed = $this->hlpCfg->getReportsDeveloperIps();
            $result = in_array($ip, $allowed);
        }
        return $result;
    }

}
