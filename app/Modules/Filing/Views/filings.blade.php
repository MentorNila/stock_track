@extends('layouts.user')

@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/jkanban/jkanban.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

{{-- page styles --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-kanban.css')}}">
    <style>
        .kanban-item {
            cursor: pointer !important;
        }
    </style>
@endsection

@section('content')
    <div class="kanban-overlay"></div>
    <section id="kanban-wrapper">
        <div class="row">
            <div class="col-12">
                <div id="kanban-app"></div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-scripts')
    <script src="{{asset('vendors/js/jkanban/jkanban.min.js')}}"></script>
    <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script>
        var filingsProgress = [];
        var filingsIdle = [];
        @foreach($filings as $filing )
            @if($filing->status == 'idle')
                filingsIdle.push({ id: '{{ $filing->id }}', title: '{{ $filing->filing_type }} - {{ $filing->client_name }}', border: "info", dueDate: '{{ $filing->created_at }}'});
            @elseif($filing->status == 'in progress')
                filingsProgress.push({ id: '{{ $filing->id }}', title: '{{ $filing->filing_type }} - {{ $filing->client_name }}', border: "secondary", dueDate: '{{ $filing->created_at }}'});
            @endif
        @endforeach
    </script>
    <script src="{{asset('js/scripts/pages/app-kanban.js')}}"></script>

@endsection
