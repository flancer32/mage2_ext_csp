<?php


namespace Flancer32\Csp\Service\Report;


class Save
{
    /** @var \Flancer32\Csp\Api\Repo\Dao\Report */
    private $repoReport;

    public function __construct(
        \Flancer32\Csp\Api\Repo\Dao\Report $repoReport
    ) {
        $this->repoReport = $repoReport;
    }

    /**
     * @param \Flancer32\Csp\Service\Report\Save\Request $request
     * @return \Flancer32\Csp\Service\Report\Save\Response
     */
    public function execute($request)
    {
        assert($request instanceof \Flancer32\Csp\Service\Report\Save\Request);
        $result = new \Flancer32\Csp\Service\Report\Save\Response();
        $report = $request->getReport();
        if (isset($report->{'original-policy'})) {
            unset($report->{'original-policy'});
        }
        $json = json_encode($report, JSON_UNESCAPED_SLASHES);
        $this->save($json);
        return $result;
    }

    private function save($json)
    {
        $report = new \Flancer32\Csp\Api\Repo\Data\Report();
        $report->setReport($json);
        $this->repoReport->create($report);
    }
}
