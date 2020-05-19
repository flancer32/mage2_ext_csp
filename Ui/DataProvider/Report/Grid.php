<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Ui\DataProvider\Report;

use Flancer32\Csp\Api\Repo\Data\Report as EReport;

class Grid
    extends \Flancer32\Base\App\Repo\Query\Grid\Builder
{
    /** Tables aliases for external usage ('camelCase' naming) */
    const AS_REPORT = 'report';

    /** Columns/expressions aliases for external usage ('CamelCase' naming) */
    const A_AREA = 'Area';
    const A_DATE = 'Date';
    const A_ID = 'Id';
    const A_REPORT = 'Report';

    /** Entities are used in the query (table names w/o prefix) */
    const E_REPORT = \Flancer32\Csp\Api\Repo\Dao\Report::ENTITY_NAME;
    /** @var \Flancer32\Base\App\Repo\Query\ClauseSet\Processor\AliasMapEntry[] */
    private $mapAliases;

    public function getAliasMap()
    {
        if (is_null($this->mapAliases)) {
            $this->mapAliases = [
                self::A_AREA => $this->createAliasMapEntry(self::A_AREA, self::AS_REPORT, EReport::ADMIN_AREA),
                self::A_DATE => $this->createAliasMapEntry(self::A_DATE, self::AS_REPORT, EReport::DATE),
                self::A_ID => $this->createAliasMapEntry(self::A_ID, self::AS_REPORT, EReport::ID),
                self::A_REPORT => $this->createAliasMapEntry(self::A_REPORT, self::AS_REPORT, EReport::REPORT)
            ];
        }
        return $this->mapAliases;
    }

    public function getCountQuery()
    {
        $result = $this->conn->select();
        $tbl = $this->resource->getTableName(self::E_REPORT);    // name with prefix
        // compose COUNT() expression
        $total = 'COUNT(' . self::AS_REPORT . '.' . EReport::ID . ')';
        $exp = new \Flancer32\Base\App\Repo\Query\Expression($total);
        $cols = [$exp];
        $result->from([self::AS_REPORT => $tbl], $cols);
        return $result;
    }

    public function getSelectQuery()
    {
        $result = $this->conn->select();
        $tbl = $this->resource->getTableName(self::E_REPORT);    // name with prefix
        $cols = [
            self::A_ID => EReport::ID,
            self::A_DATE => EReport::DATE,
            self::A_AREA => EReport::ADMIN_AREA,
            self::A_REPORT => EReport::REPORT
        ];
        $result->from([self::AS_REPORT => $tbl], $cols);
        return $result;
    }
}
