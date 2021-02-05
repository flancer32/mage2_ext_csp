<?php
declare(strict_types=1);

namespace Flancer32\Csp\Api\Data;

interface Fl32RuleSentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
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
     * @param string $fl32RuleSentId
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleSentId($fl32RuleSentId);

    /**
     * Get fl32_csp_rule_id
     * @return string|null
     */
    public function getFl32CspRuleId();

    /**
     * Set fl32_csp_rule_id
     * @param string $fl32RuleId
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleId($fl32RuleId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface $extensionAttributes
    );

    /**
     * Get fl32_csp_rule_sent_to
     * @return string|null
     */
    public function getFl32CspRuleSentTo();

    /**
     * Set fl32_csp_rule_sent_to
     * @param string $fl32RuleSentTo
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleSentTo($fl32RuleSentTo);
}
