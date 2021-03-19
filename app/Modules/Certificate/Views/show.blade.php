@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Certificate Details
        <button type="button" style="float:right;" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1 pull-right">Print</button>
    </div>
    <div class="card-body">
        <!-- <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            Stock Class
                        </th>
                        <th>
                            Total Shares
                        </th>
                        <th>
                            Issued Date
                        </th>
                        <th>
                            Number of Paper Certificates to Issue
                        </th>
                        <th>
                            Reason/Reservation
                        </th>
                        <th>
                            Received From
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{$certificate->stock_class}}
                        </td>
                        <td>
                            {{$certificate->total_shares}}
                        </td>
                        <td>
                            {{$certificate->issued_date}}
                        </td>
                        <td>
                            {{$certificate->number_of_paper_certificates_to_issue}}
                        </td>
                        <td>
                            {{$certificate->reservation}}
                        </td>
                        <td>
                            {{$certificate->received_from}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> -->
        <div class="row">
            <div id="certificateDetails" class="text-center col-lg-12">
                <h2>This is to certify that</h2><br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8" style="border-bottom: 1px solid black;">
                        <h2>{{$certificate->name_as_appears_on_certificate}}</h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>Is the owner of <span style="text-decoration:underline;">{{$certificate->total_shares}}</span> shares of stock</h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>of <span style="text-decoration:underline;">{{$activeCompanyName}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>on this <span style="text-decoration:underline;">{{date('F', strtotime($certificate->issued_date))}}</span> day of <span style="text-decoration:underline;">{{date('d', strtotime($certificate->issued_date))}}</span> in the year <span style="text-decoration:underline;">{{date('Y', strtotime($certificate->issued_date))}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>at: <span style="text-decoration:underline;">{{date('d / m / Y', strtotime($certificate->issued_date))}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-3" style="border-bottom: 1px solid black;">
                        </div>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row" style="margin-top:20px;">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-3" style="border-bottom: 1px solid black;">
                        </div>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
            </div>
        </div>

        <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>
</div>
@endsection