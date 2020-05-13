<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Model\Collector\Db\A\Query;

use Flancer32\Csp\Api\Repo\Data\Rule as ERule;
use Flancer32\Csp\Api\Repo\Data\Type\Policy as EType;

class GetRules
    implements \Flancer32\Base\Api\Repo\Query\Select
{
    /** Tables aliases for external usage ('camelCase' naming) */
    const AS_RULE = 'rule';
    const AS_TYPE = 'type';

    /** Columns/expressions aliases for external usage ('camelCase' naming) */
    const A_AREA = 'area';
    const A_SOURCE = 'source';
    const A_TYPE = 'type';

    /** Entities are used in the query (table names w/o prefix) */
    const E_RULE = \Flancer32\Csp\Api\Repo\Dao\Rule::ENTITY_NAME;
    const E_TYPE = \Flancer32\Csp\Api\Repo\Dao\Type\Policy::ENTITY_NAME;


    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    private $conn; // default connection

    /** @var \Magento\Framework\App\ResourceConnection */
    private $resource;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
        $this->conn = $resource->getConnection();
    }

    public function build($source = null)
    {
        /* this is root query builder (started from SELECT) */
        $result = $this->conn->select();
        /* define tables aliases for internal usage (in this method) */
        $asRule = self::AS_RULE;
        $asType = self::AS_TYPE;

        /* FROM fl32_csp_rule (FROM - for root builder, JOIN - for $source chained builder) */
        $tbl = $this->resource->getTableName(self::E_RULE);    // name with prefix
        $as = $asRule;    // alias for 'current table' (currently processed in this block of code)
        $cols = [
            self::A_AREA => ERule::ADMIN_AREA,
            self::A_SOURCE => ERule::SOURCE
        ];
        $result->from([$as => $tbl], $cols);    // standard names for the variables

        /* LEFT JOIN fl32_csp_type_policy */
        $tbl = $this->resource->getTableName(self::E_TYPE);
        $as = $asType;
        $cols = [
            self::A_TYPE => EType::KEY
        ];
        $cond = "$as." . EType::ID . "=$asRule." . ERule::TYPE_ID;
        $result->joinLeft([$as => $tbl], $cond, $cols);

        /* WHERE */
        $byEnabled = "$asRule." . ERule::ENABLED . "=TRUE";
        $result->where($byEnabled);

        return $result;
    }
}
