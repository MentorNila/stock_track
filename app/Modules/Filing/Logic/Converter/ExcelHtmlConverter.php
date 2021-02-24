<?php
namespace App\Modules\Filing\Logic\Converter;

use Illuminate\Support\Str;
use App\Modules\Taxonomy\Logic\Taxonomy;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;

class ExcelHtmlConverter {
    private $filingId;
    private $excelSheet;
    private $sheetNames;
    private $fsPath;

    public function __construct($excelSheet, $sheetNames, $filingId, $financialStatementsPath)
    {
        $this->filingId = $filingId;
        $this->excelSheet = $excelSheet;
        $this->sheetNames = $sheetNames;
        $this->fsPath = $financialStatementsPath;
    }

    public function convert()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1024M');
        $tables = []; 
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $objPHPExcel = $reader->load($this->excelSheet);
        $sheetCount = $objPHPExcel->getSheetCount();
        if (!is_null($sheetCount) && !empty($sheetCount)){
            for ($i = 0; $i < $sheetCount; $i++) {
                $objWorksheet = $objPHPExcel->getSheet($i);
                if (!is_null($objWorksheet)){
                    $highestCol = $objWorksheet->getHighestDataColumn();
                    try {
                        $sheetName = $objWorksheet->getTitle();
                        $htmlContent = '<table style="font-weight: 500;">' . "\n";

                        $columnsDimensions = $objWorksheet->getColumnDimensions();
                        $columnsWidth = [];
                        $c = 0;
                        $hiddenColumns = [];
                        foreach ($columnsDimensions as $key => $item) {
                            if ($key > $highestCol){
                                break;
                            }
                            if (!$item->getVisible()){
                                $hiddenColumns[] = $key;
                            }
                            $columnsWidth[$c++] = $item->getWidth();
                        }

                        foreach ($objWorksheet->getRowIterator() as $rowId => $row) {
                            if ($objWorksheet->getRowDimension($rowId)->getVisible()) {
                                $firstElementOfRow = null;
                                $taxonomyTag = null;
                                $mergedCells = $objWorksheet->getMergeCells();

                                $cellIterator = $row->getCellIterator();
                                $cellIterator->setIterateOnlyExistingCells(false);

                                $cellValue = $this->prepareCellValues($cellIterator, $mergedCells, $columnsWidth, $hiddenColumns, $highestCol);
                                if(isset($cellValue[0]['value'])) {
                                    $firstElementOfRow = $cellValue[0]['value'];
                                    $taxonomy = new Taxonomy();
                                    $results = $taxonomy->searchTag($firstElementOfRow);
                                    if(isset($results[0])) {
                                        $taxonomyTag = $results[0]['code'];
                                    }
                                }

                                if($rowId % 3 === 0) {
                                    $cellParity = 'even';
                                } else {
                                    $cellParity = 'odd';
                                }
                                $htmlContent = $this->renderHtmlTableData($cellValue, $htmlContent, $cellParity, $taxonomyTag);

                                $htmlContent .='</tr>' . "\n";
                            }
                        }

                        $htmlContent .= '</table>' . "\n";
                        $financialStatementTableFullPath = $this->fsPath . '/' . $sheetName .'.html';
                        file_put_contents($financialStatementTableFullPath , $htmlContent);
                        $tables[$sheetName] = $financialStatementTableFullPath;
                    } catch (\Exception $ex){
                        \Log::error($ex->getMessage());
                        unset($tables[$sheetName]);
                        continue;
                    }
                }
            }
        }
        return $tables;
    }

    function prepareCellValues($cellIterator, $mergedCells, $columnsWidth, $hiddenColumns = [], $highestColum = ''){
        $cellValue = [];
        $counter = 0;
        foreach ($cellIterator as $cell) {
            if ($cell->getColumn() == $highestColum){
                return $cellValue;
            }
            if (in_array($cell->getColumn(), $hiddenColumns)){
                continue;
            }
            $style = $this->getCellStyle($cell);
            $cellVal = $cell->getCalculatedValue();
            foreach ($mergedCells as $cells){
                if (!is_null($cell->getValue()) &&$cell->isInRange($cells)) {
                    $columns = explode(':',$cells);
                    $colspan = count(range($columns[0], $columns[1]));
                    $cellValue[$counter]['colspan'] = $colspan;
                    break;
                }
            }


            if (isset($columnsWidth[$counter])){
                $cellValue[$counter]['width'] = $columnsWidth[$counter];
            } else {
                $cellValue[$counter]['width'] = '10';
            }

            $cellValue[$counter]['style'] = $style;
//            Formats excel cell values depending on their types
//            if(PHPExcel_Shared_Date::isDateTime($cell) && $cellVal !== '' && !is_null($cellVal)) {
//                $date = date('F d, Y', PHPExcel_Shared_Date::ExcelToPHP($cellVal));
//                $cellValue[$counter]['value'] = $date;
//            } else if (is_numeric($cell->getCalculatedValue())){
//                $cellValue[$counter]['value'] = $cell->getFormattedValue();
//                $cellValue[$counter]['style'] .= 'text-align: right; ';
//                $cellValue[$counter]['type'] = 'number';
//            } else{
            $cellValue[$counter]['value'] = $cell->getFormattedValue();
//             }

            $explode = (explode(';', $cell->getStyle()->getNumberFormat()->getFormatCode()));

            if (count($explode) > 3 && $cell->getFormattedValue() === "0"){
                if (Str::contains($explode['2'],'-')){
                    $val = '-';
                }
                $cellValue[$counter]['value']  = $val;
                $cellValue[$counter]['fact']  = '0';
                $cellValue[$counter]['style'] .= 'text-align: right; ';
                $cellValue[$counter]['type'] = 'number';
            } else if (count($explode) > 3 ){
                $val = $cell->getFormattedValue();
                $cellValue[$counter]['value'] = $val;
                $cellValue[$counter]['style'] .= 'text-align: right; ';
                $cellValue[$counter]['type'] = 'number';
            }
            $counter++;
        }
        return $cellValue;
    }

    function renderHtmlTableData($cellValue, $table, $cellParity = 'even', $taxonomyTag = null){
        $cellValue = $this->setColspan($cellValue);
        foreach ($cellValue as $key => $item){
            $value = $item['value'];
            $style = $item['style'];
            $numeric = false;
            if (isset($item['type']) && $item['type'] === 'number'){
                $numeric = true;
            }
            if (isset($item['fact'])){
                $fact = $item['fact'];
            } else {
                $fact = $value;
            }

            if ($numeric && $value !== '') {
                if (Str::contains($value, ')')) {
                    $fact = str_replace(
                        array('(', ')'),
                        array('', ''), $fact);
                }

                if (Str::contains($value, ',')) {
                    $fact = str_replace(',', '', $fact);
                }
                //removes non-UTF8 characters
                $regex = <<<'END'
                /
                  (
                    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
                    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
                    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
                    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3
                    ){1,100}                        # ...one or more times
                  )
                | .                                 # anything else
                /x
END;
                $value = preg_replace($regex, '$1', $value);
                //Allows NUMBERS . , ( ) -

                $value = '<span class="tagableOnly"><span class="attributes" data-fact="' . trim($fact) . '"></span><span class="text" style="font-weight: bold">' . trim($value) . '</span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span>';
                $style .= 'text-align:right; ';
            }

            if ($key < 3){
                $style .= 'white-space: pre; ';
            }
            if ($numeric && Str::contains($value,'$') && $value !== '$'){
                $value = str_replace('$','', $value);
                $value = '<span style="float: left">$</span>' . $value;
                $style .= 'text-align:right; ';
            }

            $width = $item['width'] . 'in; ';
            $style .= ' font-size: 9pt;';
            if($cellParity == 'even') {
                $style .= ' background-color:#CFF0FC;';
            }
            if($key == 0) {
                $style .= ' font-weight: bold;';
            }
            if (isset($item['colspan']) && $item['colspan'] > 0){
                $table .= '<td colspan = "' . $item['colspan'] . '" style=" ' . $style . ' width:'.$width.'">' . $value . '</td>' . "\n";
            } else {
                $table .= '<td style=" ' . $style . ' width:'.$width.'">' . $value . '</td>' . "\n";
            }
        }

        return $table;
    }

    function setColspan($cellValue){
        foreach ($cellValue as $key => $item) {
            if (isset($item['colspan']) && $item['colspan'] > 0){
                for ($i = $key + 1; $i < $key + $item['colspan']; $i++){
                    unset($cellValue[$i]);
                }
            }
        }

        return $cellValue;
    }

    function getCellStyle($cell){
        $style = $this->getCellBorders($cell);
        $style .= $this->getCellAlignment($cell);
        $style .= $this->getCellFont($cell);

        return $style;
    }

    function getCellFont($cell){
        $font['bold'] = $cell->getStyle()->getFont()->getBold();
        $style = '';
        foreach ($font as $code => $value){
            if ($code === 'bold'){
                if ($value != 'true'){
                    continue;
                }
                $code = 'font-weight';
                $value = 'bold';
            }
            $style .= $code . ':' . $value . '; ';
        }
        return $style;
    }

    function getCellAlignment($cell){
        $alignment['text-align'] = $cell->getStyle()->getAlignment()->getHorizontal();
        $alignment['text-indent'] = $cell->getStyle()->getAlignment()->getIndent()*10 .'px';

        $style = '';
        foreach ($alignment as $code => $value){
            if ($value == 'general'){
                continue;
            }
            $style .= $code . ':' . $value . '; ';
        }
        return $style;
    }

    function getCellBorders($cell){
//        $borders['border-top'] = $cell->getStyle()->getBorders()->getTop()->getBorderStyle();
        $borders['border-bottom'] = $cell->getStyle()->getBorders()->getBottom()->getBorderStyle();
        $borders['border-left'] = $cell->getStyle()->getBorders()->getLeft()->getBorderStyle();
        $borders['border-right'] = $cell->getStyle()->getBorders()->getRight()->getBorderStyle();

        $borderStyle = '';
        foreach ($borders as $style => $value){
            if ($value === 'double'){
                $value = '3px double';
            } else if($value === 'thin'){
                $value = '1px solid';
            }
            $borderStyle .= $style . ':' . $value . '; ';
        }
        return $borderStyle;
    }
}
