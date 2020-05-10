<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Controller\Index;

class Index
    extends \Magento\Framework\App\Action\Action
{
    const HTTP_NO_CONTENT = 204;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->debug("Oppa!");
        $type = \Magento\Framework\Controller\ResultFactory::TYPE_RAW;
        /** @var \Magento\Framework\View\Result\Page $result */
        $result = $this->resultFactory->create($type);
        $result->setHttpResponseCode(self::HTTP_NO_CONTENT);
        return $result;
    }

}
