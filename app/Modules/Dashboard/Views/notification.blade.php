@extends('layouts.user')
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">
@endsection
@section('content')
    <div class="card widget-notification">
        <div class="card-header border-bottom">
            <h4 class="card-title d-flex align-items-center">
                <i class='bx bx-bell font-medium-4 mr-1'></i>Notifications</h4>
            <div class="heading-elements">
                <button type="button" class="btn btn-sm btn-light-primary mark-all-as-read-button">Read All</button>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush notifications-list">
                    @foreach($notifications as $notification)
                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                            <div class="list-left d-flex">
                                <div class="list-icon mr-1">
                                    <div class="avatar bg-rgba-primary m-0 p-25">
                                        <div class="avatar-content">
                                            <i class="bx bx-edit-alt text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-content">
                                    <span class="list-title @if(!is_null($notification->read_at)) text-bold-500 @endif">{{$notification->data['message']}}</span>
                                    <small class="text-muted d-block">{{$notification->created_at}}</small>
                                </div>
                            </div>
                            @if(!is_null($notification->read_at))
                                <div class="readable-mark-icon mark-as-unread" data-toggle="tooltip" data-id={{$notification->id}} data-placement="left" title="Mark as Unread">
                                    <i class='bx bxs-circle text-light-primary font-medium-1'></i>
                                </div>
                            @else
                                <div class="readable-mark-icon mark-as-read" data-toggle="tooltip" data-id={{$notification->id}} data-placement="left" title="Mark as read">
                                    <i class='bx bxs-circle text-light-primary font-medium-1'></i>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="module" src="{{asset('js/scripts/notification.js')}}"></script>
@endsection
