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
        <h1>Reviews</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" href="{{ route("admin.reviews.create") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
    </div>
</div>
@endcan
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Review Name</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $key => $review)
                            <tr>
                                <td>{{$review->first_name}} {{$review->last_name}}</td>
                                <td>{{$review->title}}</td>
                                <td>
                                    <?php
                                    $startDate=date_create($review->start_date);
                                    ?>
                                    {{date_format($startDate,"M d, Y H:i")}}
                                </td>
                                <td>
                                    {{ App\Modules\Review\Classes\ReviewStatusCode::returnCode($review->status) }}
                                </td>
                                <td>
                                    <a href="/admin/reviews/view/{{$review->id}}">
                                        <i class="fas fa-align-justify"></i>
                                    </a>
                                    <a href="/admin/reviews/delete/{{$review->id}}" title="delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
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
