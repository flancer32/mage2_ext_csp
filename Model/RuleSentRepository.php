<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model;

use Flancer32\Csp\Api\Data\RuleSentInterfaceFactory;
use Flancer32\Csp\Api\Data\RuleSentSearchResultsInterfaceFactory;
use Flancer32\Csp\Api\RuleSentRepositoryInterface;
use Flancer32\Csp\Model\ResourceModel\RuleSent as ResourceRuleSent;
use Flancer32\Csp\Model\ResourceModel\RuleSent\CollectionFactory as RuleSentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class RuleSentRepository implements RuleSentRepositoryInterface
{

    protected $ruleSentFactory;

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $dataRuleSentFactory;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $extensibleDataObjectConverter;

    protected $resource;

    private $storeManager;

    protected $ruleSentCollectionFactory;

    /**
     * @param ResourceRuleSent $resource
     * @param RuleSentFactory $ruleSentFactory
     * @param RuleSentInterfaceFactory $dataRuleSentFactory
     * @param RuleSentCollectionFactory $ruleSentCollectionFactory
     * @param RuleSentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceRuleSent $resource,
        RuleSentFactory $ruleSentFactory,
        RuleSentInterfaceFactory $dataRuleSentFactory,
        RuleSentCollectionFactory $ruleSentCollectionFactory,
        RuleSentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter)
    {
        $this->resource = $resource;
        $this->ruleSentFactory = $ruleSentFactory;
        $this->ruleSentCollectionFactory = $ruleSentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRuleSentFactory = $dataRuleSentFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent)
    {
        $ruleSentData = $this->extensibleDataObjectConverter->toNestedArray(
            $ruleSent,
            [],
            \Flancer32\Csp\Api\Data\RuleSentInterface::class
        );

        $ruleSentModel = $this->ruleSentFactory->create()->setData($ruleSentData);

        try {
            $this->resource->save($ruleSentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the fl32RuleSent: %1',
                    $exception->getMessage()
                )
            );
        }
        return $ruleSentModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($ruleSentId)
    {
        $ruleSent = $this->ruleSentFactory->create();
        $this->resource->load($ruleSent, $ruleSentId);
        if (!$ruleSent->getId()) {
            throw new NoSuchEntityException(__('fl32_csp_rule_sent with id "%1" does not exist.', $ruleSentId));
        }
        return $ruleSent->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $collection = $this->ruleSentCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Flancer32\Csp\Api\Data\RuleSentInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent)
    {
        try {
            $ruleSentModel = $this->ruleSentFactory->create();
            $this->resource->load($ruleSentModel, $ruleSent->getCspRuleSentId());
            $this->resource->delete($ruleSentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the fl32_csp_rule_sent: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($ruleSentId)
    {
        return $this->delete($this->get($ruleSentId));
    }
}

