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
    /**
     * We should not ise use CSP Level 3 directives to prevent "Refused to execute inline script ..." warnings
     */
    private const MAP_LEVEL3_TO_LEVEL2 = [
        'script-src-attr' => 'script-src',
        'script-src-elem' => 'script-src',
        'style-src-attr' => 'style-src',
        'style-src-elem' => 'style-src',
    ];
    /** @var \Flancer32\Csp\Model\Collector\Db\A\Query\GetRules */
    private $aQGetRules;
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;

    public function __construct(
        \Flancer32\Csp\Helper\Config $hlpCfg,
        \Flancer32\Csp\Model\Collector\Db\A\Query\GetRules $aQGetRules
    ) {
        $this->hlpCfg = $hlpCfg;
        $this->aQGetRules = $aQGetRules;
    }

    public function collect(array $defaultPolicies = []): array
    {
        if ($this->hlpCfg->getEnabled()) {
            $rules = $this->getRules();
            foreach ($rules as $rule) {
                $id = $rule[QGetRules::A_TYPE];
                $source = $rule[QGetRules::A_SOURCE];
                $policy = new \Magento\Csp\Model\Policy\FetchPolicy($id, false, [$source]);
                $defaultPolicies[] = $policy;
            }
        }
        return $defaultPolicies;
    }

    private function getRules()
    {
        $query = $this->aQGetRules->build();
        $conn = $query->getConnection();
        $all = $conn->fetchAll($query);
        // map Level 3 directives to Level 2.
        $result = [];
        foreach ($all as $one) {
            $id = $one[QGetRules::A_TYPE];
            if (isset(self::MAP_LEVEL3_TO_LEVEL2[$id])) {
                $one[QGetRules::A_TYPE] = self::MAP_LEVEL3_TO_LEVEL2[$id];
            }
            $result[] = $one;
        }
        return $result;
    }
}
