<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model;

use Flancer32\Csp\Api\Data\Fl32RuleSentInterfaceFactory;
use Flancer32\Csp\Api\Data\Fl32RuleSentSearchResultsInterfaceFactory;
use Flancer32\Csp\Api\RuleSentRepositoryInterface;
use Flancer32\Csp\Model\ResourceModel\Fl32RuleSent as ResourceFl32RuleSent;
use Flancer32\Csp\Model\ResourceModel\Fl32RuleSent\CollectionFactory as Fl32RuleSentCollectionFactory;
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

    protected $fl32RuleSentFactory;

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $dataFl32RuleSentFactory;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $extensibleDataObjectConverter;
    protected $resource;

    private $storeManager;

    protected $fl32RuleSentCollectionFactory;


    /**
     * @param ResourceFl32RuleSent $resource
     * @param Fl32RuleSentFactory $fl32RuleSentFactory
     * @param Fl32RuleSentInterfaceFactory $dataFl32RuleSentFactory
     * @param Fl32RuleSentCollectionFactory $fl32RuleSentCollectionFactory
     * @param Fl32RuleSentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceFl32RuleSent $resource,
        Fl32RuleSentFactory $fl32RuleSentFactory,
        Fl32RuleSentInterfaceFactory $dataFl32RuleSentFactory,
        Fl32RuleSentCollectionFactory $fl32RuleSentCollectionFactory,
        Fl32RuleSentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->fl32RuleSentFactory = $fl32RuleSentFactory;
        $this->fl32RuleSentCollectionFactory = $fl32RuleSentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataFl32RuleSentFactory = $dataFl32RuleSentFactory;
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
        \Flancer32\Csp\Api\Data\RuleSentInterface $fl32RuleSent
    ) {
        $fl32RuleSentData = $this->extensibleDataObjectConverter->toNestedArray(
            $fl32RuleSent,
            [],
            \Flancer32\Csp\Api\Data\RuleSentInterface::class
        );

        $fl32RuleSentModel = $this->fl32RuleSentFactory->create()->setData($fl32RuleSentData);

        try {
            $this->resource->save($fl32RuleSentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the fl32RuleSent: %1',
                $exception->getMessage()
            ));
        }
        return $fl32RuleSentModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($fl32RuleSentId)
    {
        $fl32RuleSent = $this->fl32RuleSentFactory->create();
        $this->resource->load($fl32RuleSent, $fl32RuleSentId);
        if (!$fl32RuleSent->getId()) {
            throw new NoSuchEntityException(__('fl32_csp_rule_sent with id "%1" does not exist.', $fl32RuleSentId));
        }
        return $fl32RuleSent->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->fl32RuleSentCollectionFactory->create();

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
        \Flancer32\Csp\Api\Data\RuleSentInterface $fl32RuleSent
    ) {
        try {
            $fl32RuleSentModel = $this->fl32RuleSentFactory->create();
            $this->resource->load($fl32RuleSentModel, $fl32RuleSent->getCspRuleSentId());
            $this->resource->delete($fl32RuleSentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the fl32_csp_rule_sent: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($fl32RuleSentId)
    {
        return $this->delete($this->get($fl32RuleSentId));
    }
}

