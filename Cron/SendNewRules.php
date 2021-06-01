<?php
declare(strict_types=1);

namespace Flancer32\Csp\Cron;

class SendNewRules
{

    protected $logger;
    /**
     * @var Flancer32\Csp\Model\Service\ReportNewRules
     */
    private $reportNewRules;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Flancer32\Csp\Model\Service\ReportNewRules $reportNewRules
    )
    {
        $this->logger = $logger;
        $this->reportNewRules = $reportNewRules;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob SendReportsAndRules is executed.");
        $this->reportNewRules->execute();
    }

}

