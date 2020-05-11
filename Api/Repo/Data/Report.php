<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Api\Repo\Data;

/**
 * Log for login events.
 */
class Report
    extends \Magento\Framework\DataObject
{
    const DATE = 'date';
    const ID = 'id';
    const REPORT = 'report';

    /** @return string */
    public function getDate()
    {
        $result = (string)parent::getData(self::DATE);
        return $result;
    }

    /** @return int */
    public function getId()
    {
        $result = (int)parent::getData(self::ID);
        return $result;
    }

    /** @return string */
    public function getReport()
    {
        $result = (string)parent::getData(self::REPORT);
        return $result;
    }

    /**
     * @param string $data
     * @return void
     */
    public function setDate($data)
    {
        parent::setData(self::DATE, $data);
    }

    /**
     * @param int $data
     * @return void
     */
    public function setId($data)
    {
        parent::setData(self::ID, $data);
    }

    /**
     * @param string $data
     * @return void
     */
    public function setReport($data)
    {
        parent::setData(self::REPORT, $data);
    }
}
