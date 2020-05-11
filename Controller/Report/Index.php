<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Controller\Report;

use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\HttpFactory;
use Psr\Log\LoggerInterface;

class Index
    extends \Magento\Framework\App\Action\Action
    implements CsrfAwareActionInterface
{
    const HTTP_NO_CONTENT = 204;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;
    /** @var \Magento\Framework\App\Response\HttpFactory */
    private $factHttpResponse;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        LoggerInterface $logger,
        HttpFactory $factHttpResponse
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->factHttpResponse = $factHttpResponse;
    }

    public function execute()
    {
        // Read POSTed data and convert it into PHP object.
        $rawBody = file_get_contents('php://input');
        $data = json_decode($rawBody);
        $this->logger->debug("CSP report: $rawBody");

        // ... then create response
        /** @var \Magento\Framework\App\Response\Http $result */
        $result = $this->factHttpResponse->create();
        $result->setHttpResponseCode(self::HTTP_NO_CONTENT);
        $result->setPublicHeaders(0);
        return $result;
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        // all request are allowed, so we no need to have this implementation
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
