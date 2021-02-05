<?php
namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Model\ResourceModel\Fl32RuleSent;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;

class DatabaseRule extends \Flancer32\Csp\Ui\DataProvider\Rule\Grid
{
    /**
     * @var Fl32RuleSent
     */
    private $fl32RuleSentResourceModel;
    /**
     * @var \Flancer32\Csp\Repo\Dao\Rule
     */
    private $ruleRepository;

    public function __construct(\Magento\Framework\App\ResourceConnection $resource,
        Fl32RuleSent $fl32RuleSentResourceModel,
        \Flancer32\Csp\Repo\Dao\Rule $ruleRepository)
    {
        $this->fl32RuleSentResourceModel = $fl32RuleSentResourceModel;
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * @return ERule[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public  function getRulesToSend(): array {
        /** @var ERule[] $fromRepository */
        return $this->ruleRepository->getSet($where = ERule::ID . '>' . $this->fl32RuleSentResourceModel->getMaxIdRuleSent());
    }


}
