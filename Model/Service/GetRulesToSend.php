<?php

namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Model\ResourceModel\Fl32RuleSent;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;

class GetRulesToSend
{
    /**
     * @var Fl32RuleSent
     */
    private $ruleSentResourceModel;
    /**
     * @var \Flancer32\Csp\Repo\Dao\Rule
     */
    private $ruleRepository;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        Fl32RuleSent $RuleSentResourceModel,
        \Flancer32\Csp\Repo\Dao\Rule $ruleRepository)
    {
        $this->ruleSentResourceModel = $RuleSentResourceModel;
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * @return ERule[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): array
    {
        /** @var ERule[] $fromRepository */
        return $this->ruleRepository->getSet(
            $where = ERule::ID . '>' . $this->ruleSentResourceModel->getMaxIdRuleSent()
        );
    }
}
