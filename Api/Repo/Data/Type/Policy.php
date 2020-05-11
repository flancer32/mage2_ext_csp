<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Api\Repo\Data\Type;

/**
 * CSP policy types codifier.
 */
class Policy
    extends \Magento\Framework\DataObject
{
    const ID = 'id';
    const KEY = 'key';


    /** @return int */
    public function getId()
    {
        $result = (int)parent::getData(self::ID);
        return $result;
    }

    /** @return string */
    public function getKey()
    {
        $result = (string)parent::getData(self::KEY);
        return $result;
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
    public function setKey($data)
    {
        parent::setData(self::KEY, $data);
    }
}
