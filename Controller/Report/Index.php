<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Controller\Report;

use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;

class Index
    extends \Magento\Framework\App\Action\Action
    implements CsrfAwareActionInterface
{
    const HTTP_NO_CONTENT = 204;

    /** @var \Magento\Framework\App\Response\HttpFactory */
    private $factHttpResponse;
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Flancer32\Csp\Service\Report\Save */
    private $srvReportSave;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Response\HttpFactory $factHttpResponse,
        \Flancer32\Csp\Helper\Config $hlpCfg,
        \Flancer32\Csp\Service\Report\Save $srvReportSave
    ) {
        parent::__construct($context);
        $this->factHttpResponse = $factHttpResponse;
        $this->hlpCfg = $hlpCfg;
        $this->srvReportSave = $srvReportSave;
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        // all request are allowed, so we no need to have this implementation
    }

    public function execute()
    {
        if ($this->hlpCfg->getEnabled()) {
            // Read POSTed data and convert it into PHP object.
            $rawBody = file_get_contents('php://input');
            $data = json_decode($rawBody);
            if (isset($data->{'csp-report'})) {
                $req = new \Flancer32\Csp\Service\Report\Save\Request();
                $req->setIsAdmin(false);
                $req->setReport($data->{'csp-report'});
                $this->srvReportSave->execute($req);
            }
        }
        // ... then create NO_CONTENT response
        /** @var \Magento\Framework\App\Response\Http $result */
        $result = $this->factHttpResponse->create();
        $result->setHttpResponseCode(self::HTTP_NO_CONTENT);
        $result->setPublicHeaders(0);
        return $result;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
