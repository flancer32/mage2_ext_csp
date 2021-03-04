<?php

namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Api\Data\RuleSentInterfaceFactory;
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
    private $ruleSentRepository;
    /**
     * @var SendEmail
     */
    private $sendEmail;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var RuleSentInterfaceFactory
     */
    private $ruleSentFactory;

    public function __construct(
        GetRulesToSend $getRulesToSend,
        HtmlFormatter $htmlFormatter,
        RuleSentRepositoryInterface $ruleSentRepository,
        RuleSentInterfaceFactory $ruleSentFactory,
        SendEmail $sendEmail,
        Context $context)
    {
        $this->getRulesToSend = $getRulesToSend;
        $this->htmlFormatter = $htmlFormatter;
        $this->ruleSentRepository = $ruleSentRepository;
        $this->sendEmail = $sendEmail;
        $this->logger = $context->getLogger();
        $this->ruleSentFactory = $ruleSentFactory;
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
     * @param array $reportsToSend
     * @param Rule[]|DataObject[] $rulesSent
     * @param array $recepients
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function updateProtocolTables(array $rulesSent, array $recepients)
    {
        $recepientsSerialized = implode(',', $recepients);
        foreach ($rulesSent as $ruleSent) {
            /** @var \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent */
            $ruleSent = $this->ruleSentFactory->create();
            $ruleSent->setFl32CspRuleId($ruleSent->getId());
            $ruleSent->setFl32CspRuleSentTo($recepientsSerialized);
            $this->ruleSentRepository->save($ruleSent);
        }
    }

}
