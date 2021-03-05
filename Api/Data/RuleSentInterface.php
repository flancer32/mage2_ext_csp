<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api\Data;

interface RuleSentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CSP_RULE_SENT_TO = 'csp_rule_sent_to';
    const CSP_RULE_SENT_ID = 'csp_rule_sent_id';
    const CSP_RULE_ID      = 'csp_rule_id';

    /**
     * Get fl_32_rule_sent_id
     * @return string|null
     */
    public function getCspRuleSentId();

    /**
     * Set csp_rule_sent_id
     * @param string $ruleSentId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleSentId($ruleSentId);

    /**
     * Get csp_rule_id
     * @return string|null
     */
    public function getCspRuleId();

    /**
     * Set csp_rule_id
     * @param string $ruleId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleId($ruleId);

    /**
     * Get csp_rule_sent_to
     * @return string|null
     */
    public function getCspRuleSentTo();

    /**
     * Set csp_rule_sent_to
     * @param string $ruleSentTo
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setCspRuleSentTo($ruleSentTo);
}

