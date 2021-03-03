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
class SendReports extends \Flancer32\Base\App\Cli\Base
{
    private const DESC = 'reports new rules to specified mail addresses and registers reported rules persistently in protocol table';
    private const NAME = 'fl32:csp:report_new_rules';

    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /**
     * @var \Flancer32\Csp\Model\Service\ReportNewRules
     */
    private $reportNewRules;

    public function __construct(
        Flancer32\Csp\Helper\Config\Proxy $hlpCfg,
        Flancer32\Csp\Model\Service\ReportNewRules\Proxy $reportNewRules)
    {
        parent::__construct(self::NAME, self::DESC);
        $this->reportNewRules = $reportNewRules;
        $this->hlpCfg = $hlpCfg;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* parse and validate input data */

        $output->writeln("<info>Command '" . $this->getName() . "': " . $this->getDescription() . "<info>");
        $this->checkAreaCode();
        if (!$this->hlpCfg->getEnabled()) {
            $output->writeln(
                "<info>CSP reports processing is disabled. "
                . "Please, enable it at 'Configuration / Security / CSP / General / Enable'.<info>"
            );
            return;
        }
        try {
            $this->reportNewRules->execute($throwException = true);
        } catch (\Exception $exception) {
            $output->writeln('<info>' . $exception->getMessage() . '<info>');
        }
        $output->writeln('<info>Command \'' . $this->getName() . '\' is completed.<info>');
    }
}
