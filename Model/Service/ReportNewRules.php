<?php

namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Api\Data\Fl32RuleSentInterfaceFactory;
use Flancer32\Csp\Api\Fl32RuleSentRepositoryInterface;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DataObject;
use Psr\Log\LoggerInterface;

class ReportNewRules
{
    //Uses consecutive enumeration of ids to determine last sent
    //scheme: last sent -> read all successors -> prepare mail -> send -> insert entries into reports sent
    /**
     * @var HtmlFormatter
     */
    private $htmlFormatter;
    /**
     * @var DatabaseRule
     */
    private $ruleDataService;
    /**
     * @var Fl32RuleSentRepositoryInterface
     */
    private $fl32RuleSentRepository;
    /**
     * @var EmailSend
     */
    private $send;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Fl32RuleSentInterfaceFactory
     */
    private $fl32RuleSentFactory;

    public function __construct(
        DatabaseRule $ruleDataService,
        HtmlFormatter $htmlFormatter,
        Fl32RuleSentRepositoryInterface $fl32RuleSentRepository,
        Fl32RuleSentInterfaceFactory $fl32RuleSentFactory,
        EmailSend $send,
        Context $context)
    {
        $this->ruleDataService = $ruleDataService;
        $this->htmlFormatter = $htmlFormatter;
        $this->fl32RuleSentRepository = $fl32RuleSentRepository;
        $this->send = $send;
        $this->logger = $context->getLogger();
        $this->fl32RuleSentFactory = $fl32RuleSentFactory;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        $rulesToSend = $this->ruleDataService->getRulesToSend();

        if (!count($rulesToSend)) {
            return;
        }

        $reportHtmlRules = $this->htmlFormatter->renderNewRulesSection($rulesToSend);

        try {
            $recepients = $this->send->with($reportHtmlRules);
            $this->updateProtocolTables($rulesToSend, $recepients);
        } catch (\Exception $exception) {
            $this->logger->emergency($exception->getMessage());
        }
    }

    /**
     * extendable with new for-each blocks and parameters with different dataobject implementations
     * @param array $reportsToSend
     * @param Erule[]|DataObject[] $rulesSent
     * @param array $recepients
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function updateProtocolTables(array $rulesSent, array $recepients) {
        $recepientsSerialized = implode(',', $recepients);
        foreach ($rulesSent as $ruleSent) {
            /** @var \Flancer32\Csp\Api\Data\Fl32RuleSentInterface $Fl32RuleSent */
            $Fl32RuleSent = $this->fl32RuleSentFactory->create();
            $Fl32RuleSent->setFl32CspRuleId($ruleSent->getId());
            $Fl32RuleSent->setFl32CspRuleSentTo($recepientsSerialized);
            $this->fl32RuleSentRepository->save($Fl32RuleSent);
        }
    }

}
