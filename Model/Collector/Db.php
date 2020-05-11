<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Model\Collector;

/**
 * Collect policy rules from DB.
 */
class Db
    implements \Magento\Csp\Api\PolicyCollectorInterface
{

    public function collect(array $defaultPolicies = []): array
    {
        $policy = new \Magento\Csp\Model\Policy\FetchPolicy(
            'img-src',
            false,
            ['*.medium.com']
        );
        $defaultPolicies[] = $policy;
        return $defaultPolicies;
    }
}
