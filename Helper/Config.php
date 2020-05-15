<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface as AScopeCfg;

/**
 * Helper to get store configuration parameters related to the module.
 *
 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
 */
class Config
{
    /** @var \Magento\Framework\App\State */
    private $appState;
    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\State $appState
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
    }

    /**
     * Cron activity.
     *
     * @param string $scopeType
     * @param string $scopeCode
     * @return bool
     */
    public function getCronEnabled($scopeType = AScopeCfg::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $result = $this->getEnabled($scopeType, $scopeCode);
        if ($result) {
            $result = $this->scopeConfig->getValue('fl32_csp/cron/enabled', $scopeType, $scopeCode);
            $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        }
        return $result;
    }

    /**
     * Activity of the module.
     *
     * @param string $scopeType
     * @param string $scopeCode
     * @return bool
     */
    public function getEnabled($scopeType = AScopeCfg::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $result = $this->scopeConfig->getValue('fl32_csp/general/enabled', $scopeType, $scopeCode);
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

    /**
     * Should new rules be active by default?
     *
     * @param string $scopeType
     * @param string $scopeCode
     * @return bool
     */
    public function getRulesNewAreActive($scopeType = AScopeCfg::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $result = $this->getEnabled($scopeType, $scopeCode);
        if ($result) {
            $result = $this->scopeConfig->getValue('fl32_csp/rules/new_rules_active', $scopeType, $scopeCode);
            $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        }
        return $result;
    }

    /**
     * Use 'Content-Security-Policy-Report-Only' or 'Content-Security-Policy'.
     *
     * @param string $scopeType
     * @param string $scopeCode
     * @return bool
     */
    public function getRulesReportOnly($scopeType = AScopeCfg::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $result = $this->getEnabled($scopeType, $scopeCode);
        if ($result) {
            $result = $this->scopeConfig->getValue('fl32_csp/rules/report_only', $scopeType, $scopeCode);
            $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        }
        return $result;
    }

}
