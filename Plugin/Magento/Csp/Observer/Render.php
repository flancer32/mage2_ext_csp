<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Plugin\Magento\Csp\Observer;

use Flancer32\Csp\Config as Cfg;

class Render
{
    /** @var \Magento\Framework\App\State */
    private $state;
    /** @var \Magento\Backend\Model\Url */
    private $urlBack;
    /** @var \Magento\Framework\Url */
    private $urlFront;

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Backend\Model\Url $urlBack,
        \Magento\Framework\Url $urlFront
    ) {
        $this->state = $state;
        $this->urlBack = $urlBack;
        $this->urlFront = $urlFront;
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

        // Setup reporting in HTTP header.
        /** @var \Magento\Framework\App\Response\HttpInterface $response */
        $response = $observer->getEvent()->getData('response');

        $uri = $this->getReportUri();

        // 'Report-To' is not widely supported yet, so remove it.
        // (https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-to)
        $response->clearHeader('Report-To');
        // TODO: we should get 'Content-Security-Policy-Report-Only' or 'Content-Security-Policy'
        $cspHeader = $response->getHeader('Content-Security-Policy-Report-Only');
        $value = $cspHeader->getFieldValue();
        $value = str_replace('report-to report-endpoint;', '', $value);
        $value .= " report-uri $uri;";
        $response->setHeader('Content-Security-Policy-Report-Only', $value);
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
