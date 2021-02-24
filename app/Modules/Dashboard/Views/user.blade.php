@extends('layouts.user')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">

    <style rel="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></style>
    <style rel="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></style>
    <style rel="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"></style>
@endsection

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection
{{-- title --}}
@section('title','Dashboard Analytics')

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            <!-- Activity Card Starts-->
            <div class="col-xl-3 col-md-6 col-12 activity-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Activity</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="d-flex activity-content">
                                <div class="avatar bg-rgba-primary m-0 mr-75">
                                    <div class="avatar-content">
                                        <i class="bx bx-bar-chart-alt-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="activity-progress flex-grow-1">
                                    <small class="text-muted d-inline-block mb-50">Total Companies</small>
                                    <small class="float-right">{{$totalCompanies}}</small>
                                    <div class="progress progress-bar-primary progress-sm">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="50" style="width:50%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex activity-content">
                                <div class="avatar bg-rgba-success m-0 mr-75">
                                    <div class="avatar-content">
                                        <i class="bx bx-dollar text-success"></i>
                                    </div>
                                </div>
                                <div class="activity-progress flex-grow-1">
                                    <small class="text-muted d-inline-block mb-50">Total Filings</small>
                                    <small class="float-right">{{$totalFilings}}</small>
                                    <div class="progress progress-bar-success progress-sm">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="80" style="width:80%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex activity-content">
                                <div class="avatar bg-rgba-warning m-0 mr-75">
                                    <div class="avatar-content">
                                        <i class="bx bx-stats text-warning"></i>
                                    </div>
                                </div>
                                <div class="activity-progress flex-grow-1">
                                    <small class="text-muted d-inline-block mb-50">Completed Filings</small>
                                    <small class="float-right">0</small>
                                    <div class="progress progress-bar-warning progress-sm">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" style="width:0%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-75">
                                <div class="avatar bg-rgba-danger m-0 mr-75">
                                    <div class="avatar-content">
                                        <i class="bx bx-check text-danger"></i>
                                    </div>
                                </div>
                                <div class="activity-progress flex-grow-1">
                                    <small class="text-muted d-inline-block mb-50">Actions</small>
                                    <small class="float-right">{{$activities}}</small>
                                    <div class="progress progress-bar-danger progress-sm">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="30" style="width:30%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profit Report Card Starts-->
            <div class="col-xl-3 col-md-6 col-12 profit-report-card">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Profit Report</h4>
                                <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-0 d-flex justify-content-around">
                                    <div class="d-inline-flex mr-xl-2">
                                        <div id="profit-primary-chart"></div>
                                        <div class="profit-content ml-50 mt-50">
                                            <h5 class="mb-0">$12k</h5>
                                            <small class="text-muted">2019</small>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex">
                                        <div id="profit-info-chart"></div>
                                        <div class="profit-content ml-50 mt-50">
                                            <h5 class="mb-0">$64k</h5>
                                            <small class="text-muted">2019</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Requests</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="d-flex align-items-end justify-content-around">
                                        <div class="registration-content mr-xl-2">
                                            <h4 class="mb-0">0</h4>
                                            <i class="bx bx-trending-up success align-middle"></i>
                                            <span class="text-success">0</span>
                                        </div>
                                        <div id="registration-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart Starts-->
            <div class="col-xl-3 col-md-6 col-12 sales-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title-content">
                            <h4 class="card-title">Sales</h4>
                            <small class="text-muted">Calculated in last 7 days</small>
                        </div>
                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="sales-chart" class="mb-2"></div>
                            <div class="d-flex justify-content-between my-1">
                                <div class="sales-info d-flex align-items-center">
                                    <i class='bx bx-up-arrow-circle text-primary font-medium-5 mr-50'></i>
                                    <div class="sales-info-content">
                                        <h6 class="mb-0">Best Selling</h6>
                                        <small class="text-muted">Sunday</small>
                                    </div>
                                </div>
                                <h6 class="mb-0">28.6k</h6>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="sales-info d-flex align-items-center">
                                    <i class='bx bx-down-arrow-circle icon-light font-medium-5 mr-50'></i>
                                    <div class="sales-info-content">
                                        <h6 class="mb-0">Lowest Selling</h6>
                                        <small class="text-muted">Thursday</small>
                                    </div>
                                </div>
                                <h6 class="mb-0">986k</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Growth Chart Starts-->
            <div class="col-xl-3 col-md-6 col-12 growth-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButtonSec"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                2019
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSec">
                                <a class="dropdown-item" href="#">2019</a>
                                <a class="dropdown-item" href="#">2018</a>
                                <a class="dropdown-item" href="#">2017</a>
                            </div>
                        </div>
                        <div id="growth-Chart"></div>
                        <h6 class="mb-0"> 62% Company Growth in 2019</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Companies Analytics</h4>
                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-body pb-1" id="companies_per_month" data-label="Companies">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="user-analytics">
                                    <select class="chartSelect select2">
                                        @if(!empty($companies_per_month))
                                            @foreach($companies_per_month as $name => $value)
                                                @if($name == date('Y'))
                                                    <option value="{{$value}}">This Year</option>
                                                @else
                                                    <option value="{{$value}}">{{$name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <canvas width="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Filings Analytics</h4>
                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-body pb-1 chart" id="company_filing_per_month" data-label="Filings per company">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="sessions-analytics">
                                    <select class="chartSelect select2">
                                        @if(!empty($company_filing_per_month))
                                            @foreach($company_filing_per_month as $name => $value)
                                                @if($name == date('Y'))
                                                    <option value="{{$value}}">This Year</option>
                                                @else
                                                    <option value="{{$value}}">{{$name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="sessions-analytics">
                                    <select class="companiesSelect select2">
                                        @if(!empty($companies))
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <canvas width="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-scripts')

    <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
@endsection


@section('page-scripts')
    <script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="{{asset('js/scripts/dashboard.js')}}"></script>
@endsection
