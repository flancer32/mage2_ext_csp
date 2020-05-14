<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Test\Flancer32\Csp\Model\Collector;

include_once(__DIR__ . '/../../phpunit_bootstrap.php');

class DbTest
    extends \PHPUnit\Framework\TestCase
{
    /** @var \Flancer32\Csp\Model\Collector\Db */
    private $obj;

    protected function setUp()
    {
        /** Get object to test */
        $obm = \Magento\Framework\App\ObjectManager::getInstance();
        $this->obj = $obm->get(\Flancer32\Csp\Model\Collector\Db::class);
    }


    public function test_all()
    {
        $res = $this->obj->collect([]);
        $this->assertTrue(is_array($res));
    }
}
