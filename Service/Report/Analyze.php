<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Service\Report;

use Flancer32\Csp\Api\Repo\Data\Report as EReport;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;

/**
 * Analyze CSP violations reports saved in DB and compose policy rules.
 */
class Analyze
{
    /** @var \Flancer32\Csp\Api\Repo\Dao\Report */
    private $daoReport;
    /** @var \Flancer32\Csp\Api\Repo\Dao\Rule */
    private $daoRule;
    /** @var \Flancer32\Csp\Api\Repo\Dao\Type\Policy */
    private $daoTypePolicy;
    /** @var \Flancer32\Csp\Helper\Config */
    private $hlpCfg;
    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Flancer32\Csp\Api\Repo\Dao\Report $daoReport,
        \Flancer32\Csp\Api\Repo\Dao\Rule $daoRule,
        \Flancer32\Csp\Api\Repo\Dao\Type\Policy $daoTypePolicy,
        \Flancer32\Csp\Helper\Config $hlpCfg
    ) {
        $this->logger = $logger;
        $this->daoReport = $daoReport;
        $this->daoRule = $daoRule;
        $this->daoTypePolicy = $daoTypePolicy;
        $this->hlpCfg = $hlpCfg;
    }

    /**
     * @param ERule[] $rules
     * @param boolean $enabled
     * @return int
     */
    private function addRules($rules, $enabled)
    {
        $result = 0;
        foreach ($rules as $rule) {
            $rule->setEnabled($enabled);
            $id = $this->daoRule->create($rule);
            if ($id) {
                $type = $rule->getTypeId();
                $source = $rule->getSource();
                $this->logger->debug("New CSP rule #$id is added: $type:$source.");
                $result++;
            }
        }
        return $result;
    }

    /**
     * Delete processed reports from DB.
     *
     * @param EReport[] $reports
     * @return array
     */
    private function clearReports($reports)
    {
        $minId = PHP_INT_MAX;
        $maxId = $deleted = 0;
        foreach ($reports as $one) {
            $id = $one->getId();
            if ($id < $minId) {
                $minId = $id;
            }
            if ($id > $maxId) {
                $maxId = $id;
            }
        }
        if ($minId <= $maxId) {
            $byMin = EReport::ID . '>=' . (int)$minId;
            $byMax = EReport::ID . '<=' . (int)$maxId;
            $deleted = $this->daoReport->deleteSet("($byMin) AND ($byMax)");
            $this->logger->debug("Total '$deleted' reports were deleted (id: $minId-$maxId).");
        } else {
            // there are no reports at all
            $minId = $maxId;
        }
        return [$deleted, $minId, $maxId];
    }

    /**
     * Compare rules to add against existing rules and compose array of rules to create in DB.
     *
     * @param ERule[] $rulesToAdd
     * @param ERule[] $rulesExist
     * @return ERule[]
     */
    private function compareRules($rulesToAdd, $rulesExist)
    {
        $result = [];
        foreach ($rulesToAdd as $key => $one) {
            if (!isset($rulesExist[$key])) {
                $result[] = $one;
            }
        }
        return $result;
    }

    /**
     * Compose key for rules in array.
     *
     * @param boolean $isAdmin
     * @param int $typeId
     * @param string $source
     * @return string
     */
    private function composeKey($isAdmin, $typeId, $source)
    {
        return "$isAdmin:$typeId:$source";
    }

    /**
     * Convert violation reports to policy rules.
     *
     * @param EReport[] $reports
     * @param array $types map of the policy types ([type_key => type_id])
     * @return array
     */
    private function convertReportsToRules($reports, $types)
    {
        $result = [];
        foreach ($reports as $one) {
            $reportJson = $one->getReport();
            $reportObj = json_decode($reportJson);
            $directive = $reportObj->{'violated-directive'};
            if (isset($types[$directive])) {
                $typeId = $types[$directive];
                $isAdmin = $one->getAdminArea();
                $uriFull = $reportObj->{'blocked-uri'};
                if ($this->isScheme($uriFull)) {
                    // blocked-uri is a schema part only of regular URI
                    $scheme = trim(strtolower($uriFull));
                    // don't process empty schemes (OWN-174)
                    if (strlen($scheme)) {
                        // scheme only rules should contain ':' at the end (https://stackoverflow.com/a/18449556/4073821)
                        $scheme .= ':';
                        $rule = new ERule();
                        $rule->setAdminArea($isAdmin);
                        $rule->setTypeId($typeId);
                        $rule->setSource($scheme);
                        // collect the same rules
                        $key = $this->composeKey($isAdmin, $typeId, $scheme);
                        $result[$key] = $rule;
                    }
                } else {
                    // blocked-uri is a regular URI
                    $parts = parse_url($uriFull);
                    $host = isset($parts['host']) ? trim(strtolower($parts['host'])) : null;
                    if ($host) {
                        $rule = new ERule();
                        $rule->setAdminArea($isAdmin);
                        $rule->setTypeId($typeId);
                        $rule->setSource($host);
                        // collect the same rules
                        $key = $this->composeKey($isAdmin, $typeId, $host);
                        $result[$key] = $rule;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @param \Flancer32\Csp\Service\Report\Analyze\Request $request
     * @return \Flancer32\Csp\Service\Report\Analyze\Response
     */
    public function execute($request)
    {
        assert($request instanceof \Flancer32\Csp\Service\Report\Analyze\Request);
        $result = new \Flancer32\Csp\Service\Report\Analyze\Response();
        /** @var EReport[] $reports */
        $reports = $this->daoReport->getSet();
        $types = $this->getTypesMap();
        $rulesToAdd = $this->convertReportsToRules($reports, $types);
        $rulesExist = $this->getRulesExist();
        $rulesNew = $this->compareRules($rulesToAdd, $rulesExist);
        $enabled = $this->hlpCfg->getRulesNewAreActive();
        $added = $this->addRules($rulesNew, $enabled);
        [$deleted, $minId, $maxId] = $this->clearReports($reports);
        $result->setRulesAdded($added);
        $result->setReportsDeleted($deleted);
        $result->setReportsIdMin($minId);
        $result->setReportsIdMax($maxId);
        return $result;
    }

    /**
     * Get existing rules from DB.
     *
     * @return ERule[]
     */
    private function getRulesExist()
    {
        $result = [];
        $all = $this->daoRule->getSet();
        foreach ($all as $one) {
            $typeId = $one->getTypeId();
            $isAdmin = $one->getAdminArea();
            $source = $one->getSource();
            $key = $this->composeKey($isAdmin, $typeId, $source);
            $result[$key] = $one;
        }
        return $result;
    }

    /**
     * Build map for policy types IDs.
     *
     * @return array [type_key => type_id]
     */
    private function getTypesMap()
    {
        $result = [];
        $all = $this->daoTypePolicy->getSet();
        foreach ($all as $one) {
            $key = $one->getKey();
            $id = $one->getId();
            $result[$key] = $id;
        }
        return $result;
    }

    /**
     * Return 'true' if $uri is scheme (http, https, data, ...).
     *
     * @param string $uri
     * @return bool
     */
    private function isScheme($uri)
    {
        $result = false;
        if (
            strlen($uri < 8) &&
            (strstr($uri, ':') === false) &&
            (strstr($uri, '/') === false)
        ) {
            $result = true;
        }
        return $result;
    }

}
