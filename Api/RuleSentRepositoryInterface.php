<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RuleSentRepositoryInterface
{

    /**
     * Save fl_32_rule_sent
     * @param \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent
    );

    /**
     * Retrieve fl_32_rule_sent
     * @param string $ruleSentId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($ruleSentId);

    /**
     * Retrieve fl_32_rule_sent matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Flancer32\Csp\Api\Data\RuleSentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete fl_32_rule_sent
     * @param \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Flancer32\Csp\Api\Data\RuleSentInterface $ruleSent
    );

    /**
     * Delete fl_32_rule_sent by ID
     * @param string $ruleSentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ruleSentId);
}

