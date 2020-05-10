<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Web;


use Flancer32\Csp\Api\Web\Report\Request as ARequest;
use Flancer32\Csp\Api\Web\Report\Response as AResponse;

class Report
    implements \Flancer32\Csp\Api\Web\ReportInterface
{
    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function exec($request)
    {
        assert($request instanceof ARequest);
        $result = new AResponse();
        $this->logger->debug("Oppa!");
        return $result;
    }
}
