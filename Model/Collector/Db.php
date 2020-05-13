<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Model\Collector;
use Flancer32\Csp\Model\Collector\Db\A\Query\GetRules as QGetRules;

/**
 * Collect policy rules from DB.
 */
class Db
    implements \Magento\Csp\Api\PolicyCollectorInterface
{
    /** @var \Flancer32\Csp\Model\Collector\Db\A\Query\GetRules */
    private $aQGetRules;

    public function __construct(
        \Flancer32\Csp\Model\Collector\Db\A\Query\GetRules $aQGetRules
    ) {
        $this->aQGetRules = $aQGetRules;
    }

    public function collect(array $defaultPolicies = []): array
    {
        $rules = $this->getRules();
        foreach ($rules as $rule) {
            $id = $rule[QGetRules::A_TYPE];
            $source = $rule[QGetRules::A_SOURCE];
            $policy = new \Magento\Csp\Model\Policy\FetchPolicy($id, false, [$source]);
            $defaultPolicies[] = $policy;
        }
        return $defaultPolicies;
    }

    private function getRules()
    {
        $query = $this->aQGetRules->build();
        $conn = $query->getConnection();
        $result = $conn->fetchAll($query);
        return $result;
    }
}
