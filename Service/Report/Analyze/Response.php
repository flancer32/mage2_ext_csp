<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report\Analyze;


class Response
    extends \Magento\Framework\DataObject
{
    const REPORTS_DELETED = 'reports_deleted';
    const REPORTS_ID_MAX = 'reports_id_max';
    const REPORTS_ID_MIN = 'reports_id_min';
    const RULES_ADDED = 'rules_added';

    /** @return int */
    public function getReportsDeleted()
    {
        $result = (int)parent::getData(self::REPORTS_DELETED);
        return $result;
    }

    /** @return int */
    public function getReportsIdMax()
    {
        $result = (int)parent::getData(self::REPORTS_ID_MAX);
        return $result;
    }

    /** @return int */
    public function getReportsIdMin()
    {
        $result = (int)parent::getData(self::REPORTS_ID_MIN);
        return $result;
    }

    /** @return int */
    public function getRulesAdded()
    {
        $result = (int)parent::getData(self::RULES_ADDED);
        return $result;
    }

    /**
     * @param int $data
     * @return void
     */
    public function setReportsDeleted($data)
    {
        parent::setData(self::REPORTS_DELETED, $data);
    }

    /**
     * @param int $data
     * @return void
     */
    public function setReportsIdMax($data)
    {
        parent::setData(self::REPORTS_ID_MAX, $data);
    }

    /**
     * @param int $data
     * @return void
     */
    public function setReportsIdMin($data)
    {
        parent::setData(self::REPORTS_ID_MIN, $data);
    }

    /**
     * @param int $data
     * @return void
     */
    public function setRulesAdded($data)
    {
        parent::setData(self::RULES_ADDED, $data);
    }
}
