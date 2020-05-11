<?php


namespace Flancer32\Csp\Plugin\Magento\Csp\Observer;


class Render
{
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
        $proceed($observer);
        /** @var \Magento\Framework\App\Response\HttpInterface $response */
        $response = $observer->getEvent()->getData('response');

        // 'Report-To' is not widely supported yet, so remove it.
        // (https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-to)
        $response->clearHeader('Report-To');
        // TODO: we should get 'Content-Security-Policy-Report-Only' or 'Content-Security-Policy'
        $cspHeader = $response->getHeader('Content-Security-Policy-Report-Only');
        $value = $cspHeader->getFieldValue();
        str_replace('report-to report-endpoint;', '', $value);
        $response->setHeader('Content-Security-Policy-Report-Only', $value);
    }
}
