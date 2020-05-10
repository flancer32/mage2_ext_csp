<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Api\Web;

/**
 * Save CSP violation report.
 */
interface ReportInterface
{
    /**
     * @param \Flancer32\Csp\Api\Web\Report\Request $request
     * @return \Flancer32\Csp\Api\Web\Report\Response
     *
     * Magento 2 WebAPI requires full names in documentation (aliases are not allowed).
     */
    public function exec($request);
}
