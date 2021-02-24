@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{$review->title}} of {{$review->first_name}} {{$review->last_name}}
    </div>
    <div class="card-body">
        <div class="row" >
            <div class="col-lg-12" style="padding-top: 0px;">
                <div class="row" style="margin-top:0px;">
                    <div class="col-lg-3">
                        <div style="border-radius: 5px; background-color: #e2e6eb; padding: 20px; color:black; font-size:13px;" class="">
                            <b>Started</b>  
                            <?php
                            $startDate=date_create($review->start_date);
                            ?>
                            {{date_format($startDate,"M d, Y H:i")}}
                            <br>
                            <b>Review Forms</b>  {{count($reviewForms)}}<br>
                            <b>Actions Involved</b>  0
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-7">
                        <h5 style="text-decoration: underline; text-decoration: bold;">Review Forms</h5>
                        <div class="forms row" style="border-radius: 5px; background-color: #e2e6eb; padding: 20px; color:black; font-size:13px;">
                            @foreach($reviewForms as $key => $reviewForm)
                            <div style="width:60%;">
                                <div id="firstRow" style=" padding:10px;" class="row">
                                    <button class="btn btn-xs btn-primary" style="margin-right:5px;">View</button>
                                    <button class="btn btn-xs btn-primary">Edit</button>
                                </div>
                                <b><h7 id="formName">End Year Performance Review</h7></b>
                                <br>
                                <div id="formContent" style="padding-top:15px;">
                                    <div id="titleContent" style="float:left;">
                                        <p style="margin-bottom: 0px; margin-top:0px;">Who authors this form:</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">Who signs off on this form:</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">Due Date (authors):</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">Due Date (signers):</p>
                                    </div>
                                    <div id="dataContent" style="float:left; margin-left:5px;">
                                        <p style="margin-bottom: 0px; margin-top:0px;">{{$reviewForm->author_first_name}} {{$reviewForm->author_last_name}}</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">{{$reviewForm->signer_first_name}} {{$reviewForm->signer_last_name}}</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">{{$reviewForm->due_date_authors}}</p>
                                        <p style="margin-bottom: 0px; margin-top:0px;">{{$reviewForm->due_date_signers}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-1">

                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a style="margin-top:20px;" class="btn btn-default pull-right" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>
@endsection
