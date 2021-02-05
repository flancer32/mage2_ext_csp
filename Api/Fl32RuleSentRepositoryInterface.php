<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface Fl32RuleSentRepositoryInterface
{

    /**
     * Save fl_32_rule_sent
     * @param \Flancer32\Csp\Api\Data\Fl32RuleSentInterface $fl32RuleSent
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Flancer32\Csp\Api\Data\Fl32RuleSentInterface $fl32RuleSent
    );

    /**
     * Retrieve fl_32_rule_sent
     * @param string $fl32RuleSentId
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($fl32RuleSentId);

    /**
     * Retrieve fl_32_rule_sent matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete fl_32_rule_sent
     * @param \Flancer32\Csp\Api\Data\Fl32RuleSentInterface $fl32RuleSent
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Flancer32\Csp\Api\Data\Fl32RuleSentInterface $fl32RuleSent
    );

    /**
     * Delete fl_32_rule_sent by ID
     * @param string $fl32RuleSentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($fl32RuleSentId);
}

