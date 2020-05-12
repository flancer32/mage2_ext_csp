<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report\Analyze\A;

class GetReports
    implements \Flancer32\Base\Api\Repo\Query\Select
{

    /** Tables aliases for external usage ('camelCase' naming) */
    const AS_ODOO_LOT = 'odooLot';

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
        // TODO: Implement build() method.
    }
}
