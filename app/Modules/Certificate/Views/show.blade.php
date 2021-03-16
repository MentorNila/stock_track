@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Certificate Details
        <button type="button" style="float:right;" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1 pull-right">Print</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
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
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection