<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Plugin\Magento\Csp\Observer;

use Flancer32\Csp\Config as Cfg;

class Render
{
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Framework\App\State */
    private $state;
    /** @var \Magento\Backend\Model\Url */
    private $urlBack;
    /** @var \Magento\Framework\Url */
    private $urlFront;

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Backend\Model\Url $urlBack,
        \Magento\Framework\Url $urlFront,
        \Flancer32\Csp\Helper\Config $hlpCfg
    ) {
        $this->state = $state;
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
        if ($this->hlpCfg->getEnabled()) {
            // Setup reporting in HTTP header.
            /** @var \Magento\Framework\App\Response\HttpInterface $response */
            $response = $observer->getEvent()->getData('response');
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
                $value .= "report-uri $uri;";
                $header = $this->hlpCfg->getRulesReportOnly() ? Cfg::HTTP_HEAD_CSP_REPORT_ONLY : Cfg::HTTP_HEAD_CSP;
                $response->setHeader($header, $value);
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

}
