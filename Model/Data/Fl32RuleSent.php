<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model\Data;

use Flancer32\Csp\Api\Data\Fl32RuleSentInterface;

class Fl32RuleSent extends \Magento\Framework\Api\AbstractExtensibleObject implements Fl32RuleSentInterface
{

    /**
     * Get fl32_csp_rule_sent_id
     * @return string|null
     */
    public function getFl32CspRuleSentId()
    {
        return $this->_get(self::FL32_CSP_RULE_SENT_ID);
    }

    /**
     * Set fl32_csp_rule_sent_id
     * @param string $fl32RuleSentId
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleSentId($fl32RuleSentId)
    {
        return $this->setData(self::FL32_CSP_RULE_SENT_ID, $fl32RuleSentId);
    }

    /**
     * Get fl32_csp_rule_id
     * @return string|null
     */
    public function getFl32CspRuleId()
    {
        return $this->_get(self::FL32_CSP_RULE_ID);
    }

    /**
     * Set fl32_csp_rule_id
     * @param string $fl32RuleId
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleId($fl32RuleId)
    {
        return $this->setData(self::FL32_CSP_RULE_ID, $fl32RuleId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Flancer32\Csp\Api\Data\Fl32RuleSentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get fl32_csp_rule_sent_to
     * @return string|null
     */
    public function getFl32CspRuleSentTo()
    {
        return $this->_get(self::FL32_CSP_RULE_SENT_TO);
    }

    /**
     * Set fl32_csp_rule_sent_to
     * @param string $fl32RuleSentTo
     * @return \Flancer32\Csp\Api\Data\Fl32RuleSentInterface
     */
    public function setFl32CspRuleSentTo($fl32RuleSentTo)
    {
        return $this->setData(self::FL32_CSP_RULE_SENT_TO, $fl32RuleSentTo);
    }
}

