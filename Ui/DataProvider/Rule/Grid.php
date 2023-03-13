<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Ui\DataProvider\Rule;

use Flancer32\Base\App\Repo\Query\Expression as Expression;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;

class Grid
    extends \Flancer32\Base\App\Repo\Query\Grid\Builder
{
    /** Tables aliases for external usage ('camelCase' naming) */
    const AS_RULE = 'r';

    /** Columns/expressions aliases for external usage ('CamelCase' naming) */
    const A_AREA = 'Area';
    const A_ENABLED = 'Enabled';
    const A_ID = 'Id';
    const A_POLICY_ID = 'PolicyId';
    const A_SOURCE = 'Source';
    const A_REASON = 'Reason';

    /** Entities are used in the query (table names w/o prefix) */
    const E_RULE = \Flancer32\Csp\Api\Repo\Dao\Rule::ENTITY_NAME;

    /** @var \Flancer32\Base\App\Repo\Query\ClauseSet\Processor\AliasMapEntry[] */
    private $mapAliases;

    public function getAliasMap()
    {
        if (is_null($this->mapAliases)) {
            $this->mapAliases = [
                self::A_AREA => $this->createAliasMapEntry(self::A_AREA, self::AS_RULE, ERule::ADMIN_AREA),
                self::A_ENABLED => $this->createAliasMapEntry(self::A_ENABLED, self::AS_RULE, ERule::ENABLED),
                self::A_ID => $this->createAliasMapEntry(self::A_ID, self::AS_RULE, ERule::ID),
                self::A_POLICY_ID => $this->createAliasMapEntry(self::A_POLICY_ID, self::AS_RULE, ERule::TYPE_ID),
                self::A_SOURCE => $this->createAliasMapEntry(self::A_SOURCE, self::AS_RULE, ERule::SOURCE),
                self::A_REASON => $this->createAliasMapEntry(self::A_REASON, self::AS_RULE, ERule::REASON)
            ];
        }
        return $this->mapAliases;
    }

    public function getCountQuery()
    {
        /* get query to select items */
        /** @var \Magento\Framework\DB\Select $result */
        $result = $this->getSelectQuery();
        /* ... then replace "columns" part with own expression */
        $value = 'COUNT(' . self::AS_RULE . '.' . ERule::ID . ')';

        /**
         * See method \Magento\Framework\DB\Select\ColumnsRenderer::render:
         */
        /**
         * if ($column instanceof \Zend_Db_Expr) {...}
         */
        $exp = new Expression($value);
        /**
         *  list($correlationName, $column, $alias) = $columnEntry;
         */
        $entry = [null, $exp, null];
        $cols = [$entry];
        $result->setPart('columns', $cols);
        return $result;
    }

    public function getSelectQuery()
    {
        $result = $this->conn->select();

        /* FROM fl32_csp_rule */
        $tbl = $this->resource->getTableName(self::E_RULE);
        $cols = [
            self::A_ID => ERule::ID,
            self::A_AREA => ERule::ADMIN_AREA,
            self::A_ENABLED => ERule::ENABLED,
            self::A_POLICY_ID => ERule::TYPE_ID,
            self::A_SOURCE => ERule::SOURCE,
            self::A_REASON => ERule::REASON
        ];
        $result->from([self::AS_RULE => $tbl], $cols);

        return $result;
    }
}
