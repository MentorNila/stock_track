<?php

namespace App\Modules\Filing\XBRL;

include base_path().'/vendor/autoload.php';

use App\Modules\Filing\Logic\GetFilingData;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service;

class FormFourGenerator {
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

    public function setCompany(){
        $filingData = new GetFilingData($this->filingId);
        $this->company = $filingData->getCompany();
    }
    public function generateXml(){

        $this->writer = ($this->service->write('ownershipDocument', function ($writer) {
            $writer->writeElement('schemaVersion', 'X0306');
            $writer->writeElement('documentType', '4');
            if(isset($this->data['general-data']['event-dates']) && !empty($this->data['general-data']['event-dates'])){
                $this->data['general-data']['event-dates'] = strtotime($this->data['general-data']['event-dates']);
                $this->data['general-data']['event-dates'] = date("Y-m-d", $this->data['general-data']['event-dates']);
                $writer->writeElement('periodOfReport', $this->data['general-data']['event-dates']);
            }            $writer->writeElement('notSubjectToSection16', $this->data['general-data']['section-16']);

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
                            $writer->writeElement('isTenPercentOwner', $generalData['owner']);
                            $writer->writeElement('isOther', $generalData['other']);
                            if(isset($generalData['officerTitle']) && !empty($generalData['officerTitle'])){
                                $writer->writeElement('officerTitle', $generalData['officerTitle']);
                            }
                        });
                    });
                }
            }


                $writer->writeElement('nonDerivativeTable', function ($writer) {
                    foreach ($this->data['non-derivative'] as $nonDerivative) {
                        $writer->writeElement('nonDerivativeTransaction', function ($writer) use ($nonDerivative){
                            if(isset($nonDerivative['title']) && !empty($nonDerivative['title'])){
                                $writer->writeElement('securityTitle', function ($writer) use ($nonDerivative){
                                    $writer->writeElement('value', $nonDerivative['title']);
                                });
                            }

                            $writer->writeElement('transactionDate', function ($writer) use ($nonDerivative){
                                if((isset($nonDerivative['transaction-date']) && !empty($nonDerivative['transaction-date'])) || (isset($nonDerivative['transaction-date-num']) && !empty($nonDerivative['transaction-date-num']))){
                                    if(isset($nonDerivative['transaction-date']) && !empty($nonDerivative['transaction-date'])){
                                        $nonDerivative['transaction-date'] = strtotime($nonDerivative['transaction-date']);
                                        $nonDerivative['transaction-date'] = date("Y-m-d", $nonDerivative['transaction-date']);
                                        $writer->writeElement('value', $nonDerivative['transaction-date']);
                                    }
                                    if(isset($nonDerivative['transaction-date-num']) && !empty($nonDerivative['transaction-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['transaction-date-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('deemedExecutionDate', function ($writer) use ($nonDerivative){
                                if((isset($nonDerivative['deemed-ex-date']) && !empty($nonDerivative['deemed-ex-date'])) || (isset($nonDerivative['deemed-ex-date-num']) && !empty($nonDerivative['deemed-ex-date-num']))){
                                    if(isset($nonDerivative['deemed-ex-date']) && !empty($nonDerivative['deemed-ex-date'])){
                                        $nonDerivative['deemed-ex-date'] = strtotime($nonDerivative['deemed-ex-date']);
                                        $nonDerivative['deemed-ex-date'] = date("Y-m-d", $nonDerivative['deemed-ex-date']);
                                        $writer->writeElement('value', $nonDerivative['deemed-ex-date']);
                                    }
                                    if(isset($nonDerivative['deemed-ex-date-num']) && !empty($nonDerivative['deemed-ex-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['deemed-ex-date-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('transactionCoding', function ($writer) use ($nonDerivative){
                                $writer->writeElement('transactionFormType', '4');
                                if(isset($nonDerivative['code']) && !empty($nonDerivative['code'])){
                                    $writer->writeElement('transactionCode', $nonDerivative['code']);
                                }
                                if(isset($nonDerivative['code-num']) && !empty($nonDerivative['code-num'])){
                                    $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                        $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['code-num']);
                                        $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                    });
                                }

                                if(isset($nonDerivative['v']) && !empty($nonDerivative['v'])){
                                    $writer->writeElement('equitySwapInvolved', $nonDerivative['v']);
                                } else {
                                    $writer->writeElement('equitySwapInvolved', '0');
                                }
                                if(isset($nonDerivative['v-num']) && !empty($nonDerivative['v-num'])){
                                    $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                        $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['v-num']);
                                        $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                    });
                                }
                            });

                            $writer->writeElement('transactionAmounts', function ($writer) use ($nonDerivative){
                                if((isset($nonDerivative['amount']) && !empty($nonDerivative['amount'])) || isset($nonDerivative['amount-num']) && !empty($nonDerivative['amount-num'])){
                                    $writer->writeElement('transactionShares', function ($writer) use ($nonDerivative){
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
                                }
                                if((isset($nonDerivative['price']) && !empty($nonDerivative['price'])) || isset($nonDerivative['price-num']) && !empty($nonDerivative['price-num'])){
                                    $writer->writeElement('transactionPricePerShares', function ($writer) use ($nonDerivative){
                                        if(isset($nonDerivative['price']) && !empty($nonDerivative['price'])){
                                            $nonDerivative['price'] = str_replace('$', '', $nonDerivative['price']);
                                            $writer->writeElement('value', $nonDerivative['price']);
                                        }
                                        if(isset($nonDerivative['price-num']) && !empty($nonDerivative['price-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['price-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                                if((isset($nonDerivative['ad']) && !empty($nonDerivative['ad'])) || isset($nonDerivative['ad-num']) && !empty($nonDerivative['ad-num'])){
                                    $writer->writeElement('transactionAcquiredDisposedCode', function ($writer) use ($nonDerivative){
                                        if(isset($nonDerivative['ad']) && !empty($nonDerivative['ad'])){
                                            $nonDerivative['ad'] = str_replace(',', '', $nonDerivative['ad']);
                                            $writer->writeElement('value', $nonDerivative['ad']);
                                        }
                                        if(isset($nonDerivative['ad-num']) && !empty($nonDerivative['ad-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['ad-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });

                            $writer->writeElement('postTransactionAmounts', function ($writer) use ($nonDerivative){
                                if((isset($nonDerivative['secben']) && !empty($nonDerivative['secben'])) || isset($nonDerivative['secben-num']) && !empty($nonDerivative['secben-num'])){
                                    $writer->writeElement('sharesOwnedFollowingTransaction', function ($writer) use ($nonDerivative){
                                        if(isset($nonDerivative['secben'])){
                                            $nonDerivative['secben'] = str_replace(',', '', $nonDerivative['secben']);
                                            $writer->writeElement('value', $nonDerivative['secben']);
                                        }
                                        if(isset($nonDerivative['secben-num']) && !empty($nonDerivative['secben-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['secben-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });

                            $writer->writeElement('ownershipNature', function ($writer) use ($nonDerivative){
                                $writer->writeElement('directOrIndirectOwnership', function ($writer) use ($nonDerivative){
                                    if((isset($nonDerivative['owner']) && !empty($nonDerivative['owner'])) || (isset($nonDerivative['owner-num']) && !empty($nonDerivative['owner-num']))){
                                        if(isset($nonDerivative['owner']) && !empty($nonDerivative['owner'])){
                                            $writer->writeElement('value', $nonDerivative['owner']);
                                        }
                                        if(isset($nonDerivative['owner-num']) && !empty($nonDerivative['owner-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($nonDerivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $nonDerivative['owner-num']);
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

            if(isset($this->data['derivative']) && !empty($this->data['derivative'])){
                $writer->writeElement('derivativeTable', function ($writer) {
                    foreach ($this->data['derivative'] as $derivative) {
                        $writer->writeElement('derivativeTransaction', function ($writer) use ($derivative){
                            if(isset($derivative['title']) && !empty($derivative['title'])){
                                $writer->writeElement('securityTitle', function ($writer) use ($derivative){
                                    $writer->writeElement('value', $derivative['title']);
                                });
                            }

                            $writer->writeElement('conversionOrExercisePrice', function ($writer) use ($derivative){
                                if((isset($derivative['conversion']) && !empty($derivative['conversion'])) || (isset($derivative['conversion-num']) && !empty($derivative['conversion-num']))){
                                    if(isset($derivative['conversion']) && !empty($derivative['conversion'])){
                                        $derivative['conversion'] = str_replace('$', '', $derivative['conversion']);
                                        $writer->writeElement('value', $derivative['conversion']);
                                    }
                                    if(isset($derivative['conversion-num']) && !empty($derivative['conversion-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['conversion-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('transactionDate', function ($writer) use ($derivative){
                                if((isset($derivative['transaction-date']) && !empty($derivative['transaction-date'])) || (isset($derivative['transaction-date-num']) && !empty($derivative['transaction-date-num']))){
                                    if(isset($derivative['transaction-date']) && !empty($derivative['transaction-date'])){
                                        $derivative['transaction-date'] = strtotime($derivative['transaction-date']);
                                        $derivative['transaction-date'] = date("Y-m-d", $derivative['transaction-date']);
                                        $writer->writeElement('value', $derivative['transaction-date']);
                                    }
                                    if(isset($derivative['transaction-date-num']) && !empty($derivative['transaction-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['transaction-date-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('deemedExecutionDate', function ($writer) use ($derivative){
                                if((isset($derivative['deemed-date']) && !empty($derivative['deemed-date'])) || (isset($derivative['deemed-date-num']) && !empty($derivative['deemed-date-num']))){
                                    if(isset($derivative['deemed-date']) && !empty($derivative['deemed-date'])){
                                        $derivative['deemed-date'] = strtotime($derivative['deemed-date']);
                                        $derivative['deemed-date'] = date("Y-m-d", $derivative['deemed-date']);
                                        $writer->writeElement('value', $derivative['deemed-date']);
                                    }
                                    if(isset($derivative['deemed-date-num']) && !empty($derivative['deemed-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['deemed-date-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('transactionCoding', function ($writer) use ($derivative){
                                $writer->writeElement('transactionFormType', '4');
                                if(isset($derivative['code']) && !empty($derivative['code'])){
                                    $writer->writeElement('transactionCode', $derivative['code']);
                                }

                                if(isset($derivative['code-num']) && !empty($derivative['code-num'])){
                                    $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                        $footnote_id = str_replace(array('(', ')'), '', $derivative['code-num']);
                                        $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                    });
                                }
                                if(isset($derivative['v']) && !empty($derivative['v'])){
                                    $writer->writeElement('equitySwapInvolved', $derivative['v']);
                                } else {
                                    $writer->writeElement('equitySwapInvolved', '0');
                                }
                                if(isset($derivative['v-num']) && !empty($derivative['v-num'])){
                                    $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                        $footnote_id = str_replace(array('(', ')'), '', $derivative['v-num']);
                                        $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                    });
                                }
                            });

                            $writer->writeElement('transactionAmounts', function ($writer) use ($derivative){
                                if((isset($derivative['shares']) && !empty($derivative['shares'])) || isset($derivative['shares-num']) && !empty($derivative['shares-num'])){
                                    $writer->writeElement('transactionShares', function ($writer) use ($derivative){
                                        if(isset($derivative['shares']) && !empty($derivative['shares'])){
                                            $derivative['shares'] = str_replace(',', '', $derivative['shares']);
                                            $writer->writeElement('value', $derivative['shares']);
                                        }
                                        if(isset($derivative['shares-num']) && !empty($derivative['shares-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['shares-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                                if((isset($derivative['derivative']) && !empty($derivative['derivative'])) || isset($derivative['derivative-num']) && !empty($derivative['derivative-num'])){
                                    $writer->writeElement('transactionPricePerShares', function ($writer) use ($derivative){
                                        if(isset($derivative['derivative'])){
                                        $derivative['derivative'] = str_replace('$', '', $derivative['derivative']);
                                        $writer->writeElement('value', $derivative['derivative']);
                                        }
                                        if(isset($derivative['derivative-num']) && !empty($derivative['derivative-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['derivative-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                                if((isset($derivative['a']) && !empty($derivative['a'])) || isset($derivative['a-num']) && !empty($derivative['a-num'])){
                                    $writer->writeElement('transactionAcquiredDisposedCode', function ($writer) use ($derivative){
                                        if(isset($derivative['a']) && !empty($derivative['a'])){
                                            $derivative['a'] = str_replace(',', '', $derivative['a']);
                                            $writer->writeElement('value', $derivative['a']);
                                        }
                                        if(isset($derivative['a-num']) && !empty($derivative['a-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['a-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                                if((isset($derivative['d']) && !empty($derivative['d'])) || isset($derivative['d-num']) && !empty($derivative['d-num'])){
                                    $writer->writeElement('transactionAcquiredDisposedCode', function ($writer) use ($derivative){
                                        if(isset($derivative['d']) && !empty($derivative['d'])){
                                            $derivative['d'] = str_replace(',', '', $derivative['d']);
                                            $writer->writeElement('value', $derivative['d']);
                                        }
                                        if(isset($derivative['d-num']) && !empty($derivative['d-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['d-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });

                            $writer->writeElement('exerciseDate', function ($writer) use ($derivative){
                                if((isset($derivative['exercisable-date']) && !empty($derivative['exercisable-date'])) || (isset($derivative['exercisable-date-num']) && !empty($derivative['exercisable-date-num']))){
                                    if(isset($derivative['exercisable-date']) && !empty($derivative['exercisable-date'])){
                                        $derivative['exercisable-date'] = strtotime($derivative['exercisable-date']);
                                        $derivative['exercisable-date'] = date("Y-m-d", $derivative['exercisable-date']);
                                        $writer->writeElement('value', $derivative['exercisable-date']);
                                    }
                                    if(isset($derivative['exercisable-date-num']) && !empty($derivative['exercisable-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['exercisable-date-num']);

                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                    if(isset($derivative['exercisable-date-num-second']) && !empty($derivative['exercisable-date-num-second'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['exercisable-date-num-second']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('expirationDate', function ($writer) use ($derivative){
                                if((isset($derivative['expiration-date']) && !empty($derivative['expiration-date'])) || (isset($derivative['expiration-date-num']) && !empty($derivative['expiration-date-num']))){
                                    if(isset($derivative['expiration-date']) && !empty($derivative['expiration-date'])){
                                        $derivative['expiration-date'] = strtotime($derivative['expiration-date']);
                                        $derivative['expiration-date'] = date("Y-m-d", $derivative['expiration-date']);
                                        $writer->writeElement('value', $derivative['expiration-date']);
                                    }
                                    if(isset($derivative['expiration-date-num']) && !empty($derivative['expiration-date-num'])){
                                        $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                            $footnote_id = str_replace(array('(', ')'), '', $derivative['expiration-date-num']);
                                            $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                        });
                                    }
                                }
                            });

                            $writer->writeElement('underlyingSecurity', function ($writer) use ($derivative){
                                if((isset($derivative['title-am']) && !empty($derivative['title-am'])) || isset($derivative['title-am-num']) && !empty($derivative['title-am-num'])){
                                    $writer->writeElement('underlyingSecurityTitle', function ($writer) use ($derivative){
                                        if(isset($derivative['title-am']) && !empty($derivative['title-am'])){
                                            $writer->writeElement('value', $derivative['title-am']);
                                        }
                                        if(isset($derivative['title-am-num']) && !empty($derivative['title-am-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['title-am-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                                if((isset($derivative['shares']) && !empty($derivative['shares'])) || isset($derivative['shares-num']) && !empty($derivative['shares-num'])){
                                    $writer->writeElement('underlyingSecurityShares', function ($writer) use ($derivative){
                                        if(isset($derivative['shares']) && !empty($derivative['shares'])){
                                            $derivative['shares'] = str_replace(',', '', $derivative['shares']);
                                            $writer->writeElement('value', $derivative['shares']);
                                        }
                                        if(isset($derivative['shares-num']) && !empty($derivative['shares-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['shares-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });

                            $writer->writeElement('postTransactionAmounts', function ($writer) use ($derivative){
                                if((isset($derivative['num-dev']) && !empty($derivative['num-dev'])) || isset($derivative['num-dev-num']) && !empty($derivative['num-dev-num'])){
                                    $writer->writeElement('sharesOwnedFollowingTransaction', function ($writer) use ($derivative){
                                        if(isset($derivative['num-dev']) && !empty($derivative['num-dev'])){
                                            $derivative['num-dev'] = str_replace(',', '', $derivative['num-dev']);
                                            $writer->writeElement('value', $derivative['num-dev']);
                                        }
                                        if(isset($derivative['num-dev-num']) && !empty($derivative['num-dev-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['num-dev-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }

                                    });
                                }
                            });

                            $writer->writeElement('ownershipNature', function ($writer) use ($derivative){
                                $writer->writeElement('directOrIndirectOwnership', function ($writer) use ($derivative){
                                    if((isset($derivative['ownership']) && !empty($derivative['ownership'])) || (isset($derivative['ownership-num']) && !empty($derivative['ownership-num']))){
                                        if(isset($derivative['ownership']) && !empty($derivative['ownership'])){
                                            $writer->writeElement('value', $derivative['ownership']);
                                        }
                                        if(isset($derivative['ownership-num']) && !empty($derivative['ownership-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
                                                $footnote_id = str_replace(array('(', ')'), '', $derivative['ownership-num']);
                                                $writer->writeAttributes(['id' => 'F'.$footnote_id]);
                                            });
                                        }
                                    }
                                });
                                if((isset($derivative['nature']) && !empty($derivative['nature'])) || isset($derivative['nature-num']) && !empty($derivative['nature-num'])){
                                    $writer->writeElement('natureOfOwnership', function ($writer) use ($derivative){
                                        if(isset($derivative['nature']) && !empty($derivative['nature'])){
                                            $writer->writeElement('value', $derivative['nature']);
                                        }
                                        if(isset($derivative['nature-num']) && !empty($derivative['nature-num'])){
                                            $writer->writeElement('footnoteId', function ($writer) use ($derivative){
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

//
//                $writer->writeElement('remarks', function ($writer) {
//                    foreach ($this->data['remarks'] as $remark) {
//                        if(!empty($remark)){
//
//                                $writer->write($remark);
//
//                        }
//                    }
//                });

            $writer->writeElement('remarks', function ($writer) {
                foreach ($this->data['remarks'] as $remark) {
                    $writer->writeElement('remarks',  $remark);
                }
            });


            if(isset($this->data['signatures'])  && !empty($this->data['signatures'])){
                foreach ($this->data['signatures'] as $signature) {
                    if(!empty($signature['sig-person']) || !empty($signature['date'])){
                        $writer->writeElement('ownerSignature', function ($writer) use ($signature) {
                            if(isset($signature['sig-person']) && !empty($signature['sig-person'])){
                                $writer->writeElement('signatureName', $signature['sig-person']);
                            }
                            if(isset($signature['date']) && !empty($signature['date'])){
                                $signature['date'] = strtotime($signature['date']);
                                $signature['date'] = date("Y-m-d", $signature['date']);
                                $writer->writeElement('signatureDate', $signature['date']);
                            }
                        });
                    }
                }
            }
        }));

        $xmlFileName = 'Form4.xml';
        $xmlFilePath = storage_path($xmlFileName);
        File::put($xmlFilePath, $this->writer);

        return [$xmlFileName => $xmlFilePath];
    }

}
