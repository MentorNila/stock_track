<?php
namespace App\Modules\Filing\Logic\Converter;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\ZipArchive;

class WordHtml {
    private $filingId;
    private $documentPath;
    private $htmlDocumentPath;
    private $documentName;
    private $htmlContent;
    private $financial;
    private $exhibits;

    public function __construct($filingId, $documentPath, $htmlDocumentPath, $documentName)
    {
        $this->filingId = $filingId;
        $this->documentPath = $documentPath;
        $this->htmlDocumentPath = $htmlDocumentPath;
        $this->documentName = $documentName;
        $this->htmlContent = $this->getHtmlHead();
        $this->financial = false;
        $this->exhibits = false;
    }

    public function convert()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '9024M');

        $number_of_pages = $this->getNumberOfPages();

        $phpWord = IOFactory::load($this->documentPath);
        if($phpWord->getDocInfo()->getTitle() != null){
            $this->documentName = $phpWord->getDocInfo()->getTitle();
        }
        $sections =  $phpWord->getSections();
        foreach ($sections as $section) {
            $elements = $section->getElements();
            $this->handleElementsByType($elements);
        }

        $htmlDocumentFullPath = $this->htmlDocumentPath . '/test.blade.php';
        file_put_contents($htmlDocumentFullPath , $this->htmlContent);
        return $this->htmlContent;
    }

    function handleElementsByType($elements){
        $count = 0;
        foreach ($elements as $element) {
            if(get_class($element) === 'PhpOffice\PhpWord\Element\Table'){
                $count = 0;
                $this->getTableContent($element);

            } else if(get_class($element) === 'PhpOffice\PhpWord\Element\TextRun'){
                $count = 0;
                $this->getTextRunContent($element);

            } else if(get_class($element) === 'PhpOffice\PhpWord\Element\TextBreak'){
                if($count < 2){
                    if($this->financial == false && $this->exhibits == false){
                        $this->htmlContent .= '<br>'. "\n";
                    }
                }
                $count++;
            } else if(get_class($element) === 'PhpOffice\PhpWord\Element\ListItemRun'){
                $this->getListItemRunContent($element);
            } else if(get_class($element) === 'PhpOffice\PhpWord\Element\Title'){
                $this->getTitleContent($element);
            }
        }
    }

    function getTableContent($element){
        $tableStyle = $this->getTableStyle($element);
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '<table style="'. $tableStyle .'">' . "\n";
        }
        $rows =  $element->getRows();
        foreach ($rows as $row) {
            if($this->financial == false && $this->exhibits == false){
                $this->htmlContent .= '<tr>' . "\n";
            }
            $cells = $row->getCells();
            foreach ($cells as $cell) {
                $tdStyle = $this->getTdStyle($cell);
                $span = $cell->getStyle()->getGridSpan();
                if($this->financial == false && $this->exhibits == false){
                    if($span != null){
                        $this->htmlContent .= '<td style="'. $tdStyle .'" colspan="'. $span .'">' . "\n";
                    } else {
                        $this->htmlContent .= '<td style="'. $tdStyle .'">' . "\n";
                    }
                }
                $cellElements = $cell->getElements();
                $this->handleElementsByType($cellElements);
                if($this->financial == false && $this->exhibits == false){
                    $this->htmlContent .= '</td>' . "\n";
                }
            }
            if($this->financial == false && $this->exhibits == false){
                $this->htmlContent .= '</tr>' . "\n";
            }
        }
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '</table>' . "\n";
        }
    }

    function getTableStyle($element){
        $style = 'width: 100%;';
        if(is_array($element->getStyle())){
            $style = $this->getBorders($element->getStyle(), $style);
        }
        return $style;

    }

    function getTdStyle($cell){
        $style = '';
        $style = $this->getBorders($cell->getStyle(), $style);
        if($cell->getStyle()->getShading() != null){
            $style .= 'background: #' . $cell->getStyle()->getShading()->getFill(). ';';
        }
        return $style;
    }

    function getTextRunContent($element){
        $paragraphStyle = $this->getParagraphStyle($element);
        if(get_class($element->getElements()[0]) != 'PhpOffice\PhpWord\Element\TextBreak' && $element->getElements()[0]->getText() == 'Notes to Unaudited Condensed Financial Statements'){
            $this->financial = false;
        }
        if(get_class($element->getElements()[0]) != 'PhpOffice\PhpWord\Element\TextBreak' && $element->getElements()[0]->getText() == 'SIGNATURES'){
            $this->exhibits = false;
        }
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '<p style="'. $paragraphStyle .'">';
        }
        $elementElements = $element->getElements();
        if(empty($elementElements)){
            if($this->financial == false && $this->exhibits == false){
                $this->htmlContent .= '<span>&nbsp;</span>' . "\n";
            }
        } else {
            foreach ($elementElements as $elementElement) {
                if(get_class($elementElement) != 'PhpOffice\PhpWord\Element\TextBreak'){
                    $style = $this->getTextRunStyle($elementElement);
                    $text = $elementElement->getText();
                    if(isset($text)){
                        if($this->financial == false && $this->exhibits == false){
                            if($text == "\t"){
                                $this->htmlContent .= '<span>&emsp;</span>' . "\n";
                            } else {
                                if($style != ''){
                                    $this->htmlContent .= '<span style="'. $style .'">'. $text . '</span>' . "\n";
                                } else {
                                    $this->htmlContent .= '<span>' . $text . '</span>' . "\n";
                                }
                            }
                        }
                    }
                }
            }
        }
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '</p>' . "\n";
        }
        if(get_class($element->getElements()[0]) != 'PhpOffice\PhpWord\Element\TextBreak' && $element->getElements()[0]->getText() == 'ITEM 1. FINANCIAL STATEMENTS.'){
            $this->financial = true;
            $this->htmlContent .= '@include(\'Form::balance-sheets-partial\')';

        }
        if(get_class($element->getElements()[0]) != 'PhpOffice\PhpWord\Element\TextBreak' && $element->getElements()[0]->getText() == 'ITEM 6. EXHIBITS.'){
            $this->exhibits = true;
            $this->htmlContent .= '@include(\'Form::exhibits-partial\')';
        }

    }

    function getParagraphStyle($element){
        $style = '';
        $alignment = $element->getParagraphStyle()->getAlignment();
        $style .= $this->convertStyle($alignment);
        $style .= 'margin:0in;margin-bottom:.0001pt;';
        return $style;
    }

    function getTextRunStyle($elementElement){
        $style = '';
        if($elementElement->getFontStyle()->getName() != null){
            $style = 'font-family:'. $elementElement->getFontStyle()->getName() . ';';
        }
        $size = $elementElement->getFontStyle()->getSize();
        if($size != null){
            $style .= 'font-size: '. $size .'pt;';
        }
        $color = $elementElement->getFontStyle()->getColor();
        if($color != null){
            $style .= 'color: '. $color .';';
        }
        if($elementElement->getFontStyle()->getBold() != null || $elementElement->getFontStyle()->getStyleName() == 'Strong'){
            $style .= 'font-weight: bold;';
        }
        if($elementElement->getFontStyle()->getItalic() != null){
            $style .= 'font-style: italic;';
        }
        $underline = $elementElement->getFontStyle()->getUnderline();
        $style .= $this->convertStyle($underline);
        return $style;
    }

    function getListItemRunContent($element){
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '<ul>';
        }
        $items = $element->getElements();
        foreach($items as $item){
            $style = $this->getTextRunStyle($item);
            $text = $item->getText();
            if(isset($text)){
                if($this->financial == false && $this->exhibits == false){
                    if($style != ''){
                        $this->htmlContent .= '<li style="'. $style .'">'. $text . '</li>' . "\n";
                    } else {
                        $this->htmlContent .= '<li>'. $text . '</li>' . "\n";
                    }
                }
            }
        }
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '</ul>';
        }
    }

    function getTitleContent($element){
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '<h'. $element->getDepth() .'>';
        }
        $text = $element->getText();
        if(is_string($text)){
            if($this->financial == false && $this->exhibits == false){
                $this->htmlContent .= $text;
            }
        } else {
            $items = $text->getElements();
            foreach ($items as $item) {
                if($this->financial == false && $this->exhibits == false){
                    if($item->getText() == "\t"){
                        $this->htmlContent .= '&emsp;';
                    } else {
                        $this->htmlContent .= $item->getText();
                    }
                }
            }
        }
        if($this->financial == false && $this->exhibits == false){
            $this->htmlContent .= '</h'. $element->getDepth() .'>';
        }
    }

    function convertStyle($type){
        switch ($type){
            case 'both':
                return 'text-align: justify;';
            case 'center':
                return 'text-align: center;';
            case 'single':
                return 'text-decoration: underline;';
        }
        return '';
    }

    function getBorders($element, $style){
        $borders['border-top'] = $element->getBorderTopColor();
        $borders['border-bottom'] = $element->getBorderBottomColor();
        $borders['border-left'] = $element->getBorderLeftColor();
        $borders['border-right'] = $element->getBorderRightColor();
        foreach ($borders as $key => $value){
            if($value != null){
                $style .= $key . ':' . '1px solid #' . $value . ';';
            }
        }
        return $style;
    }

    function getHtmlHead(){
        $htmlContent = '<html>'. "\n";
        $htmlContent .= '<head>'. "\n";
        $htmlContent .= '<meta charset="UTF-8" />'. "\n";
        $htmlContent .= '<title>' . $this->documentName . '</title>'. "\n";
        $htmlContent .= '<meta name="author" content="I-NET" />'. "\n";
        $htmlContent .= '<meta name="title" content="' . $this->documentName . '" />'. "\n";
        $htmlContent .= '<style>'. "\n";
        $htmlContent .= '</style>'. "\n";
        $htmlContent .= '</head>'. "\n";
        $htmlContent .= '<body>'. "\n";
        return '';
    }

    function getNumberOfPages(){
        $zip = new ZipArchive();
        $zip->open($this->documentPath);
        $xml = new \DOMDocument();
        $xml->loadXML($zip->getFromName("docProps/app.xml"));
        return $xml->getElementsByTagName('Pages')->item(0)->nodeValue;
    }
}
