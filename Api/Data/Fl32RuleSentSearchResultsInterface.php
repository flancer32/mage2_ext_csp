<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api\Data;

interface Fl32RuleSentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get fl32_csp_rule_sent list.
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface[]
     */
    public function getItems();

    /**
     * Set fl32_csp_rule_id list.
     * @param \Flancer32\Csp\Api\Data\Fl32RuleSentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

