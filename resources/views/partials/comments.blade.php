<style>
    .card {
        margin-bottom: 1rem;
    }
    .card-header {
        padding-bottom: 0;
    }
    p {
        margin-bottom: 0px;
    }
    h6 {
        font-size: 13px;
    }
    p {
        font-size: 13px;
    }
    i.bx.bx-check.resolve-comment:hover {
        background-color: #a7b3c047;
    }
    i.bx.bx-trash-alt.delete-comment:hover {
        background-color: #a7b3c047;
    }
</style>
<div style="background-color: #d7dadc;padding: 20px 10px 10px 10px;box-shadow: 5px 5px 25px #d7dadc;display: block;position: relative;min-width: 310px;max-width: 400px;overflow-y: scroll;height: 86vh;" id="comments">
    <div class="" style="margin-bottom: 1rem;">
        <div class="row" style="margin-right: 0">
            <div class="col-md-8" style="padding-right: 0;">
                <select id="filing-status" class="form-control">
                    <option>In progress</option>
                    <option>Not accepted</option>
                    <option>Review</option>
                    <option>Done</option>
                </select>
            </div>
            <div class="col-md-4" style="padding-right: 0">
                <button style="width: 100%;" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" data-toggle="modal" data-target="#commentsModal"><i class="bx bx-plus"></i></button>
            </div>
        </div>
    </div>
    @foreach($comments as $comment)
        <div data-id="{{ $comment->id }}" class="card" style="padding: 10px;">
            <div class="card-content" data-id="{{ $comment->id }}" data-parent="1">
                <div class="card-header user-profile-header" style="padding-right: 0;">
                    <div class="d-inline-block mt-25">
                        <h6 class="mb-0 text-bold-500">{{$comment->user->name}}</h6>
                        <p class="text-muted"><small>{{$comment->updated_at}}</small></p>
                    </div>
                    <i style="padding: 5px;color: #ff0000;" class='cursor-pointer bx bx-trash-alt float-right delete-comment'></i>
                    <i style="font-size: 30px;color: #1a72e8;margin-right: 5px;" class='cursor-pointer bx bx-check float-right resolve-comment'></i>
                </div>
                <div class="card-body py-0">
                    <p>{{$comment->body}}</p>
                </div>
                <hr>
            </div>
            @foreach($comment->children as $item)
                <div class="card-content" data-id="{{ $item->id }}" data-parent="0">
                    <div class="card-header user-profile-header" style="padding-right: 0;">
                        <div class="d-inline-block mt-25">
                            <h6 class="mb-0 text-bold-500">{{$item->name}}</h6>
                            <p class="text-muted"><small>{{$item->updated_at}}</small></p>
                        </div>
                        <i style="padding: 5px;color: #ff0000;" class='cursor-pointer bx bx-trash-alt float-right delete-comment'></i>
                    </div>
                    <div class="card-body py-0">
                        <p>{{$item->body}}</p>
                    </div>
                    <hr>
                </div>
            @endforeach
            <div class="form-group row align-items-center px-1" style="margin-bottom: 0;">
                <div class="col-sm-11 col-10">
                    <textarea class="form-control user-comment-textarea" id="user-comment-textarea" rows="1" placeholder="comment.."></textarea>
                </div>
            </div>
        </div>
    @endforeach

</div>
