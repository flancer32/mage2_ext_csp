<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report;


class Save
{
    /** @var \Flancer32\Csp\Api\Repo\Dao\Report */
    private $daoReport;

    public function __construct(
        \Flancer32\Csp\Api\Repo\Dao\Report $daoReport
    ) {
        $this->daoReport = $daoReport;
    }

    /**
     * @param \Flancer32\Csp\Service\Report\Save\Request $request
     * @return \Flancer32\Csp\Service\Report\Save\Response
     */
    public function execute($request)
    {
        assert($request instanceof \Flancer32\Csp\Service\Report\Save\Request);
        $result = new \Flancer32\Csp\Service\Report\Save\Response();
        $isAdminArea = $request->getIsAdmin();
        // remove original policy to save space in DB
        $report = $request->getReport();
        if (isset($report->{'original-policy'})) {
            unset($report->{'original-policy'});
        }
        $json = json_encode($report, JSON_UNESCAPED_SLASHES);
        $this->save($json, $isAdminArea);
        return $result;
    }

    private function save($json, $isAdmin)
    {
        $report = new \Flancer32\Csp\Api\Repo\Data\Report();
        $report->setAdminArea($isAdmin);
        $report->setReport($json);
        $this->daoReport->create($report);
    }
}
