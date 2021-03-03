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
    public function getCspRuleSentId();

    /**
     * Set fl32_csp_rule_sent_id
     * @param string $ruleSentId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleSentId($ruleSentId);

    /**
     * Get fl32_csp_rule_id
     * @return string|null
     */
    public function getCspRuleId();

    /**
     * Set fl32_csp_rule_id
     * @param string $ruleId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleId($ruleId);

    /**
     * Get fl32_csp_rule_sent_to
     * @return string|null
     */
    public function getCspRuleSentTo();

    /**
     * Set fl32_csp_rule_sent_to
     * @param string $ruleSentTo
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleSentTo($ruleSentTo);
}

