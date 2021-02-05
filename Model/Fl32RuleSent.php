<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model;

use Flancer32\Csp\Api\Data\Fl32RuleSentInterface;
use Flancer32\Csp\Api\Data\Fl32RuleSentInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Fl32RuleSent extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'fl32_csp_rule_sent';
    protected $dataObjectHelper;

    protected $fl32_csp_rule_sentDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param Fl32RuleSentInterfaceFactory $fl32_csp_rule_sentDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Flancer32\Csp\Model\ResourceModel\Fl32RuleSent $resource
     * @param \Flancer32\Csp\Model\ResourceModel\Fl32RuleSent\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        Fl32RuleSentInterfaceFactory $fl32_csp_rule_sentDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Flancer32\Csp\Model\ResourceModel\Fl32RuleSent $resource,
        \Flancer32\Csp\Model\ResourceModel\Fl32RuleSent\Collection $resourceCollection,
        array $data = []
    ) {
        $this->fl32_csp_rule_sentDataFactory = $fl32_csp_rule_sentDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve fl32_csp_rule_sent model with fl32_csp_rule_sent data
     * @return Fl32RuleSentInterface
     */
    public function getDataModel()
    {
        $fl32_csp_rule_sentData = $this->getData();

        $fl32_csp_rule_sentDataObject = $this->fl32_csp_rule_sentDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $fl32_csp_rule_sentDataObject,
            $fl32_csp_rule_sentData,
            Fl32RuleSentInterface::class
        );

        return $fl32_csp_rule_sentDataObject;
    }
}

