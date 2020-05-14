<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Api\Repo\Data;

/**
 * CSP violations reports (raw data).
 */
class Report
    extends \Magento\Framework\DataObject
{
    const ADMIN_AREA = 'admin_area';
    const DATE = 'date';
    const ID = 'id';
    const REPORT = 'report';

    /** @return boolean */
    public function getAdminArea()
    {
        $result = (boolean)parent::getData(self::ADMIN_AREA);
        return $result;
    }

    /**
     * @param boolean $data
     * @return void
     */
    public function setAdminArea($data)
    {
        parent::setData(self::ADMIN_AREA, $data);
    }

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
