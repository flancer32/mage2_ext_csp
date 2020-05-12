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

    public function __construct()
    {
        parent::__construct(self::NAME, self::DESC);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* parse and validate input data */

        $output->writeln("<info>Command '" . $this->getName() . "': " . $this->getDescription() . "<info>");
        $this->checkAreaCode();

        $output->writeln('<info>Command \'' . $this->getName() . '\' is completed.<info>');
    }

}
