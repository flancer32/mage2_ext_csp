<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Model\Config\Source;

class Area
    implements \Magento\Framework\Data\OptionSourceInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'Admin'],
            ['value' => 0, 'label' => 'Front'],
        ];
    }
}
