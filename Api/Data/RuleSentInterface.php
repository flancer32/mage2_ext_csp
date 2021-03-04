<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api\Data;

interface RuleSentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const FL32_CSP_RULE_SENT_TO = 'fl32_csp_rule_sent_to';
    const FL32_CSP_RULE_SENT_ID = 'fl32_csp_rule_sent_id';
    const FL32_CSP_RULE_ID      = 'fl32_csp_rule_id';

    /**
     * Get fl_32_rule_sent_id
     * @return string|null
     */
    public function getFl32CspRuleSentId();

    /**
     * Set fl32_csp_rule_sent_id
     * @param string $ruleSentId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleSentId($ruleSentId);

    /**
     * Get fl32_csp_rule_id
     * @return string|null
     */
    public function getFl32CspRuleId();

    /**
     * Set fl32_csp_rule_id
     * @param string $ruleId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleId($ruleId);

    /**
     * Get fl32_csp_rule_sent_to
     * @return string|null
     */
    public function getFl32CspRuleSentTo();

    /**
     * Set fl32_csp_rule_sent_to
     * @param string $ruleSentTo
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleSentTo($ruleSentTo);
}

