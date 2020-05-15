<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Cron;

/**
 * Analyze CSP violation reports and create policy rules.
 */
class Analyze
{
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Psr\Log\LoggerInterface */
    private $logger;
    /** @var \Magento\Framework\App\ResourceConnection */
    private $resource;
    /** @var \Flancer32\Csp\Service\Report\Analyze */
    private $srvAnalyze;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\ResourceConnection $resource,
        \Flancer32\Csp\Helper\Config $hlpCfg,
        \Flancer32\Csp\Service\Report\Analyze $srvAnalyze
    ) {
        $this->logger = $logger;
        $this->resource = $resource;
        $this->hlpCfg = $hlpCfg;
        $this->srvAnalyze = $srvAnalyze;
    }

    public function execute()
    {
        $enabled = $this->hlpCfg->getCronEnabled();
        if ($enabled) {
            $conn = $this->resource->getConnection();
            $conn->beginTransaction();
            $req = new \Flancer32\Csp\Service\Report\Analyze\Request();
            $resp = $this->srvAnalyze->execute($req);
            $conn->commit();
            $added = $resp->getRulesAdded();
            $deleted = $resp->getReportsDeleted();
            $min = $resp->getReportsIdMin();
            $max = $resp->getReportsIdMax();
            if ($deleted) {
                $this->logger->debug("CSP analyze (cron): $added rules were added, $deleted reports were deleted (id: $min-$max).");
            }
        }
    }
}
