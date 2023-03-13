<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Api\Repo\Data;

/**
 * CSP rule.
 */
class Rule
    extends \Magento\Framework\DataObject
{
    const ADMIN_AREA = 'admin_area';
    const DATE = 'date';
    const ENABLED = 'enabled';
    const ID = 'id';
    const SOURCE = 'source';
    const TYPE_ID = 'type_id';
    const REASON = 'reason';

    /** @return boolean */
    public function getAdminArea()
    {
        $result = (boolean)parent::getData(self::ADMIN_AREA);
        return $result;
    }

    /** @return string */
    public function getDate()
    {
        $result = (string)parent::getData(self::DATE);
        return $result;
    }

    /** @return boolean */
    public function getEnabled()
    {
        $result = (boolean)parent::getData(self::ENABLED);
        return $result;
    }

    /** @return int */
    public function getId()
    {
        $result = (int)parent::getData(self::ID);
        return $result;
    }

    /** @return string */
    public function getSource()
    {
        $result = (string)parent::getData(self::SOURCE);
        return $result;
    }

    /** @return int */
    public function getTypeId()
    {
        $result = (int)parent::getData(self::TYPE_ID);
        return $result;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        $result = parent::getData(self::REASON);
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

    /**
     * @param string $data
     * @return void
     */
    public function setDate($data)
    {
        parent::setData(self::DATE, $data);
    }

    /**
     * @param boolean $data
     * @return void
     */
    public function setEnabled($data)
    {
        parent::setData(self::ENABLED, $data);
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
    public function setSource($data)
    {
        parent::setData(self::SOURCE, $data);
    }

    /**
     * @param int $data
     * @return void
     */
    public function setTypeId($data)
    {
        parent::setData(self::TYPE_ID, $data);
    }

    /**
     * @param string $data
     * @return void
     */
    public function setReason($data)
    {
        parent::setData(self::REASON, $data);
    }
}
