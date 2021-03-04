<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model\ResourceModel;

class RuleSent extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('fl32_csp_rule_sent', 'fl32_csp_rule_sent_id');
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMaxIdRuleSent(): int
    {
        /** @var \Magento\Framework\DB\Select $select */
        $select = $this->getConnection()->select();
        $tableName = $this->getMainTable();
        $cols = [
            'MAX(fl32_csp_rule_id)',
        ];
        $select->from($tableName, $cols);
        $maxId = 0;
        try {
            $maxId = (int)$this->getConnection()->fetchOne($select);
        } catch (\Exception $exception) {
            //ignore
        }
        return $maxId;
    }
}

