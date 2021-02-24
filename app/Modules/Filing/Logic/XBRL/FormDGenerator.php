<?php

namespace App\Modules\Filing\Logic\XBRL;

include base_path().'/vendor/autoload.php';

use App\Modules\Filing\Logic\GetFilingData;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class FormDGenerator {
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
        $this->writer = ($this->service->write('edgarSubmission', function ($writer) {
            $writer->writeElement('schemaVersion', 'X0708');
            $writer->writeElement('submissionType', 'D');
            $writer->writeElement('testOrLive', 'LIVE');

            $writer->writeElement('primaryIssuer', function ($writer){
                    $writer->writeElement('cik', $this->data['general-data']['cik']);
                    $writer->writeElement('entityName', $this->data['contact-informations']['issuer-name']);
                    $writer->writeElement('issuerAddress', function ($writer){
                        $writer->writeElement('street1', $this->data['contact-informations']['street1']);

                        if (isset($this->data['contact-informations']['street2']) && !empty ($this->data['contact-informations']['street2'])) {
                            $writer->writeElement('street2', $this->data['contact-informations']['street2']);
                        }
                        $writer->writeElement('city', $this->data['contact-informations']['city']);
                        if(isset ($this->data['contact-informations']['stateOrCountry']) && !empty($this->data['contact-informations']['stateOrCountry'])){
                            $writer->writeElement('stateOrCountry',$this->data['contact-informations']['stateOrCountry']);
                        }
                        if(isset ($this->data['contact-informations']['stateOrCountryDescriptionInformations']) && !empty($this->data['contact-informations']['stateOrCountryDescriptionInformations'])){
                            $writer->writeElement('stateOrCountryDescription', $this->data['contact-informations']['stateOrCountryDescriptionInformations']);
                        }
                        $writer->writeElement('zipCode', $this->data['contact-informations']['zipCode']);

                    });
                    $writer->writeElement('issuerPhoneNumber', $this->data['contact-informations']['issuerPhoneNumber']);
                    $writer->writeElement('jurisdictionOfInc', $this->data['general-data']['jurisdiction']);

                $writer->writeElement('issuerPreviousNameList', function ($writer){
                    if(isset($this->data['general-data']['issuerPreviousNameList']) && !empty($this->data['general-data']['issuerPreviousNameList'])){
                        $writer->writeElement('previousName', $this->data['general-data']['issuerPreviousNameList']);
                    }else{
                        $writer->writeElement('value', 'None');
                    }
                });


                $writer->writeElement('edgarPreviousNameList', function ($writer){
                    if(isset($this->data['general-data']['edgarPreviousNameList']) && !empty($this->data['general-data']['edgarPreviousNameList'])){
                        $writer->writeElement('previousName', $this->data['general-data']['edgarPreviousNameList']);
                    }else{
                        $writer->writeElement('value', 'None');
                    }
                });




                    if(isset($this->data['general-data']['entity-type']) && !empty($this->data['general-data']['entity-type'])){
                        $writer->writeElement('entityType', array_keys($this->data['general-data']['entity-type'])[0]);
                    }

                    if(isset($this->data['general-data']['otherEntity']) && $this->data['general-data']['otherEntity']!="") {
                        $writer->writeElement('entityTypeOtherDesc', $this->data['general-data']['otherEntity']);
                    }


                    $writer->writeElement('yearOfInc', function ($writer){
                        if(isset($this->data['general-data']['year-of-inc'])&& !empty($this->data['general-data']['year-of-inc'])){
                        if(array_keys($this->data['general-data']['year-of-inc'])[0] =='withinFiveYears'){
                            $writer->writeElement(array_keys($this->data['general-data']['year-of-inc'])[0], 'true');
                            $writer->writeElement('value', $this->data['general-data']['year-of-inc-date']);
                        }else{
                            $writer->writeElement(array_keys($this->data['general-data']['year-of-inc'])[0], 'true');
                        }
                    }
                    });

            });



            $writer->writeElement('relatedPersonsList', function ($writer){
                foreach ($this->data['related-persons'] as $relatedPerson) {
                    $writer->writeElement('relatedPersonInfo', function ($writer) use ($relatedPerson){
                        $writer->writeElement('relatedPersonName', function ($writer) use ($relatedPerson){
                            $writer->writeElement('firstName',  $relatedPerson['first-name']);
                            if(isset($relatedPerson['middle-name']) && !empty($relatedPerson['middle-name'])){
                                $writer->writeElement('middleName', $relatedPerson['middle-name']);
                            }
                            $writer->writeElement('lastName',  $relatedPerson['last-name']);
                        });
                    $writer->writeElement('relatedPersonAddress', function ($writer) use ($relatedPerson){
                            $writer->writeElement('street1',  $relatedPerson['address1']);
                            if (isset($relatedPerson['address2']) && !empty($relatedPerson['address2'])) {
                                $writer->writeElement('street2',  $relatedPerson['address2']);
                            }

                            $writer->writeElement('city', $relatedPerson['city']);
                        if(isset($relatedPerson['relatedPersonStateOrCountry']) && !empty($relatedPerson['relatedPersonStateOrCountry'])){
                            $writer->writeElement('stateOrCountry', $relatedPerson['relatedPersonStateOrCountry']);
                        }
                        if(isset($relatedPerson['stateOrCountryDescription']) && !empty($relatedPerson['stateOrCountryDescription'])){
                            $writer->writeElement('stateOrCountryDescription', $relatedPerson['stateOrCountryDescription']);
                        }

                            $writer->writeElement('zipCode', $relatedPerson['postal-code']);
                        });
                    $writer->writeElement('relatedPersonRelationshipList', function ($writer) use ($relatedPerson){
                        if($relatedPerson['executive'] == 1){
                            $writer->writeElement('relationship', "Executive Officer");
                        }
                        if($relatedPerson['director'] == 1){
                            $writer->writeElement('relationship', "Director");
                        }
                        if($relatedPerson['promoter'] == 1){
                            $writer->writeElement('relationship', "Promoter");
                        }
                    });

                    $writer->writeElement('relationshipClarification', $relatedPerson['response-related-persons']);
                    });
                }
            });

                $writer->writeElement('offeringData', function ($writer){
                        $writer->writeElement('industryGroup', function ($writer){

                            foreach($this->data['industry-group'] as $key => $value) {

                                if($key == 'Pooled Investment Fund'){
                                    $writer->writeElement('industryGroupType', $key);
                                    $writer->writeElement('investmentFundInfo', function ($writer) use ($value){
                                        if(is_array($value)){
                                            foreach($value as $key1 => $poolValue) {
                                                $writer->writeElement('investmentFundType', $key1);
                                            }
                                        }
                                        if(isset($this->data['industry-group']['yes'])){
                                            $writer->writeElement('is40Act', "true");
                                        } else if(isset($this->data['industry-group']['no-registered-issuer'])){
                                            $writer->writeElement('is40Act', "false");
                                        }
                                    });
                                } else if ($key == 'yes' || $key == 'no-registered-issuer') {}
                                else {
                                    $writer->writeElement('industryGroupType', $key);
                                }
                            }
                        });

                        $writer->writeElement('issuerSize', function ($writer){
                            if(isset($this->data['issuer-size']['revenue'])){
                                foreach($this->data['issuer-size']['revenue'] as $key => $value){
                                    $writer->writeElement('revenueRange', $key);
                                }
                            }
                            if(isset($this->data['issuer-size']['aggregates'])){
                                foreach($this->data['issuer-size']['aggregates'] as $key => $value){
                                    $writer->writeElement('aggregateNetAssetValueRange', $key);
                                }
                            }
                        });

                        $writer->writeElement('federalExemptionsExclusions', function ($writer){
                            foreach($this->data['federal-exemption'] as $key => $value){
                                $writer->writeElement('item', $key);
                            }
                        });

                        $writer->writeElement('typeOfFiling', function ($writer){

                                $writer->writeElement('newOrAmendment', function ($writer){
                                    if(isset($this->data['filing-type']['amendment'])){
                                        $writer->writeElement('isAmendment', 'true');
                                    } else {
                                        $writer->writeElement('isAmendment', 'false');
                                    }

                                });
                                $writer->writeElement('dateOfFirstSale', function ($writer){
                                    if(isset($this->data['filing-type']['first-sale'])){
                                        $writer->writeElement('yetToOccur', 'true');
                                    } else {
                                        if(isset($this->data['filing-type']['date'])){
                                            $writer->writeElement('value', $this->data['filing-type']['date']);
                                        }
                                    }
                                });

                        });

                        $writer->writeElement('durationOfOffering', function ($writer){
                            if(isset($this->data['offering']['lasts'])){
                                $writer->writeElement('moreThanOneYear', "true");
                            } else {
                                $writer->writeElement('moreThanOneYear', "false");
                            }
                        });

                        $writer->writeElement('typesOfSecuritiesOffered', function ($writer){
                            foreach($this->data['securities'] as $key => $value){

                                if($key == 'descriptionOfOtherType' ){
                                    if($value != ""){
                                        $writer->writeElement($key, $value);
                                    }
                                } else {
                                    $writer->writeElement($key,  'true');
                                }
                            }
                        });


                        $writer->writeElement('businessCombinationTransaction', function ($writer){
                            if(isset($this->data['business-combination']['in-connection'])){
                                $writer->writeElement('isBusinessCombinationTransaction', "true");
                            } else {
                                $writer->writeElement('isBusinessCombinationTransaction', "false");
                            }
                            $writer->writeElement('clarificationOfResponse',$this->data['business-combination']['response-business']);
                        });


                        $minimum_investment =  str_replace(',', '', $this->data['minimum-investment']['minimum-investment']);
                        $writer->writeElement('minimumInvestmentAccepted', $minimum_investment);




                        $writer->writeElement('salesCompensationList', function ($writer) {
                                foreach ($this->data['sales-compensation'] as $salesCompensation) {
                                    $sumOfText = strlen($salesCompensation['crd-number']) + strlen($salesCompensation['broker-dealer']) + strlen($salesCompensation['broker-dealer-crd']);
                                    $sumOfNone = $salesCompensation['none'] + $salesCompensation['none-crd'] + $salesCompensation['none-broker'];
                                    if($sumOfNone ==3 && $sumOfText == 0) {
                                        echo "";
                                    }else {
                                        $writer->writeElement('recipient', function ($writer) use ($salesCompensation) {
                                        if (isset($salesCompensation['recipient-name']) && $salesCompensation['recipient-name'] != "") {
                                            $writer->writeElement('recipientName', $salesCompensation['recipient-name']);
                                        }
                                        if (isset($salesCompensation['crd-number']) && $salesCompensation['crd-number'] != "") {
                                            $writer->writeElement('recipientCRDNumber', $salesCompensation['crd-number']);
                                        }
                                        if (isset($salesCompensation['broker-dealer']) && $salesCompensation['broker-dealer'] != "") {
                                            $writer->writeElement('associatedBDName', $salesCompensation['broker-dealer']);
                                        }
                                        if (isset($salesCompensation['broker-dealer-crd']) && $salesCompensation['broker-dealer-crd'] != "") {
                                            $writer->writeElement('associatedBDCRDNumber', $salesCompensation['broker-dealer-crd']);
                                        }

//                                    if(isset($salesCompensation['recipientAddress']) && $salesCompensation['recipientAddress']!="") {
                                        $writer->writeElement('recipientAddress', function ($writer) use ($salesCompensation) {
                                            if (isset($salesCompensation['address1']) && !empty($salesCompensation['address1'])) {
                                                $writer->writeElement('street1', $salesCompensation['address1']);
                                            }
                                            if (isset($salesCompensation['address2']) && !empty($salesCompensation['address2'])) {
                                                $writer->writeElement('street2', $salesCompensation['address2']);
                                            }
                                            if (isset($salesCompensation['city']) && $salesCompensation['city'] != "") {
                                                $writer->writeElement('city', $salesCompensation['city']);
                                            }
                                            if (isset($salesCompensation['recipientStateOrCountry']) && $salesCompensation['recipientStateOrCountry'] != "") {
                                                $writer->writeElement('stateOrCountry', $salesCompensation['recipientStateOrCountry']);
                                            }

                                            if (isset($salesCompensation['stateOrCountryDescription']) && $salesCompensation['stateOrCountryDescription'] != "") {
                                                $writer->writeElement('stateOrCountryDescription', $salesCompensation['stateOrCountryDescription']);
                                            }

                                            if (isset($salesCompensation['zip']) && $salesCompensation['zip'] != "") {
                                                $writer->writeElement('zipCode', $salesCompensation['zip']);
                                            }
                                        });
//                                    }

//                                    if(isset($salesCompensation['statesOfSolicitationList']) && $salesCompensation['statesOfSolicitationList']!="") {
                                        $writer->writeElement('statesOfSolicitationList', function ($writer) use ($salesCompensation) {

                                            if (isset($salesCompensation['all-states']) && !empty($salesCompensation['all-states'])) {
                                                $writer->writeElement("value", "All States");
                                            } else {
                                                foreach ($salesCompensation['states'] as $key => $value) {
                                                    $writer->writeElement('state', $key);
                                                    $writer->writeElement('description', $value);
                                                }

                                            }
                                        });
//                                }

                                        if (isset($salesCompensation['foreign']) && !empty($salesCompensation['foreign'])) {
                                            $writer->writeElement('foreignSolicitation', "true");
                                        } else {
                                            $writer->writeElement('foreignSolicitation', "false");
                                        }


                                    });

                                    }

                                }

                        });



                        $writer->writeElement('offeringSalesAmounts', function ($writer){
                            if(isset($this->data['offering-sales']['indefinite-total'])){
                                $writer->writeElement('totalOfferingAmount', 'Indefinite');
                            } else {
                                $offering_amount =  str_replace(',', '', $this->data['offering-sales']['offering-amount']);
                                $writer->writeElement('totalOfferingAmount',$offering_amount);
//                                $writer->writeElement('totalOfferingAmount',$this->data['offering-sales']['offering-amount']);
                            }



                            $total_amount =  str_replace(',', '', $this->data['offering-sales']['total-amount']);
                            $writer->writeElement('totalAmountSold', $total_amount);

                            if(isset($this->data['offering-sales']['indefinite-sold'])){
                                $writer->writeElement('totalRemaining', 'Indefinite');
                            } else {
                                $sold =  str_replace(',', '', $this->data['offering-sales']['sold']);
                                $writer->writeElement('totalRemaining', $sold);
                            }
                            $writer->writeElement('clarificationOfResponse',$this->data['offering-sales']['response-offering']);
                        });

                        $writer->writeElement('investors', function ($writer){
                            if(isset($this->data['investors']['select'])){
                                $writer->writeElement('hasNonAccreditedInvestors', 'true');
                            } else {
                                $writer->writeElement('hasNonAccreditedInvestors', 'false');
                            }

                            if(isset($this->data['investors']['non-accredited']) && !empty($this->data['investors']['non-accredited'])){
                                $writer->writeElement('numberNonAccreditedInvestors',$this->data['investors']['non-accredited']);
                            }
//                            $writer->writeElement('numberNonAccreditedInvestors',$this->data['investors']['non-accredited']);
                            $writer->writeElement('totalNumberAlreadyInvested',$this->data['investors']['accredited']);
                        });

                        $writer->writeElement('salesCommissionsFindersFees', function ($writer){
                            $writer->writeElement('salesCommissions', function ($writer){
                                $sales =  str_replace(',', '', $this->data['sales']['sales']);
                                $writer->writeElement('dollarAmount',$sales);
                                if(isset($this->data['sales']['estimate-sales']) && $this->data['sales']['estimate-sales']!=""){
                                    $writer->writeElement('isEstimate', 'true');
                                }

                            });


                            $writer->writeElement('findersFees', function ($writer){
                                $finder_fees =  str_replace(',', '', $this->data['sales']['finder-fees']);
                                $writer->writeElement('dollarAmount', $finder_fees);

                                if(isset($this->data['sales']['estimate-fees']) && $this->data['sales']['estimate-fees']!=""){
                                    $writer->writeElement('isEstimate', 'true');
                                }
                            });
                            $writer->writeElement('clarificationOfResponse', $this->data['sales']['response-sales']);
                        });

                        $writer->writeElement('useOfProceeds', function ($writer){
                            $writer->writeElement('grossProceedsUsed', function ($writer){
                                $proceeds =  str_replace(',', '', $this->data['use-of-proceeds']['proceeds']);
                                $writer->writeElement('dollarAmount', $proceeds);
                                if(isset($this->data['use-of-proceeds']['estimate'])  && $this->data['use-of-proceeds']['estimate']!=""){
                                    $writer->writeElement('isEstimate', 'true');
                                }
                            });
                            $writer->writeElement('clarificationOfResponse',  $this->data['use-of-proceeds']['response-proceeds']);
                        });


                    $writer->writeElement('signatureBlock', function ($writer){
                        foreach ($this->data['signature'] as $issuer) {

                                $writer->writeElement('authorizedRepresentative', 'false');


                            $writer->writeElement('signature', function ($writer) use ($issuer){
                                $writer->writeElement('issuerName', $issuer['issuer']);
                                $writer->writeElement('signatureName', $issuer['signature']);
                                $writer->writeElement('nameOfSigner', $issuer['name-of-signer']);
                                $writer->writeElement('signatureTitle', $issuer['title']);
                                $writer->writeElement('signatureDate', $issuer['date']);
                            });
                        }
                    });


                 });

}));

        $xmlFileName = 'FormD.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

}
