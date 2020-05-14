<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Setup\Patch\Data;

use Flancer32\Csp\Config as Cfg;

/**
 * Add policy types to codifier.
 */
class InsertPolicyTypes
    implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /** @var \Flancer32\Csp\Api\Repo\Dao\Type\Policy */
    private $daoTypePolicy;
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Flancer32\Csp\Api\Repo\Dao\Type\Policy $daoTypePolicy
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->daoTypePolicy = $daoTypePolicy;
    }

    public function apply()
    {
        $directives = $this->getDirectives();
        foreach ($directives as $one) {
            $data = new \Flancer32\Csp\Api\Repo\Data\Type\Policy();
            $key = trim(strtolower($one));
            $data->setKey($key);
            $this->daoTypePolicy->create($data);
        }
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array CSP directives to save in 'fl32_csp_type_policy'
     */
    private function getDirectives()
    {
        $mage = \Magento\Csp\Model\Policy\FetchPolicy::POLICIES;
        $own = Cfg::CSP_DIRECTIVES;
        $merged = array_merge($own, $mage);
        $result = array_unique($merged);
        return $result;
    }
}
