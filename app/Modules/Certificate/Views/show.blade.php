@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Certificate Details
        <button type="button" style="float:right;" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1 pull-right" id="printButton">Print</button>
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
            <div id="certificateDetails" class="text-center col-lg-12" style="padding: 15px;">
                <h2>This is to certify that</h2><br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8" style="border-bottom: 1px solid black;">
                        <h2>{{$certificate->shareholder->ref_name}}</h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>Is the owner of <span style="border-bottom: 1px solid black;">{{$certificate->total_shares}}</span> shares of stock</h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>of <span style="border-bottom: 1px solid black;">{{$activeCompanyName}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>on this <span style="border-bottom: 1px solid black;">{{date('F', strtotime($certificate->issued_date))}}</span> day of <span style="border-bottom: 1px solid black;">{{date('d', strtotime($certificate->issued_date))}}</span> in the year <span style="border-bottom: 1px solid black;">{{date('Y', strtotime($certificate->issued_date))}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <h2>at: <span style="border-bottom: 1px solid black;">{{date('d / m / Y', strtotime($certificate->issued_date))}}</span> </h2>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
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
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-3">
                        <p>SIGNED</p>
                        </div>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
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
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-3">
                        <p>SIGNED</p>
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
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // function printDiv() {

    //     var divToPrint = document.getElementById('certificateDetails');

    //     var newWin = window.open('', 'Print-Window');

    //     newWin.document.open();

    //     newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

    //     newWin.document.close();

    //     setTimeout(function() {
    //         newWin.close();
    //     }, 10);

    // }
    $(document).ready(function() {
        $('#printButton').on('click', function() {
            html2canvas(document.querySelector("#certificateDetails")).then(canvas => {
                var myImage = canvas.toDataURL("image/png");
                var tWindow = window.open("");
                $(tWindow.document.body)
                    .html("<img id='Image' src=" + myImage + " style='width:100%;'></img>")
                    .ready(function() {
                        tWindow.focus();
                        tWindow.print();
                    });
            });
        });
    });
</script>