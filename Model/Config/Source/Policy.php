<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Model\Config\Source;

class Policy
    implements \Magento\Framework\Data\OptionSourceInterface
{
    private $cache;
    /** @var \Flancer32\Csp\Api\Repo\Dao\Type\Policy */
    private $daoPolicy;

    public function __construct(
        \Flancer32\Csp\Api\Repo\Dao\Type\Policy $daoPolicy
    ) {
        $this->daoPolicy = $daoPolicy;
    }

    public function toOptionArray()
    {
        if (is_null($this->cache)) {
            $all = $this->daoPolicy->getSet();
            $this->cache = [];
            foreach ($all as $one) {
                $this->cache[] = ['value' => $one->getId(), 'label' => $one->getKey()];
            }
            usort($this->cache, function ($a, $b) {
                return strcasecmp($a['label'], $b['label']);
            });
        }
        return $this->cache;
    }
}
