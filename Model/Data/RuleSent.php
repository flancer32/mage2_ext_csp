<?php
declare(strict_types=1);

namespace Flancer32\Csp\Model\Data;

use Flancer32\Csp\Api\Data\RuleSentInterface;

class RuleSent extends \Magento\Framework\Api\AbstractExtensibleObject implements RuleSentInterface
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
     * @param string $ruleSentId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleSentId($ruleSentId)
    {
        return $this->setData(self::FL32_CSP_RULE_SENT_ID, $ruleSentId);
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
     * @param string $ruleId
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleId($ruleId)
    {
        return $this->setData(self::FL32_CSP_RULE_ID, $ruleId);
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
     * @param string $ruleSentTo
     * @return \Flancer32\Csp\Api\Data\RuleSentInterface
     */
    public function setFl32CspRuleSentTo($ruleSentTo)
    {
        return $this->setData(self::FL32_CSP_RULE_SENT_TO, $ruleSentTo);
    }
}

