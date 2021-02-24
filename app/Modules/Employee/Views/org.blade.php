@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Organization Chart</h1>
    </div>
</div>
<?php
$director = DB::table(App\Modules\User\Models\User::getTableName() . ' as director_user')
->join(App\Modules\Employee\Models\Employee::getTableName() . ' as director_employee', 'director_user.id', '=', 'director_employee.user_id')
->where('director_employee.supervisor_id', '=', NULL)
->select('director_user.first_name as first_name', 'director_user.last_name as last_name', 'director_employee.id', 'director_employee.job_title as job_title')
->first();
$secondaryEmployees = DB::table(App\Modules\User\Models\User::getTableName() . ' as user')
->join(App\Modules\Employee\Models\Employee::getTableName() . ' as employee', 'user.id', '=', 'employee.user_id')
->where('employee.supervisor_id', '=', $director->id)
->select('user.first_name as first_name', 'user.last_name as last_name', 'employee.id', 'employee.job_title as job_title')
->get();
?>
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ol class="organizational-chart">
                    <li>
                        <div style="max-width: 300px; border: 2px solid #dddddd; background-color: white;">
                           <h4 style="margin-bottom: 1px;">{{$director->first_name}} {{$director->last_name}}</h4>
                           <h7 style="margin-top: 1px;">{{$director->job_title}}</h7>
                        </div>
                        <ol>
                            @foreach($secondaryEmployees as $currentSecondaryEmployee)
                            <li>
                                <div style="border: 2px solid #dddddd; background-color: white;">
                                   <h5 style="margin-bottom: 1px;">{{$currentSecondaryEmployee->first_name}} {{$currentSecondaryEmployee->last_name}}</h5>
                                   <h7 style="margin-top: 1px;">{{$currentSecondaryEmployee->job_title}}</h7>
                                </div>
                                @if(isset($supervisors[$currentSecondaryEmployee->id]))
                                <ol>
                                    @foreach($supervisors[$currentSecondaryEmployee->id] as $currentSupervisorEmployee)
                                    <li>
                                        <div style="border: 2px solid #dddddd; background-color: white;">
                                           <h5 style="margin-bottom: 1px;">{{$currentSupervisorEmployee->first_name}} {{$currentSupervisorEmployee->last_name}}</h5>
                                           <h7 style="margin-top: 1px;">{{$currentSupervisorEmployee->job_title}}</h7>
                                        </div>
                                        @if(isset($supervisors[$currentSupervisorEmployee->id]))
                                        <ol>
                                            @foreach($supervisors[$currentSupervisorEmployee->id] as $employee)
                                            <li>
                                                <div style="border: 2px solid #dddddd; background-color: white;">
                                                   <h5 style="margin-bottom: 1px;">{{$employee->first_name}} {{$employee->last_name}}</h5>
                                                   <h7 style="margin-top: 1px;">{{$employee->job_title}}</h7>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                    @endforeach
                                </ol>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
<style type="text/css">
    ol.organizational-chart,
    ol.organizational-chart ol,
    ol.organizational-chart li,
    ol.organizational-chart li > div {
        position: relative;
    }

    ol.organizational-chart,
    ol.organizational-chart ol {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    ol.organizational-chart {
        text-align: center;
    }

    ol.organizational-chart ol {
        padding-top: 1em;
    }

    ol.organizational-chart ol:before,
    ol.organizational-chart ol:after,
    ol.organizational-chart li:before,
    ol.organizational-chart li:after,
    ol.organizational-chart > li > div:before,
    ol.organizational-chart > li > div:after {
        background-color: #b7a6aa;
        content: '';
        position: absolute;
    }

    ol.organizational-chart ol > li {
        padding: 1em 0 0 1em;
    }

    ol.organizational-chart > li ol:before {
        height: 1em;
        left: 50%;
        top: 0;
        width: 3px;
    }

    ol.organizational-chart > li ol:after {
        height: 3px;
        left: 3px;
        top: 1em;
        width: 50%;
    }

    ol.organizational-chart > li ol > li:not(:last-of-type):before {
        height: 3px;
        left: 0;
        top: 2em;
        width: 1em;
    }

    ol.organizational-chart > li ol > li:not(:last-of-type):after {
        height: 100%;
        left: 0;
        top: 0;
        width: 3px;
    }

    ol.organizational-chart > li ol > li:last-of-type:before {
        height: 3px;
        left: 0;
        top: 2em;
        width: 1em;
    }

    ol.organizational-chart > li ol > li:last-of-type:after {
        height: 2em;
        left: 0;
        top: 0;
        width: 3px;
    }

    ol.organizational-chart li > div {
        background-color: #fff;
        border-radius: 3px;
        min-height: 2em;
        padding: 0.5em;
    }

    /*** PRIMARY ***/
    ol.organizational-chart > li > div {
        background-color: #a2ed56;
        margin-right: 1em;
    }

    ol.organizational-chart > li > div:before {
        bottom: 2em;
        height: 3px;
        right: -1em;
        width: 1em;
    }

    ol.organizational-chart > li > div:first-of-type:after {
        bottom: 0;
        height: 2em;
        right: -1em;
        width: 3px;
    }

    ol.organizational-chart > li > div + div {
        margin-top: 1em;
    }

    ol.organizational-chart > li > div + div:after {
        height: calc(100% + 1em);
        right: -1em;
        top: -1em;
        width: 3px;
    }

    /*** SECONDARY ***/
    ol.organizational-chart > li > ol:before {
        left: inherit;
        right: 0;
    }

    ol.organizational-chart > li > ol:after {
        left: 0;
        width: 100%;
    }

    ol.organizational-chart > li > ol > li > div {
        background-color: #83e4e2;
    }

    /*** TERTIARY ***/
    ol.organizational-chart > li > ol > li > ol > li > div {
        background-color: #fd6470;
    }

    /*** QUATERNARY ***/
    ol.organizational-chart > li > ol > li > ol > li > ol > li > div {
        background-color: #fca858;
    }

    /*** QUINARY ***/
    ol.organizational-chart > li > ol > li > ol > li > ol > li > ol > li > div {
        background-color: #fddc32;
    }

    @media only screen and ( min-width: 64em ) {

        ol.organizational-chart {
            margin-left: -1em;
            margin-right: -1em;
        }

        /* PRIMARY */
        ol.organizational-chart > li > div {
            display: inline-block;
            float: none;
            margin: 0 1em 1em 1em;
            vertical-align: bottom;
        }

        ol.organizational-chart > li > div:only-of-type {
            margin-bottom: 0;
            width: calc((100% / 1) - 2em - 4px);
        }

        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(2),
        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(2) ~ div {
            width: calc((100% / 2) - 2em - 4px);
        }

        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(3),
        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(3) ~ div {
            width: calc((100% / 3) - 2em - 4px);
        }

        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(4),
        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(4) ~ div {
            width: calc((100% / 4) - 2em - 4px);
        }

        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(5),
        ol.organizational-chart > li > div:first-of-type:nth-last-of-type(5) ~ div {
            width: calc((100% / 5) - 2em - 4px);
        }

        ol.organizational-chart > li > div:before,
        ol.organizational-chart > li > div:after {
            bottom: -1em!important;
            top: inherit!important;
        }

        ol.organizational-chart > li > div:before {
            height: 1em!important;
            left: 50%!important;
            width: 3px!important;
        }

        ol.organizational-chart > li > div:only-of-type:after {
            display: none;
        }

        ol.organizational-chart > li > div:first-of-type:not(:only-of-type):after,
        ol.organizational-chart > li > div:last-of-type:not(:only-of-type):after {
            bottom: -1em;
            height: 3px;
            width: calc(50% + 1em + 3px);
        }

        ol.organizational-chart > li > div:first-of-type:not(:only-of-type):after {
            left: calc(50% + 3px);
        }

        ol.organizational-chart > li > div:last-of-type:not(:only-of-type):after {
            left: calc(-1em - 3px);
        }

        ol.organizational-chart > li > div + div:not(:last-of-type):after {
            height: 3px;
            left: -2em;
            width: calc(100% + 4em);
        }

        /* SECONDARY */
        ol.organizational-chart > li > ol {
            display: flex;
            flex-wrap: nowrap;
        }

        ol.organizational-chart > li > ol:before,
        ol.organizational-chart > li > ol > li:before {
            height: 1em!important;
            left: 50%!important;
            top: 0!important;
            width: 3px!important;
        }

        ol.organizational-chart > li > ol:after {
            display: none;
        }

        ol.organizational-chart > li > ol > li {
            flex-grow: 1;
            padding-left: 1em;
            padding-right: 1em;
            padding-top: 1em;
        }

        ol.organizational-chart > li > ol > li:only-of-type {
            padding-top: 0;
        }

        ol.organizational-chart > li > ol > li:only-of-type:before,
        ol.organizational-chart > li > ol > li:only-of-type:after {
            display: none;
        }

        ol.organizational-chart > li > ol > li:first-of-type:not(:only-of-type):after,
        ol.organizational-chart > li > ol > li:last-of-type:not(:only-of-type):after {
            height: 3px;
            top: 0;
            width: 50%;
        }

        ol.organizational-chart > li > ol > li:first-of-type:not(:only-of-type):after {
            left: 50%;
        }

        ol.organizational-chart > li > ol > li:last-of-type:not(:only-of-type):after {
            left: 0;
        }

        ol.organizational-chart > li > ol > li + li:not(:last-of-type):after {
            height: 3px;
            left: 0;
            top: 0;
            width: 100%;
        }

    }
</style>