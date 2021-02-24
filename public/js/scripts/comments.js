$( "#add-comment" ).click(function(e) {
    e.preventDefault();
    var comment = $('#comment').val();
    $.ajax({
        type: 'POST',
        data: {
            filingId: filingID,
            body: comment
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/review/add-comment',
        success: function (response) {
            if (response.success === true){
                $('#commentsModal').modal('hide');
                $('#addCommentForm').trigger("reset");
                $('#comments').append('<div class="card" data-id="' + response.comment_id + '" style="padding: 10px;">\n' +
                    '        <div class="card-content" data-id="' + response.comment_id + '" data-parent="1">\n' +
                    '            <div class="card-header user-profile-header" style="padding-right: 0;">\n' +
                    '                <div class="d-inline-block mt-25">\n' +
                    '                    <h6 class="mb-0 text-bold-500">' + response.user_name + '</h6>\n' +
                    '                    <p class="text-muted"><small>3 seconds ago</small></p>\n' +
                    '                </div>\n' +
                    '                <i style="padding: 5px;color: #ff0000;" class=\'cursor-pointer bx bx-trash-alt float-right delete-comment\'></i>\n' +
                    '                <i style="font-size: 30px;color: #1a72e8;margin-right: 5px;" class=\'cursor-pointer bx bx-check float-right resolve-comment\'></i>\n' +
                    '            </div>\n' +
                    '            <div class="card-body py-0">\n' +
                    '                <p>' + response.body + '</p>\n' +
                    '            </div>\n' +
                    '            <hr>\n' +
                    '        </div>\n' +
                    '        <div class="form-group row align-items-center px-1" style="margin-bottom: 0;">\n' +
                    '            <div class="col-sm-11 col-10">\n' +
                    '                <textarea class="form-control user-comment-textarea" id="user-comment-textarea" rows="1" placeholder="comment.."></textarea>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>');
            }
        }
    });
});

$('body').on('keypress','.user-comment-textarea', function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {

        var comment = $(this).val();
        var parent_id = $(this).closest('.card').data('id');
        var card_content = $(this).closest('.card').children('.card-content').last();
        $.ajax({
            type: 'POST',
            data: {
                filingId: filingID,
                body: comment,
                parent_id: parent_id
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/review/add-comment',
            success: function (response) {
                if (response.success === true){
                    $(  '        <div class="card-content" data-id="' + response.comment_id + '" data-parent="0">\n' +
                        '            <div class="card-header user-profile-header" style="padding-right: 0;">\n' +
                        '                <div class="d-inline-block mt-25">\n' +
                        '                    <h6 class="mb-0 text-bold-500">' + response.user_name + '</h6>\n' +
                        '                    <p class="text-muted"><small>3 seconds ago</small></p>\n' +
                        '                </div>\n' +
                        '                <i style="padding: 5px;color: #ff0000;" class=\'cursor-pointer bx bx-trash-alt float-right delete-comment\'></i>\n' +
                        '            </div>\n' +
                        '            <div class="card-body py-0">\n' +
                        '                <p>' + response.body + '</p>\n' +
                        '            </div>\n' +
                        '            <hr>\n' +
                        '        </div>\n').insertAfter(card_content);
                }
            }
        });
        $(this).val("");
        return false;
    }
});

$('body').on('click','.delete-comment', function(){
    var comment_id = $(this).closest('.card-content').data('id');
    var card_content = $(this).closest('.card-content');
    var parent = $(this).closest('.card-content').data('parent');
    var card = $(this).closest('.card');
    if(parent == 1){
        var result = confirm("Delete this comment thread?");
    } else {
        var result = confirm("Delete this comment?");
    }
    if(result){
        $.ajax({
            type: 'POST',
            data: {
                comment_id: comment_id
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/review/delete',
            success: function (response) {
                if(parent == 1){
                    card.remove();
                } else {
                    card_content.remove();
                }
            }
        });
    }
});

$('body').on('click','.resolve-comment', function(){
    var comment_id = $(this).closest('.card-content').data('id');
    var card = $(this).closest('.card');
    $.ajax({
        type: 'POST',
        data: {
            comment_id: comment_id
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/review/resolve',
        success: function (response) {
            card.remove();
        }
    });

});
