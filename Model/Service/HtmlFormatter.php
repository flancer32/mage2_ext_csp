<?php
namespace Flancer32\Csp\Model\Service;

use Flancer32\Csp\Api\Repo\Dao\Type\Policy;
use Flancer32\Csp\Api\Repo\Data\Rule as ERule;
use Flancer32\Csp\Ui\DataProvider\Report\Grid as ReportGrid;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;

class HtmlFormatter
{
    /**
     * @var Escaper
     */
    private $escaper;
    /**
     * @var Policy
     */
    private $policyRepository;

    public  function __construct(
        Escaper $escaper,
        Policy $policyRepository
    )
    {
        $this->escaper = $escaper;
        $this->policyRepository = $policyRepository;
    }

    /**
     * @param ERule[] $rulesToReport
     * @return string
     * @throws \Exception
     */
    public function renderNewRulesSection(array $rulesToReport): string
    {
        return '<div><h1>New Rules<h1/>' . $this->renderAsHtmltable($rulesToReport) . '</div>';
    }

    /**
     * Can be extended using different dataTypes as header definition is read from getData's array keys
     * @param Erule[]|DataObject[] $dataAccessObjects
     * @return string
     * @throws \Exception
     */
    private function renderAsHtmltable(array $dataAccessObjects) {
        $htmlifiedRowContents[] = $this->rendertableHeader($dataAccessObjects);
        foreach ($dataAccessObjects as $dataAccessObject) {
            $htmlifiedRowContents[] = $this->renderHtmlRow($dataAccessObject);
        }
        return '<table>' . implode('',$htmlifiedRowContents) . '</table>';
    }

    /**
     * @param ERule|DataObject $row
     * @return string
     */
    private function renderHtmlRow(ERule $row) {
        $rowContentHtml = '';
        $data = $row->getData();
        foreach ($data as $key => $value) {
            $rowContentHtml .= $this->wrapInTd($this->processAndEscapeContent($key, $value));
        }
        return '<tr>' . $rowContentHtml . '</tr>';
    }

    /**
     * extend using array keys to decide processor.
     * @param $key
     * @param $value
     * @return array|string
     */
    private function processAndEscapeContent($key, $value) {

        switch($key) {
            case 'type_id':
                $output = $this->processPolicyId((int)$value);
                break;
            case 'enabled':
                $output = $this->processBoolean((int)$value);
                break;
            default:
                $output = $value;
        }
        return $this->escaper->escapeHtml($output);
    }

    private function processPolicyId(int $id): string
    {
        return $this->policyRepository->getOne($id)->getKey();
    }

    private function processBoolean(int $value): string
    {
        return $value === 0 ? 'false' : 'true';
    }

    /**
     * @param Erule[]|DataObject[] $dataAccessObjects
     * @return string
     */
    private function rendertableHeader(array $dataAccessObjects) {
        if (!count($dataAccessObjects)) {
            throw new \Exception("dataAccessObject is required to contain at least one entry");
        }
        $first = $dataAccessObjects[0];
        $data = $data = $first->getData();
        $keys = array_keys($data);
        $headerContentHtml = '';
        foreach ($keys as $key) {
            $headerContentHtml .= $this->wrapInTh($key);
        }
        return '<tr>' . $headerContentHtml . '</tr>';
    }

    private function wrapInTh(string $escapedContent) {
        return '<th style=" padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;">' . $escapedContent . '</th>';
    }

    private function wrapInTd(string $escapedContent) {
        return '<td style="border: 1px solid #ddd; min-width: 100px;">' . $escapedContent . '</td>';
    }

}
