let element = '';
let selection = '';
let activeSectionId = null;
let windowSelection = '';
let taglevels = false;
let tagType = '';
let tagId = '';
let levelOfTag = null;
let updateFiling = false;
var editorInstance = CKEDITOR.instances['document-ckeditor'];

$(document).ready(function () {

    $(document).on('shown.bs.modal', '#attributesModal', function (event) {
        windowSelection = window.getSelection && window.getSelection();
        if (windowSelection && windowSelection.rangeCount > 0) {
            selection = windowSelection.getRangeAt(0);
        }
        element = $(event.relatedTarget).parents().first();

        // $('.datepicker').datepicker();
        $('.datepicker').pickadate();
    });

    $(document).on('hidden.bs.modal', '#attributesModal',function () {
        $('body #attributesModal').html('');
        activeSectionId = null;
        tagId = '';
        if (updateFiling){
            let content = editorInstance.getData();
            updateFilingContent(content);
            updateFiling = false;
        }
    });

    $('body').on('click', '#discardTag', function () {
        $('#attributesModal').modal('toggle');
    });

    $('body').on('click', '#saveTags', function () {
        let attributes = $('form#attributesForm').serializeJSON({skipFalsyValuesForTypes: ["string"]});
        let level = null;
        if (taglevels === true){
            level = levelOfTag;
        }

        if (tagId === ''){
            updateFiling = true;
        }

        if (activeSectionId !== null){
            $.ajax({
                type: 'POST',
                data: {
                    filingId: filingID,
                    tagId: tagId,
                    attributes: attributes,
                    level: level,
                    sectionId: activeSectionId
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/editor/tag/store-tag',
                success: function (response) {
                    if (response.success === true){
                        if (taglevels === true) {
                            taglevels = false;
                            wrapSelectedText(tagType, response.tag_id);
                        }
                    }

                }
            });
        }
        $('#attributesModal').modal('toggle');

    });

    $('body').on('keyup', '#tag', function(){
        $('.attributes-content').html('');
        $('#show-attributes').show();
        $('#hide-attributes').hide();
        $('.periods-content').html('');
    });

    $('body').on('click', '#suggest-dates', function (e) {
        e.preventDefault();
        let tagName = $('input#tag').val();

        $.ajax({
            type: 'GET',
            data: {
                filingId: filingID,
                tagName: tagName
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/editor/data/get-tag-period',
            success: function (response) {
                if(response.success == true){
                    $('.periods-content').html(response.periods);
                    // $('.datepicker').datepicker();
                    $('.datepicker').pickadate();
                }
            }
        });
    });

    $('body').on('click', '#show-attributes', function (e) {
        e.preventDefault();
        let tagName = $('input#tag').val();
        getTagAttributes(tagName);

    });

    $('body').on('click', '#hide-attributes', function (e) {
        e.preventDefault();
        $('.attributes-content').html('');
        $(this).hide();
        $('#show-attributes').show();
    });

    $('body').on('click', '#deleteTag', function () {
        deleteTag();
        $('#attributesModal').modal('toggle');
    });

    $('body').on('click', '#add-label',function () {
        showLabelContent();
    });

    $('body').on('click', '#add-axis', function () {
        showAxisContent();
    });

    $('body').on('click','.delete-axis', function(e){
        e.preventDefault();
        $(this).closest('.axis').remove();
    });

    $('body').on('click', '.delete-label', function(e){
        e.preventDefault();
        $(this).closest('.label').remove();
    });

    $('body').on('click', '#add-sum', function () {
        var tagName = $('input#tag').val();
        $.ajax({
            type: 'GET',
            data: {
                tagName: tagName
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/editor/data/check-tag-type',
            success: function (response) {
                if(response.success == true){
                    if (response.monetary === true){
                        showSum();
                    }
                }
            }
        });
    });

    $('body').on('click', '#remove-sum', function () {
        hideSum();
    });

    if (!['Form3','Form4','Form5','FormD','13FHR'].includes(formType)) {
        editorInstance.on('contentDom', function() {
            editorInstance.editable().attachListener(
                this.document,
                'click',
                function( event ) {
                    if(event.data.getTarget().$.className == 'tagableOnly tagable sections' || event.data.getTarget().$.className == 'tagableOnly tagable'){
                        tagId = event.data.getTarget().getAttribute('tag-id');
                        activeSectionId = event.data.getTarget().$.closest('.sections').getAttribute('tag-id');
                        loadModal();
                    }
                }
            );
        });
    }

    editorInstance.on('contentDom', function() {
        editorInstance.editable().attachListener(
            this.document,
            'click',
            function( event ) {
                let el = event.data.getTarget();
                if (el.hasClass("comment")) {
                    loadCommentsModal(el.getAttribute('data-comment'))
                }
                /* event is an object containing a property data
                of type CKEDITOR.dom.event, this object has a
                method to receive the DOM target, which finally has
                a data method like the jQuery data method */
                // event.data.getTarget().data('class');
            }
        );
    });
});

function wrapSelectedText(tagType, tagID) {
    let mainDiv = '';
    let newElement;
    if (tagType === 'text-block') {
        mainDiv = generateTextBlockTagElement(tagID);
        newElement = null;

    } else {
        mainDiv = generateTagElement(tagID);
        newElement = null;
    }

    if (newElement !== null){
        mainDiv.append(newElement);
    }

    editorInstance.insertElement(mainDiv);
}

function generateTagElement(tagID){
    let mainDiv = new CKEDITOR.dom.element("span");
    mainDiv.setAttributes({id: tagID, class: 'tagableOnly tagable', style: 'border-top: 2px solid #FF6600!important;border-bottom: 2px solid #FF6600!important;', 'tag-id': tagID});
    return getSelectionHtml(mainDiv);
}

function generateTextBlockTagElement(tagID){
    let mainDiv = new CKEDITOR.dom.element("div");
    mainDiv.setAttributes({id: tagID, class: 'tagableOnly tagable sections',style: 'border-top: 2px solid #FF6600!important;border-bottom: 2px solid #FF6600!important;', 'tag-id': tagID});
    return getSelectionHtml(mainDiv);
}

function getSelectionHtml(mainDiv) {
    var sel = editorInstance.getSelection();
    var ranges = sel.getRanges();
    for (var i = 0, len = ranges.length; i < len; ++i) {
        mainDiv.append(ranges[i].cloneContents());
    }
    return mainDiv;
}

function loadModal(level, content = null){
    $.ajax({
        type: 'GET',
        data: {
            filingId: filingID,
            tagId: tagId,
            level: level,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/tag/get-tag-data',
        success: function (response) {
            if (response.success == true){
                $('#attributesModal').html(response.content).modal('toggle');
                if (content !== null){
                    $('input#fact').val(content);
                }
            }
        }
    });
}

function loadCommentsModal(commentID){
    $.ajax({
        type: 'GET',
        data: {
            commentId: commentID,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/review/get-comments',
        success: function (response) {
            if (response.success === true){
                $('#commentsModal').html(response.content).modal('toggle');
            }
        }
    });
}

function showAxisContent(){
    let id = $('.axis-content > .axis').last().data('id');
    if (typeof id !== 'undefined'){
        ++id;
    } else {
        id = 1;
    }
    addAxisGroup(id);
}

function addAxisGroup(id){
    let axisContent = '<div class="axis" style="padding: 10px; margin-bottom: 10px;border: 1px solid #0574f0!important;" data-id="' + id + '" >\n' +
        '        <div class="search-area">\n' +
        '            <label for="dimensions[' + id + '][axis]">Axis</label>\n' +
        '            <div class="form-group">\n' +
        '                 <input name="dimensions[' + id + '][axis]" id="dimensions[' + id + '][axis]" class="form-control search-input clearable" value="" style="display: inline; width: 90%">\n' +
        '                 <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>' +
        '                 <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>'+
        '            </div>\n' +
        '            <div class="search-results" style="display: none;">\n' +
        '                <label>Results</label>\n' +
        '                <div class="form-group results" style="height: 200px;overflow-y: scroll;"></div>\n' +
        '            </div>'+
        '        </div>\n' +
        '        <div class="search-area">\n' +
        '            <label for="dimensions[' + id + '][domain]">Domain</label>\n' +
        '            <div class="form-group">\n' +
        '                <input name="dimensions[' + id + '][domain]" id="dimensions[' + id + '][domain]" class="form-control search-input clearable" value="" style="display: inline; width: 90%">\n' +
        '                <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>' +
        '                <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>'+
        '            </div>\n' +
        '            <div class="search-results" style="display: none;">\n' +
        '               <label>Results</label>\n' +
        '               <div class="form-group results" style="height: 200px;overflow-y: scroll;"></div>\n' +
        '            </div>'+
        '        </div>\n' +
        '        <div class="search-area">\n' +
        '            <label for="dimensions[' + id + '][member]">Member</label>\n' +
        '            <div class="form-group member-value-div">\n' +
        '                <input name="dimensions[' + id + '][member]" id="dimensions[' + id + '][member]" class="form-control search-input clearable" value="" style="display: inline; width: 90%">\n' +
        '                <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>' +
        '                <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>'+
        '            </div>\n' +
        '            <div class="search-results" style="display: none;">\n' +
        '                <label>Results</label>\n' +
        '                <div class="form-group results" style="height: 200px;overflow-y: scroll;"></div>\n' +
        '            </div>'+
        '        </div>\n' +
        '        <button class="btn btn-danger delete-axis" style="display: block; margin-top: 20px;">Delete</button>\n' +
        '    </div>';

    $('.axis-content').append(axisContent);
}

function showLabelContent(){
    let id = $('.label-content > .label').last().data('id');
    if (typeof id !== 'undefined'){
        ++id;
    } else {
        id = 1;
    }
    addLabelGroup(id);
}

function addLabelGroup(id){
    let labelContent = '<div class="label" style="padding: 10px; margin-bottom: 10px; border: 1px solid #0574f0!important;" data-id="' + id + '" >\n' +
        '                                <label for="labels[' + id + '][name]">Label</label>\n' +
        '                                <div class="form-group">\n' +
        '                                    <input type="text" name="labels[' + id + '][name]" id="labels[' + id + '][name]" class="form-control label-value">\n' +
        '                                </div>\n' +
        '                                <label for="labels[' + id + '][type]">Label Type</label>\n' +
        '                                <div class="form-group">\n' +
        '                                    <select name="labels[' + id + '][type]" id="labels[' + id + '][type]" class="form-control type-value">\n' +
        '                                        <option value="terseLabel">terseLabel</option>\n' +
        '                                        <option value="verboseLabel">verboseLabel</option>\n' +
        '                                        <option value="negatedLabel">negatedLabel</option>\n' +
        '                                        <option value="positiveLabel">positiveLabel</option>\n' +
        '                                        <option value="positiveTerseLabel">positiveTerseLabel</option>\n' +
        '                                        <option value="positiveVerboseLabel">positiveVerboseLabel</option>\n' +
        '                                        <option value="negativeLabel">negativeLabel</option>\n' +
        '                                        <option value="negativeTerseLabel">negativeTerseLabel</option>\n' +
        '                                        <option value="negativeVerboseLabel">negativeVerboseLabel</option>\n' +
        '                                        <option value="zeroLabel">zeroLabel</option>\n' +
        '                                        <option value="zeroTerseLabel">zeroTerseLabel</option>\n' +
        '                                        <option value="zeroVerboseLabel">zeroVerboseLabel</option>\n' +
        '                                        <option value="totalLabel">totalLabel</option>\n' +
        '                                        <option value="negatedTotalLabel">negatedTotalLabel</option>\n' +
        '                                        <option value="periodStartLabel">periodStartLabel</option>\n' +
        '                                        <option value="negatedPeriodStartLabel">negatedPeriodStartLabel</option>\n' +
        '                                        <option value="periodEndLabel">periodEndLabel</option>\n' +
        '                                        <option value="negatedPeriodEndLabel">negatedPeriodEndLabel</option>\n' +
        '                                    </select>\n' +
        '                                </div>\n' +
        '                                <div class="checkbox" >\n' +
        '                                    <input type="checkbox" name="labels[' + id + '][preferred]" id="labels[' + id + '][preferred]" class="preferred-value">\n' +
        '                                    <label for="labels[' + id + '][preferred]">Preferred Label</label>\n' +
        '                                </div>\n' +
        '                               <button style="display: block; margin-top: 20px;" class="btn btn-danger delete-label">Delete</button>\n' +
        '                        </div>';

    $('.label-content').append(labelContent);
}

function getTagAttributes(tagName){
    $.ajax({
        type: 'GET',
        data: {
            tagName: tagName,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/data/get-tag-attributes',
        success: function (response) {
            if (response.success == true){
                $('.attributes-content').html(response.attributes);
                $('#show-attributes').hide();
                $('#hide-attributes').show();
            }
        }
    });
}

function deleteTag() {
    $.ajax({
        type: 'GET',
        data: {
            tagId: tagId
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/tag/delete-tag',
        success: function (response) {
            if (response.success === true) {
                var span = new CKEDITOR.dom.element('span');
                span.appendHtml(editorInstance.document.getById(tagId).$.innerHTML);
                span.insertBefore(editorInstance.document.getById(tagId))
                editorInstance.document.getById(tagId).remove();
                updateFiling = true;
            }
        }
    });
}

function showSum(){
    addSumInput();
    $('#remove-sum').show();
    $('#add-sum').hide();
    addSignValue();
}

function hideSum(){
    $('#remove-sum').hide();
    $('#add-sum').show();
    $('#sum-input').html('');
    $('#value-sign').html('');
}


function addSumInput() {
    $('#sum-input').html(
        '<label for="sums">Sum to</label>\n' +
        '<div class="form-group">\n' +
        '   <input id="sums" name="sum" style="width: 65%; display: inline"  class="form-control" value="">\n' +
        '   <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>\n' +
        '   <button type="button" style="margin-left: 30px;" class="btn btn-danger" id="remove-sum">Delete</button>\n' +
        '</div>'
    );
}

function addSignValue(){
    $('#value-sign').html(
        '<label for="fact" style="display: block;">Value sign</label>\n' +
        '<div class="custom-control custom-radio" style="display: inline;">\n' +
        '   <input type="radio" class="custom-control-input" id="positive" name="signvalue" value="positive" checked><label class="custom-control-label" for="positive">Positive</label>\n' +
        '</div>\n' +
        '<div class="custom-control custom-radio" style="display: inline;">\n' +
        '   <input type="radio" class="custom-control-input" id="negative" name="signvalue" value="negative"><label class="custom-control-label" for="negative">Negative</label>\n' +
        '</div>'
    );
}

function cleanTagable(content) {
    $('#update-content').html(CKEDITOR.instances['document-ckeditor'].getData());
    let htmlContent = $('#update-content');
    htmlContent.find('.tagable').each(function() {
        $(this).removeAttr('class');
        $(this).removeAttr('id');
        $(this).removeAttr('style');
        $(this).removeAttr('tag-id');
    });
    return htmlContent.html();
}
