$( document ).ready(function() {
    $.each($('.sections'), function (i) {
        $('#sections').append('<option value="'+ $(this).data('parent') +'">'+ $(this).data('parent') +'</option>');
    });

    $("body").on('click', '.get-selected-tag', function() {
        let input = $(this).siblings("input");
        input.val(selectedNode.text);
    });

    $.each($('.sections'), function (i) {
        $('#sections').append('<option value="'+ $(this).data('parent') +'">'+ $(this).data('parent') +'</option>');
    });


$('body').on('click', '.tag-search', function() {
    let searchArea = $(this).closest('.search-area');
    let tag = $(this).siblings('input').val();
    search(searchArea, tag);
});

//Search with Enter
$("body").on('keypress', '.search-input', function(e) {
    if(e.which == 13) {
        let searchArea = $(this).closest('.search-area');
        let tag = $(this).val();
        search(searchArea, tag)
    }
});

$("body").on('click', '.tag-result', function() {
    let input = $(this).closest('.search-area').find('input')
    input.val($(this).html()).attr('readOnly', true);
    input.addClass('clearable');
    let resultsArea = $(this).closest('.results');
    resultsArea.html('');
    resultsArea.closest('.search-results').hide();
});

    /**
     * Clearable text inputs
     */
    function tog(v){return v?'addClass':'removeClass';}
    $(document).on('input', '.clearable', function(){
        $(this)[tog(this.value)]('x');
    }).on('mousemove', '.x', function( e ){
        $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');
    }).on('touchstart click', '.onX', function( ev ){
        ev.preventDefault();
        $(this).removeClass('x onX').val('').change();
        $(this).attr('readonly', false)
    });

// $('.clearable').trigger("input");
// Uncomment the line above if you pre-fill values from LS or server


//
// $("body").on('click', '.reference-result', function() {
//     $('#taxonomy-reference').val($(this).html());
// });
//
// $("body").on('click', '.table-concept-result', function() {
//     $('#table-concept').val($(this).html());
// });
//
// $("body").on('click', '.axis-result', function() {
//     $(this).parent().prev().find('.axis-value-div').find('.axis-value').val($(this).html());
//     $(this).parent().hide();
// });
//
// $("body").on('click', '.members-result', function() {
//     $(this).parent().prev().find('.member-value-div').find('.member-value').val($(this).html());
//     $(this).parent().hide();
// });

    //Get taxonomy Abstract
    /*$.ajax({
        type: 'GET',
        data: {
            'id': '0',
            'company_id': '0'
        },
        dataType: 'json',
        url: '/taxonomy/get-taxonomy-parents',
        success: function(parents) {
            $.each(parents, function(index, element) {
                $('#taxonomy-reference-data').append('<p class="reference-result" style="cursor:pointer;">'+ element['code'] +'</p>');
            });
        }
    });

    //Table concept data
    let tag = 'Table';
    let type = null;
    let substitutionGroup = 'xbrldt:hypercubeItem';
    $.ajax({
        type: 'GET',
        data: {
            tag: tag,
            type: type,
            substitutionGroup: substitutionGroup
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/data/search',
        success: function (response) {
            $.each(response.results, function( index, value ) {
                $('#table-concept-data').append('<p class="table-concept-result" style="cursor:pointer;">'+ value +'</p>');
            });
        }
    });*/





//
// $( "#add-tag" ).click(function() {
//     $('input#tag').val(selectedNode.code);
// });
//
// $("body").on('click', '.add-axis-tag', function() {
//     var id = $(this).data('id');
//     $('input#axis-' + id).val(selectedNode.code);
// });
//
// $("body").on('click', '.add-member-tag', function() {
//     var id = $(this).data('id');
//     $('input#member-' + id).val(selectedNode.code);
// });
//
// $( "#add-table-concept-tag" ).click(function() {
//     $('input#table-concept').val(selectedNode.code);
// });

});
function search(searchArea, tag= null, type=null, substitutionGroup = null){
    searchArea.find('.results').html('');
    $.ajax({
        type: 'GET',
        data: {
            tag: tag,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/data/search',
        success: function (response) {
            if(response.results != null){
                searchArea.find('.search-results').show();
                $.each(response.results, function( index, value ) {
                    searchArea.find('.results').append('<p class="tag-result" style="cursor:pointer;padding-top: 10px">'+ value['label'] +'</p>');
                });
            }
        }
    });
}
