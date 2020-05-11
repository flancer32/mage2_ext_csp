<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report\Save;


class Request
    extends \Magento\Framework\DataObject
{
    const REPORT = 'report';

    /** @return \stdClass */
    public function getReport()
    {
        $result = parent::getData(self::REPORT);
        return $result;
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
