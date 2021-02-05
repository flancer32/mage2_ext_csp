<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model\ResourceModel\Fl32RuleSent;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'fl32_csp_rule_sent_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Flancer32\Csp\Model\Fl32RuleSent::class,
            \Flancer32\Csp\Model\ResourceModel\Fl32RuleSent::class
        );
    }
}

