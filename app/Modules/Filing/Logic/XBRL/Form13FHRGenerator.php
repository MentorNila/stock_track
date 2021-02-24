<?php

namespace App\Modules\Filing\Logic\XBRL;

include base_path() . '/vendor/autoload.php';

use App\Modules\Filing\Logic\GetFilingData;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class Form13FHRGenerator
{

    private $filingId;
    private $service;
    private $writer;
    private $company;
    private $data;

    public function __construct($data, $filingId)
    {
        $this->filingId = $filingId;
        $this->setCompany();
        $this->service = new Service();
        $this->data = $data;
    }

    public function setCompany()
    {
        $filingData = new GetFilingData($this->filingId);
        $this->company = $filingData->getCompany();
    }

    public function generateXml()
    {
        $rootAttributes = ['xmlns:n2'=>'http://www.sec.gov/edgar/document/thirteenf/informationtable', 'xmlns:ns1'=>'http://www.sec.gov/edgar/common', 'xmlns:n1'=>'http://www.sec.gov/edgar/thirteenffiler', 'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance'];
        $this->writer = ($this->service->write('edgarSubmission', function ($writer) use ($rootAttributes) {
            $writer->writeAttributes($rootAttributes);

            $writer->writeElement('headerData', function ($writer) {
                $writer->writeElement('submissionType', '13F-HR');
                $writer->writeElement('filerInfo', function ($writer) {
                    $writer->writeElement('liveTestFlag', 'LIVE');


                    $writer->writeElement('flags', function ($writer) {
                        if (isset($this->data['hidden_div']['confirmingCopyFlag']) && $this->data['hidden_div']['confirmingCopyFlag'] != "") {
                            $writer->writeElement('confirmingCopyFlag', 'true');
                        } else {
                            $writer->writeElement('confirmingCopyFlag', 'false');
                        }
                        if (isset($this->data['hidden_div']['returnCopyFlag']) && $this->data['hidden_div']['returnCopyFlag'] != "") {
                            $writer->writeElement('returnCopyFlag', 'true');
                        } else {
                            $writer->writeElement('returnCopyFlag', 'false');
                        }
                        if (isset($this->data['hidden_div']['overrideInternetFlag']) && $this->data['hidden_div']['overrideInternetFlag'] != "") {
                            $writer->writeElement('overrideInternetFlag', 'true');
                        } else {
                            $writer->writeElement('overrideInternetFlag', 'false');
                        }
                    });


                    $writer->writeElement('filer', function ($writer) {
                        $writer->writeElement('credentials', function ($writer) {
                            $writer->writeElement('cik', $this->company->cik);
                            $writer->writeElement('ccc', 'XXXXXXXX');
                        });
                    });
                    if (isset($this->data['calendar']['date-value']) && !empty ($this->data['calendar']['date-value'])) {
                        $writer->writeElement('periodOfReport', $this->data['calendar']['date-value']);
                    }
         
                });

            });

            $writer->writeElement('formData', function ($writer) {
                $writer->writeElement('coverPage', function ($writer) {
                    if (isset($this->data['calendar']['date-value']) && !empty ($this->data['calendar']['date-value'])) {
                        $writer->writeElement('reportCalendarOrQuarter', $this->data['calendar']['date-value']);
                    }
                    if (isset($this->data['amendment-informations']['isAmendment']) && !empty($this->data['amendment-informations']['isAmendment'])) {
                        $writer->writeElement('isAmendment', "true");
                    }
                    if (isset($this->data['amendment-informations']['amendment-number']) && !empty ($this->data['amendment-informations']['amendment-number'])) {
                        $writer->writeElement('amendmentNo', $this->data['amendment-informations']['amendment-number']);
                    }

                    if (isset($this->data['amendment-informations']['amendment-check']) && !empty($this->data['amendment-informations']['amendment-check'])) {
                        $writer->writeElement('amendmentInfo', function ($writer) {
                            $writer->writeElement('amendmentType', array_keys($this->data['amendment-informations']['amendment-check'])[0]);
                        });
                    }


                    $writer->writeElement('filingManager', function ($writer) {
                        $writer->writeElement('name', $this->data['filing-manager']['manager-name']);
                        $writer->writeElement('address', function ($writer) {
                            $writer->writeElement('ns1:street1', $this->data['filing-manager']['address1']);
                            if (isset($this->data['filing-manager']['address2']) && !empty($this->data['filing-manager']['address2'])) {
                                $writer->writeElement('ns1:street2', $this->data['filing-manager']['address2']);
                            }
//                            $writer->writeElement('ns1:city', $this->data['filing-manager']['city']);
                            $tcityVal = str_replace(',', '', $this->data['filing-manager']['city']);
                            $writer->writeElement('ns1:city', $tcityVal);

                            if (isset ($this->data['filing-manager']['stateCountry']) && !empty($this->data['filing-manager']['stateCountry'])) {
                                $writer->writeElement('ns1:stateOrCountry', $this->data['filing-manager']['stateCountry']);
                            }
                            $writer->writeElement('ns1:zipCode', $this->data['filing-manager']['zip']);
                        });
                    });
                    if (isset($this->data['report-type-informations']['report-type']) && !empty($this->data['report-type-informations']['report-type'])) {
                        $writer->writeElement('reportType', array_keys($this->data['report-type-informations']['report-type'])[0]);
                    }
                    $writer->writeElement('form13FFileNumber', $this->data['filing-manager']['file-numbers']);


                    if(isset($this->data['reported-managers']) && !empty($this->data['reported-managers'])) {
                        $writer->writeElement('otherManagersInfo', function ($writer) {
                            foreach ($this->data['reported-managers'] as $Manager) {
                                $writer->writeElement('otherManager', function ($writer) use ($Manager) {
                                    if (isset($Manager['cik-number']) && !empty($Manager['cik-number'])) {
                                        $writer->writeElement('cik', $Manager['cik-number']);
                                    }
                                    if (isset($Manager['file-number']) && !empty($Manager['file-number'])) {
                                        $writer->writeElement('form13FFileNumber', $Manager['file-number']);
                                    }
                                        $writer->writeElement('name', $Manager['file-name']);
                                });
                            }
                        });
                    }






                    if (isset($this->data['additional-info']['yes-no']) && !empty($this->data['additional-info']['yes-no'])) {
                        $writer->writeElement('provideInfoForInstruction5', array_keys($this->data['additional-info']['yes-no'])[0]);
                    }

                    if (isset ($this->data['additional-info']['additionalInformation']) && !empty($this->data['additional-info']['additionalInformation'])) {
                        $writer->writeElement('additionalInformation', $this->data['additional-info']['additionalInformation']);
                    }

                });
                $writer->writeElement('signatureBlock', function ($writer) {
                    $writer->writeElement('name', $this->data['signature-informations']['reporting-manager']);
                    $writer->writeElement('title', $this->data['signature-informations']['title']);
                    $writer->writeElement('phone', $this->data['signature-informations']['phone']);
                    $writer->writeElement('signature', $this->data['signature-informations']['signature']);
                    $tcityValue = str_replace(',', '', $this->data['signature-informations']['city']);
                    $writer->writeElement('city', $tcityValue);
//                    $writer->writeElement('city', $this->data['signature-informations']['city']);
                    if (isset ($this->data['signature-informations']['state']) && !empty($this->data['signature-informations']['state'])) {
                        $writer->writeElement('stateOrCountry', $this->data['signature-informations']['state']);
                    }
                    $writer->writeElement('signatureDate', $this->data['signature-informations']['date-of-signature']);
                });


                $writer->writeElement('summaryPage', function ($writer) {
                    $writer->writeElement('otherIncludedManagersCount', $this->data['report-summary']['managers-number']);
                    $writer->writeElement('tableEntryTotal', $this->data['report-summary']['entry-total']);
                    $tableValue = str_replace(',', '', $this->data['report-summary']['value-total']);
                    $writer->writeElement('tableValueTotal', $tableValue);
                    if (isset($this->data['report-summary']['confidential']) && $this->data['report-summary']['confidential'] != "") {
                        $writer->writeElement('isConfidentialOmitted', 'true');
                    } else {
                        $writer->writeElement('isConfidentialOmitted', 'false');
                    }


                    if(isset($this->data['listed-managers']) && !empty($this->data['listed-managers'])) {
                    $writer->writeElement('otherManagers2Info', function ($writer) {
                        foreach ($this->data['listed-managers'] as $List) {
                            $writer->writeElement('otherManager2', function ($writer) use ($List) {
                                $writer->writeElement('sequenceNumber', $List['number']);
                                $writer->writeElement('otherManager', function ($writer) use ($List) {
                                    if (isset($List['cik-manager']) && !empty($List['cik-manager'])) {
                                        $writer->writeElement('cik', $List['cik-manager']);
                                    }
                                    if (isset($List['list-number']) && !empty($List['list-number'])) {
                                        $writer->writeElement('form13FFileNumber', $List['list-number']);
                                    }
                                    $writer->writeElement('name', $List['list-name']);
                                });
                            });
                        }
                    });
                }

                });

            });


        }));

        $xmlFileName = '13FHR.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }


    public function generateTable()
    {
        $this->writer = ($this->service->write('informationTable', function ($writer) {
//        $writer->writeElement('informationTable', function ($writer) {
            foreach ($this->data['table-info'] as $TableInfo) {
                $writer->writeElement('infoTable', function ($writer) use ($TableInfo) {
                    if (isset($TableInfo['name']) && $TableInfo['name'] != "") {
                        $writer->writeElement('nameOfIssuer', $TableInfo['name']);
                    }
                    if (isset($TableInfo['title']) && $TableInfo['title'] != "") {
                        $writer->writeElement('titleOfClass', $TableInfo['title']);
                    }
                    if (isset($TableInfo['cusip']) && $TableInfo['cusip'] != "") {
                        $writer->writeElement('cusip', $TableInfo['cusip']);
                    }
                    $value = str_replace(',', '', $TableInfo['value']);
                    $writer->writeElement('value', $value);
                    $writer->writeElement('shrsOrPrnAmt', function ($writer) use ($TableInfo) {
                    $sshPrnamt = str_replace(',', '', $TableInfo['shrs']);
                    $writer->writeElement('sshPrnamt', $sshPrnamt);
                        if (isset($TableInfo['sh']) && $TableInfo['sh'] != "") {
                            $writer->writeElement('sshPrnamtType', $TableInfo['sh']);
                        }
                    });
                    if (isset($TableInfo['put-call']) && $TableInfo['put-call'] != "") {
                        $writer->writeElement('putCall', $TableInfo['put-call']);
                    }
                    if (isset($TableInfo['put-call']) && $TableInfo['put-call'] != "") {
                        $writer->writeElement('putCall', $TableInfo['put-call']);
                    }
                    if (isset($TableInfo['investment']) && $TableInfo['investment'] != "") {
                        $writer->writeElement('investmentDiscretion', $TableInfo['investment']);
                    }
                    if (isset($TableInfo['other']) && $TableInfo['other'] != "") {
                        $writer->writeElement('otherManager', $TableInfo['other']);
                    }

                    $writer->writeElement('votingAuthority', function ($writer) use ($TableInfo) {
                        $soleValue = str_replace(',', '', $TableInfo['sole']);
                        $writer->writeElement('Sole', $soleValue);
                        if (isset($TableInfo['shared']) && $TableInfo['shared'] != "") {
                            $shared = str_replace(',', '', $TableInfo['shared']);
                            $writer->writeElement('Shared', $shared);

                        }
                        if (isset($TableInfo['none']) && $TableInfo['none'] != "") {
                            $writer->writeElement('None', $TableInfo['none']);
                        }
                    });
                });
            }

        }));

        $xmlFileName = 'table.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);
        return $xmlFilePath;

    }


}

