<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Cli;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Analyze CSP violation reports and compose policy rules.
 */
class Analyze
    extends \Flancer32\Base\App\Cli\Base
{
    private const DESC = 'Analyze CSP violation reports and compose policy rules.';
    private const NAME = 'fl32:csp:analyze';
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Magento\Framework\App\ResourceConnection */
    private $resource;
    /** @var \Flancer32\Csp\Service\Report\Analyze */
    private $srvAnalyze;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Flancer32\Csp\Helper\Config $hlpCfg,
        \Flancer32\Csp\Service\Report\Analyze $srvAnalyze
    ) {
        parent::__construct(self::NAME, self::DESC);
        $this->resource = $resource;
        $this->hlpCfg = $hlpCfg;
        $this->srvAnalyze = $srvAnalyze;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* parse and validate input data */

        $output->writeln("<info>Command '" . $this->getName() . "': " . $this->getDescription() . "<info>");
        $this->checkAreaCode();
        if ($this->hlpCfg->getEnabled()) {
            $conn = $this->resource->getConnection();
            $conn->beginTransaction();
            $req = new \Flancer32\Csp\Service\Report\Analyze\Request();
            $resp = $this->srvAnalyze->execute($req);
            $conn->commit();
            $added = $resp->getRulesAdded();
            $deleted = $resp->getReportsDeleted();
            $min = $resp->getReportsIdMin();
            $max = $resp->getReportsIdMax();
            $output->writeln("<info>$added rules were added. $deleted reports were deleted (id: $min-$max).<info>");
        } else {
            $output->writeln("<info>CSP reports processing is disabled. "
                . "Please, enable it at 'Configuration / Security / CSP / General / Enable'.<info>");
        }
        $output->writeln('<info>Command \'' . $this->getName() . '\' is completed.<info>');
    }

}
