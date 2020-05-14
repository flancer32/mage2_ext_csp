<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report\Save;


class Request
    extends \Magento\Framework\DataObject
{
    const IS_ADMIN = 'is_admin';
    const REPORT = 'report';

    /** @return boolean */
    public function getIsAdmin()
    {
        $result = (boolean)parent::getData(self::IS_ADMIN);
        return $result;
    }

    /** @return \stdClass */
    public function getReport()
    {
        $result = parent::getData(self::REPORT);
        return $result;
    }

    /**
     * @param boolean $data
     * @return void
     */
    public function setIsAdmin($data)
    {
        parent::setData(self::IS_ADMIN, $data);
    }

    /**
     * @param \stdClass $data
     * @return void
     */
    public function setReport($data)
    {
        parent::setData(self::REPORT, $data);
    }
}
