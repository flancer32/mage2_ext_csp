<?php

namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Api\Data\Fl32RuleSentInterfaceFactory;
use Flancer32\Csp\Api\RuleSentRepositoryInterface;
use Flancer32\Csp\Api\Repo\Data\Rule;
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
     * @var GetRulesToSend
     */
    private $getRulesToSend;
    /**
     * @var RuleSentRepositoryInterface
     */
    private $fl32RuleSentRepository;
    /**
     * @var SendEmail
     */
    private $sendEmail;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Fl32RuleSentInterfaceFactory
     */
    private $fl32RuleSentFactory;

    public function __construct(
        GetRulesToSend $getRulesToSend,
        HtmlFormatter $htmlFormatter,
        RuleSentRepositoryInterface $fl32RuleSentRepository,
        Fl32RuleSentInterfaceFactory $fl32RuleSentFactory,
        SendEmail $sendEmail,
        Context $context)
    {
        $this->getRulesToSend = $getRulesToSend;
        $this->htmlFormatter = $htmlFormatter;
        $this->fl32RuleSentRepository = $fl32RuleSentRepository;
        $this->sendEmail = $sendEmail;
        $this->logger = $context->getLogger();
        $this->fl32RuleSentFactory = $fl32RuleSentFactory;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function execute(bool $throwException = false)
    {
        $rulesToSend = $this->getRulesToSend->execute();

        if (!count($rulesToSend)) {
            return;
        }

        $reportHtmlRules = $this->htmlFormatter->renderNewRulesSection($rulesToSend);

        try {
            $recepients = $this->sendEmail->with($reportHtmlRules);
            $this->updateProtocolTables($rulesToSend, $recepients);
        } catch (\Exception $exception) {
            $this->logger->emergency($exception->getMessage());
            if ($throwException) {
                throw $exception;
            }
        }
    }

    /**
     * extendable with new for-each blocks and parameters with different dataobject implementations
     * @param array $reportsToSend
     * @param Rule[]|DataObject[] $rulesSent
     * @param array $recepients
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function updateProtocolTables(array $rulesSent, array $recepients)
    {
        $recepientsSerialized = implode(',', $recepients);
        foreach ($rulesSent as $ruleSent) {
            /** @var \Flancer32\Csp\Api\Data\RuleSentInterface $Fl32RuleSent */
            $Fl32RuleSent = $this->fl32RuleSentFactory->create();
            $Fl32RuleSent->setCspRuleId($ruleSent->getId());
            $Fl32RuleSent->setCspRuleSentTo($recepientsSerialized);
            $this->fl32RuleSentRepository->save($Fl32RuleSent);
        }
    }

}
