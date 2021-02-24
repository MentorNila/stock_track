<?php
namespace App\Modules\Filing\Logic\XBRL\EntryGenerator;

include base_path().'/vendor/autoload.php';

use Sabre\Xml\Service;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class AnnotationEntry
{
    public $value;
    public $scheme;
    private $appInfo;
    private $sections;
    private $uri;
    private $appInfos = [];
    private $roleTypes = [];

    public function __construct($appInfo, $sections, $uri)
    {
        $this->sections = $sections;
        $this->appInfo = $appInfo;
        $this->uri = $uri;
//        $this->setStaticRoleTypes();
        $this->prepareElement();
    }

    function xmlSerialize(Writer $writer)
    {
        return $writer->writeElement('xsd:annotation', function ($writer) {
            $writer->writeElement('xsd:appinfo', function ($writer) {
                $writer->write($this->appInfos['xsd:appinfo']);

                if (!empty($this->roleTypes)){
                    foreach ($this->roleTypes as $id => $roleType) {
                        $writer->writeElement('link:roleType', function ($writer) use ($roleType, $id){
                            $writer->writeAttributes(['roleURI' => $this->uri.'role/' . trim($roleType['code']), 'id' => trim($roleType['code'])]);
                            $writer->writeElement('link:definition', '00000'. ++$id . $roleType['name']);
                            $writer->writeElement('link:usedOn', 'link:presentationLink');
                            $writer->writeElement('link:usedOn', 'link:calculationLink');
                            $writer->writeElement('link:usedOn', 'link:definitionLink');
                        });
                    }
                }
            });
        });
    }


    function prepareElement(){
        foreach ($this->appInfo as $key => $item) {
            switch ($key){
                case 'calculation':
                    $role = 'http://www.xbrl.org/2003/role/calculationLinkbaseRef';
                    break;
                case 'label':
                    $role = 'http://www.xbrl.org/2003/role/labelLinkbaseRef';
                    break;
                case 'definition':
                    $role = 'http://www.xbrl.org/2003/role/definitionLinkbaseRef';
                    break;
                case 'presentation':
                    $role = 'http://www.xbrl.org/2003/role/presentationLinkbaseRef';
                    break;
                default:
                    break 2;
            }

            $this->appInfos['xsd:appinfo'][]['linkbaseRef'] = [
                'attributes' => [
                    'xlink:arcrole' => 'http://www.w3.org/1999/xlink/properties/linkbase',
                    'xlink:href' => $item,
                    'xlink:role' => $role,
                    'xlink:type' => 'simple',
                ]
            ];
        }

        if (!empty($this->sections)){
            foreach ($this->sections as $roleType) {
                $currentRoleType = (strpos($roleType['attributes']['abstract'], 'Statement') !== false)? 'Statement' : 'Disclosure';
                $counter = count($this->roleTypes);
                $this->roleTypes[$counter]['code'] = $roleType['attributes']['section'];
                $this->roleTypes[$counter]['name'] = '- ' . $currentRoleType . ' - ' . $roleType['attributes']['section'];
                /*foreach (explode(' ', $roleType['id']) as $item) {
                    $this->roleTypes[$counter]['code'] .= ucfirst(strtolower($item));
                    $this->roleTypes[$counter]['name'] .= ucfirst(strtolower($item)). ' ';
                }*/
            }
        }

    }
    function setStaticRoleTypes(){
//        $this->roleTypes[0]['id'] = 'DocumentAndEntityInformation';
//        $this->roleTypes[0]['name'] = ' - Document - Document and Entity Information';
//        $this->roleTypes[1]['id'] = 'BalanceSheets';
//        $this->roleTypes[1]['name'] = ' - Statement - Condensed Balance Sheets';
//        $this->roleTypes[2]['id'] = 'BalanceSheetsParenthetical';
//        $this->roleTypes[2]['name'] = ' - Statement - Condensed Balance Sheets (Parenthetical)';
//        $this->roleTypes[3]['id'] = 'StatementsOfOperations';
//        $this->roleTypes[3]['name'] = ' - Statement - Condensed Statements of Operations (Unaudited)';
//        $this->roleTypes[4]['id'] = 'StatementsOfCashFlows';
//        $this->roleTypes[4]['name'] = ' - Statement - Condensed Statements of Cash Flows (Unaudited)';

    }
}
