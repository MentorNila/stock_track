<?php

namespace App\Modules\Filing\Logic\XBRL;

include base_path().'/vendor/autoload.php';

use App\Modules\Filing\Logic\GetFilingData;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class FormThreeGenerator {
    private $filingId;
    private $service;
    private $writer;
    private $company;
    private $data;

    public function __construct($data, $filingId)
    {
        $this->filingId = $filingId;
        $this->setClient();
        $this->service = new Service();
        $this->data = $data;
    }

    public function setClient(){
        $filingData = new GetFilingData($this->filingId);
        $this->company = $filingData->getCompany();
    }
    public function generateXml(){

        $this->writer = ($this->service->write('ownershipDocument', function ($writer) {
            $writer->writeElement('schemaVersion', 'X0206');
            $writer->writeElement('documentType', '3');
            if(isset($this->data['general-data']['event-dates']) && !empty($this->data['general-data']['event-dates'])){
                $this->data['general-data']['event-dates'] = strtotime($this->data['general-data']['event-dates']);
                $this->data['general-data']['event-dates'] = date("Y-m-d", $this->data['general-data']['event-dates']);
                $writer->writeElement('periodOfReport', $this->data['general-data']['event-dates']);
            }
            $writer->writeElement('noSecuritiesOwned', '0');

            $writer->writeElement('issuer', function ($writer){
                $writer->writeElement('issuerCik', $this->company->cik);
                $writer->writeElement('issuerName', $this->company->name);
                $writer->writeElement('issuerTradingSymbol', $this->company->symbol);
            });
            if(isset($this->data['reporting-person']) && !empty($this->data['reporting-person'])){
                foreach ($this->data['reporting-person'] as $reportingOwner) {
                    $writer->writeElement('reportingOwner', function ($writer) use ($reportingOwner){
                        $writer->writeElement('reportingOwnerId', function ($writer) use ($reportingOwner){
                            if(isset($reportingOwner['cik-number']) && !empty($reportingOwner['cik-number'])){
                                $writer->writeElement('rptOwnerCik', $reportingOwner['cik-number']);
                            }
                            if(isset($reportingOwner['name-address']) && !empty($reportingOwner['name-address'])){
                                $writer->writeElement('rptOwnerName', $reportingOwner['name-address']);
                            }

                        });

                        $writer->writeElement('reportingOwnerAddress', function ($writer) use ($reportingOwner){
                            if(isset($reportingOwner['street']) && !empty($reportingOwner['street'])){
                                $writer->writeElement('rptOwnerStreet1', $reportingOwner['street']);
                            }
                            $writer->writeElement('rptOwnerStreet2', $reportingOwner['street2']);
                            if(isset($reportingOwner['city']) && !empty($reportingOwner['city'])){
                                $writer->writeElement('rptOwnerCity', $reportingOwner['city']);
                            }
                            if(isset($reportingOwner['state']) && !empty($reportingOwner['state'])){
                                $writer->writeElement('rptOwnerState', $reportingOwner['state']);
                            }
                            if(isset($reportingOwner['zip']) && !empty($reportingOwner['zip'])){
                                $writer->writeElement('rptOwnerZipCode', $reportingOwner['zip']);
                            }

                            if(isset($reportingOwner['state']) && !empty($reportingOwner['state'])){
                                $writer->writeElement('rptOwnerStateDescription', $reportingOwner['state']);
                            }
                        });

                        $generalData = $this->data['general-data'];
                        $writer->writeElement('reportingOwnerRelationship', function ($writer) use ($generalData){
                            $writer->writeElement('isDirector', $generalData['director']);
                            $writer->writeElement('isOfficer', $generalData['officer']);
                            $writer->writeElement('isTenPercentOwner',
                                $generalData['owner']);
                            $writer->writeElement('isOther', $generalData['other']);
                            $writer->writeElement('officerTitle', $generalData['officerTitle']);
                        });
                    });
                }
            }

            if(isset($this->data['non-derivative']) && !empty($this->data['non-derivative'])){
                $writer->writeElement('nonDerivativeTable', function ($writer) {
                    foreach ($this->data['non-derivative'] as $nonDerivative) {
                        $writer->writeElement('nonDerivativeHolding', function ($writer) use ($nonDerivative){
                            if(isset($nonDerivative['title']) && !empty($nonDerivative['title'])){
                                $writer->writeElement('securityTitle', function ($writer) use ($nonDerivative){
                                    $writer->writeElement('value', $nonDerivative['title']);
                                });
                            }

                                if((isset($nonDerivative['amount']) && !empty($nonDerivative['amount'])) || (isset($nonDerivative['amount-num']) && !empty($nonDerivative['amount-num']))){
                                    $writer->writeElement('postTransactionAmounts', function ($writer) use ($nonDerivative){
                                    $writer->writeElement('sharesOwnedFollowingTransaction', function ($writer) use ($nonDerivative){
                                        if(isset($nonDerivative['amount']) && !empty($nonDerivative['amount'])){
                                            $nonDerivative['amount'] = str_replace(',', '', $nonDerivative['amount']);
                                            $writer->writeElement('value', $nonDerivative['amount']);
                                        }
                                        if(isset($nonDerivative['amount-num']) && !empty($nonDerivative['amount-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['amount-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }
                                    });
                                });
                            }

                            $writer->writeElement('ownershipNature', function ($writer) use ($nonDerivative){

                                $writer->writeElement('directOrIndirectOwnership', function ($writer) use ($nonDerivative){
                                    if((isset($nonDerivative['ownership']) && !empty($nonDerivative['ownership'])) || (isset($nonDerivative['ownership-num']) && !empty($nonDerivative['ownership-num']))){
                                        if(isset($nonDerivative['ownership']) && !empty($nonDerivative['ownership'])){
                                            $writer->writeElement('value', $nonDerivative['ownership']);
                                        }
                                        if(isset($nonDerivative['ownership-num']) && !empty($nonDerivative['ownership-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['ownership-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }
                                    }
                                });

                                if((isset($nonDerivative['nature']) && !empty($nonDerivative['nature'])) || isset($nonDerivative['nature-num']) && !empty($nonDerivative['nature-num'])){
                                    $writer->writeElement('natureOfOwnership', function ($writer) use ($nonDerivative){
                                        if(isset($nonDerivative['nature']) && !empty($nonDerivative['nature'])){
                                            $writer->writeElement('value', $nonDerivative['nature']);
                                        }
                                        if(isset($nonDerivative['nature-num']) && !empty($nonDerivative['nature-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['nature-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });
                        });
                    }
                });
            }

            if(isset($this->data['derivative']) && !empty($this->data['derivative'])){
                $writer->writeElement('derivativeTable', function ($writer) {
                    foreach ($this->data['derivative'] as $derivative) {
                        $writer->writeElement('derivativeHolding', function ($writer) use ($derivative) {
                            if(isset($derivative['security-title']) && !empty($derivative['security-title'])){
                                $writer->writeElement('securityTitle', function ($writer) use ($derivative) {
                                    $writer->writeElement('value', $derivative['security-title']);
                                });
                            }

                            if((isset($derivative['conversion']) && !empty($derivative['conversion'])) || (isset($derivative['conversion-num']) && !empty($derivative['conversion-num']))){
                                $writer->writeElement('conversionOrExercisePrice', function ($writer) use ($derivative) {
                                    if(isset($derivative['conversion']) && !empty($derivative['conversion'])){
                                        $writer->writeElement('value', $derivative['conversion']);
                                    }
                                    if(isset($derivative['conversion-num']) && !empty($derivative['conversion-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative) {
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['conversion-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                });
                            }

                            if((isset($derivative['date-exercisable']) && !empty($derivative['date-exercisable'])) || (isset($derivative['date-exercisable-num']) && !empty($derivative['date-exercisable-num']))){
                                $writer->writeElement('exerciseDate', function ($writer) use ($derivative){
                                    if(isset($derivative['date-exercisable']) && !empty($derivative['date-exercisable'])){
                                        $derivative['date-exercisable'] = strtotime($derivative['date-exercisable']);
                                        $derivative['date-exercisable'] = date("Y-m-d", $derivative['date-exercisable']);
                                        $writer->writeElement('value', $derivative['date-exercisable']);
                                    }
                                    if(isset($derivative['date-exercisable-num']) && !empty($derivative['date-exercisable-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['date-exercisable-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                });
                            }

                            if((isset($derivative['date-expiration']) && !empty($derivative['date-expiration'])) || (isset($derivative['date-expiration-num']) && !empty($derivative['date-expiration-num']))){
                                $writer->writeElement('expirationDate', function ($writer) use ($derivative){
                                    if(isset($derivative['date-expiration']) && !empty($derivative['date-expiration'])){
                                        $derivative['date-expiration'] = strtotime($derivative['date-expiration']);
                                        $derivative['date-expiration'] = date("Y-m-d", $derivative['date-expiration']);
                                        $writer->writeElement('value', $derivative['date-expiration']);
                                    }
                                    if(isset($derivative['date-expiration-num']) && !empty($derivative['date-expiration-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['date-expiration-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                });
                            }


                            $writer->writeElement('underlyingSecurity', function ($writer) use ($derivative) {

                                if(isset($derivative['title']) && !empty($derivative['title'])){
                                    $writer->writeElement('underlyingSecurityTitle', function ($writer) use ($derivative) {
                                        $writer->writeElement('value', $derivative['title']);
                                    });
                                }

                                if(isset($derivative['amount']) && !empty($derivative['amount'])){
                                    $writer->writeElement('underlyingSecurityShares', function ($writer) use ($derivative) {
                                        $derivative['amount'] = str_replace(',', '', $derivative['amount']);
                                        $writer->writeElement('value', $derivative['amount']);
                                    });
                                }
                            });

                            $writer->writeElement('ownershipNature', function ($writer) use ($derivative) {

                                if((isset($derivative['ownership']) && !empty($derivative['ownership'])) || isset($derivative['ownership-num']) && !empty($derivative['ownership-num'])){
                                    $writer->writeElement('directOrIndirectOwnership', function ($writer) use ($derivative) {
                                        if(isset($derivative['ownership']) && !empty($derivative['ownership'])){
                                            $writer->writeElement('value', $derivative['ownership']);
                                        }
                                        if(isset($derivative['ownership-num']) && !empty($derivative['ownership-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative) {
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['ownership-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }
                                    });
                                }

                                if((isset($derivative['nature']) && !empty($derivative['nature'])) || isset($derivative['nature-num']) && !empty($derivative['nature-num'])){
                                    $writer->writeElement('natureOfOwnership', function ($writer) use ($derivative) {
                                        if(isset($derivative['nature']) && !empty($derivative['nature'])){
                                            $writer->writeElement('value', $derivative['nature']);
                                        }
                                        if(isset($derivative['nature-num']) && !empty($derivative['nature-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative) {
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['nature-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }
                                    });
                                }
                            });
                        });
                    }
                });
            }


            if(isset($this->data['footnotes']) && !empty($this->data['footnotes'])){
                $writer->writeElement('footnotes', function ($writer) {
                    $i = 1;
                    foreach ($this->data['footnotes'] as $footnote) {
                        if(!empty($footnote)){
                            $writer->writeElement('footnote', function ($writer) use ($footnote, $i) {
                                $writer->writeAttributes(['id' => 'F'.$i]);
                                $content_array = explode(".", $footnote);
                                // remove first element
                                array_shift($content_array);
                                $writer->write(implode('.',$content_array));
                            });
                            $i++;
                        }
                    }
                });
            }


                $writer->writeElement('remarks', function ($writer) {
                    foreach ($this->data['remarks'] as $remark) {
                            $writer->writeElement('remarks',  $remark);
                    }
                });


                if(isset($this->data['signatures'])  && !empty($this->data['signatures'])){
                foreach ($this->data['signatures'] as $signature) {
                    if(!empty($signature['ownerSignature']) || !empty($signature['signatureDate'])){
                        $writer->writeElement('ownerSignature', function ($writer) use ($signature) {
                            if(isset($signature['ownerSignature']) && !empty($signature['ownerSignature'])){
                                $writer->writeElement('signatureName', $signature['ownerSignature']);
                            }
                            if(isset($signature['signatureDate']) && !empty($signature['signatureDate'])){
                                $signature['signatureDate'] = strtotime($signature['signatureDate']);
                                $signature['signatureDate'] = date("Y-m-d", $signature['signatureDate']);
                                $writer->writeElement('signatureDate', $signature['signatureDate']);
                            }
                        });
                    }
                }
            }



        }));

        $xmlFileName = 'Form3.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

}
