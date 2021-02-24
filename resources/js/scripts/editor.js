var editMode = 0;
var otherMode = 0;
var selectedNode = '';

$( document ).ready(function() {

    $('#saveDraft').on('click', function () {
        if (otherMode === 0) {
            var content = $('#content').html();
            if (!['Form3','Form4','Form5','FormD','13FHR'].includes(formType)) {
                var content = CKEDITOR.instances['document-ckeditor'].getData();
            }
            $.ajax({
                type: 'POST',
                data: {
                    filingId: filingID,
                    htmlContent: content,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/editor/save-as-draft',
                success: function (response) {
                    window.location = '/filing-datas'
                }
            });
        }
    });

    $('#generateFiles').on('click', function () {
        $(this).html('<i class="fa fa-spinner fa-spin"></i> Generating');
        $(this).attr("disabled", 'disabled');
        generateFormFilings($(this));
    });

    $('#create-tag').on('click', function () {
        event.preventDefault();
        if(!$('input[name="label"]').val()){
            alert("Label field is required");
        } else if(!$('input[name="name"]').val()){
            alert("Name field is required");
        } else if($('select[name="type"]').val() == null) {
            alert("Type field is required");
        } else if($('select[name="periodType"]').val() == null) {
            alert("Period field is required");
        } else if($('select[name="balance"]').val() == null) {
            alert("Balance field is required");
        } else if($('select[name="substitutionGroup"]').val() == null) {
            alert("Substitution Group field is required");
        } else if($('select[name="nillable"]').val() == null) {
            alert("Nillable field is required");
        } else if($('select[name="abstract"]').val() == null) {
            alert("Abstract field is required");
        } else if(!$('textarea[name="documentation"]').val()){
            alert("Documentation/Definition field is required");
        } else {
            var tag = {};
            var inputs = $('form#tagForm').serializeArray();

            $.each(inputs, function (i, field) {
                tag[field.name] = field.value;
            });

            tag['parent_id'] = lastNode.node_id;
            tag['company_id'] = $('#company_id').val();

            $.ajax({
                type: 'POST',
                data: {
                    tag: tag,
                    filingId: filingID,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/taxonomy/add-new-tag',
                success: function (response) {
                    $('form#tagForm').trigger('reset');

                    lastNode.createChildNode(tag['label'], false, '/images/monitor.png', null, 'context2', response.id, false, tag['name']);
                    // lastNode.expandNode();

                }
            });
            $('form#tagForm').trigger('reset');
            $('#extensionTagModal').modal('toggle', $(this));
        }
    });

    $('#assignUsers').click(function (e) {
        e.preventDefault();
        var users = $('form#assignUsersForm').serializeJSON({skipFalsyValuesForTypes: ["string"]});
        $.ajax({
            type: 'POST',
            data: {
                filingId: filingID,
                users: users,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/editor/data/assign-users',
            success: function (response) {
                if (response.success === true){

                }
            }
        });
    })
})
/*
 * When clicking on Edit Mode we should initiate the editing mode and turn
 * every field into an editable field.
 */
$('#edit-content').click(function() {
    initiateEditContentMode();
});

/*
 * When clicking on Tag Mode we should initiate the tagging mode and turn
 * the whole text into a selectable text with the ability to tag every part of HTML.
 */

function initiateEditContentMode(){
    if(otherMode === 0 || editMode === 1) {
        if (editMode === 1) {
            hideEditable();

            otherMode = 0;
            editMode = 0;
        } else {
            makeEditable();

            otherMode = 1;
            editMode = 1;
        }
    }
}

/*
 * This function makes every field in the document editable.
 * It finds all the elements with a class .editable and .editableOnly
 * and turns them into input or radiobutons depending on the
 * type of the element
 */
function makeEditable() {
    $("#saveDraft").attr("disabled", true);
    $("#saveExhibitDraft").attr("disabled", true);
    $("#edit-tags").attr("disabled", true);
    $("#generateFiles").attr("disabled", true);
    $('#edit-content').removeClass('btn-secondary');
    $('#edit-content').addClass('btn-success');
    $('.editable .text').hide();
    $('.editable .input').show();
    $('.editableOnly .text').hide();
    $('.editableOnly .input').show();
    $('.addNote').show();
    $('.add-signature1').show();
    $('.delete-signature').show();
    $('.addMainTableRows').show();
    $('.add-signature').show();
    $('.addSignature').show();
    $('.addMainTableRows10D').show();
    $('.addMainTableRowsS3').show();
    $('#add-table-one-item').show();
    $('#add-table-two-item').show();
    $('.deleteMainTableRow').show();
    $('.deleteSignatureRow').show();
    $('.deleteSignature').show();
    $('.deleteSignatureTd').show();
    $('#add-exp-rsp').show();
    $('#add-remark-field').show();
    $('#add-remark').show();
    $('#add-signature').show();
    $('#add-reporting-person').show();
    $('#add-related-person').show();
    $('#add-recipient').show();
    $('#add-issuer').show();
    $('.sales-compensation-table').show();
    $('#fill-reporting-person').show();
    $('td > .delete-row').parent().show();
    $('.delete-related-person').show();
    $('.delete-recipient').show();
    $('.select').show();
    $('#add-reported-person').show();
    $('.delete-reported-person').show();
    $('.link').hide();
    $('.delete-reporting-manager').show();
    $('.delete-cursor').show();
    $('#add-reporting-manager').show();
    $('#add-listed-managers').show();
    $('.delete-listed-managers').show();
    $('.hidden_div').show();
    $('.list-of-states').hide();
    $('.tekst').show();
    $('.delete-issuer-person').show();
    $('#add-table-informations').show();
    $('.confidential').show();
    $('.delete-table').show();
}
/*
 * This function makes every editable field in the document hide.
 * It loops through all the elements with a class .editable and .editableOnly
 * and turns them into text
 */
function hideEditable(){
    $('.list-of-states').show();
    $('.sales-compensation-table').hide();
    $('#saveDraft').removeAttr("disabled");
    $('#saveExhibitDraft').removeAttr("disabled");
    $('#edit-tags').removeAttr("disabled");
    $('#generateFiles').removeAttr("disabled");
    $('#edit-content').removeClass('btn-success');
    $('#edit-content').addClass('btn-secondary');
    $('.addNote').hide();
    $('.addMainTableRows').hide();
    $('.add-signature').hide();
    $('.addSignature').hide();
    $('#add-table-one-item').hide();
    $('#add-table-two-item').hide();
    $('.addMainTableRows10D').hide();
    $('.addMainTableRowsS3').hide();
    $('.deleteMainTableRow').hide();
    $('.deleteSignatureRow').hide();
    $('.deleteSignature').hide();
    $('.deleteSignatureTd').hide();
    $('#add-reporting-person').hide();
    $('#add-related-person').hide();
    $('#add-recipient').hide();
    $('#add-issuer').hide();
    $('#add-remark-field').hide();
    $('.add-signature1').hide();
    $('#add-reported-person').hide();
    $('.delete-signature').hide();
    $('#fill-reporting-person').hide();
    $('#add-signature').hide();
    $('#add-exp-rsp').hide();
    $('#add-remark').hide();
    $('.delete-related-person').hide();
    $('.delete-recipient').hide();
    $('.delete-reported-person').hide();
    $('.select').hide();
    $('#add-reporting-manager').hide();
    $('.link').show();
    $('.delete-reporting-manager').hide();
    $('#add-listed-managers').hide();
    $('.delete-listed-managers').hide();
    $('td > .delete-row').parent().hide();
    $('.hidden_div').hide();
    $('.tekst').hide();
    $('.confidential').hide();
    $('.delete-table').hide();
    $('.delete-cursor').hide();
    $('.delete-issuer-person').hide();
    $('#add-table-informations').hide();
    $('.editable').each(function () {
        $(this).children('.text').show();

        if (['radio', 'checkbox'].includes($(this).find(':input').attr('type'))) {
            if ($(this).find(':input').is(':checked')) {
                $(this).children('.text').text('☒');
                $(this).children('.input').find(':input').attr('checked','checked');
            } else {
                $(this).children('.text').text('☐');
                $(this).children('.input').find(':input').removeAttr('checked');
            }
        } else if (undefined !== $(this).find(':input').val() && $(this).find(':input').val().length !== 0) {
            if (undefined !== $(this).find('select').val()){
                $(this).children('.text').text($(this).find('select').children('option:selected').text());
                $(this).children('.text').attr('data-code-description', $(this).find('select').children('option:selected').val());
                $(this).find('select option[value='+$(this).find('select').children('option:selected').val()+']').attr('selected','selected');
            } else {
                $(this).children('.text').text($(this).find(':input').val());
                $(this).children('.input').find(':input').attr('value', $(this).find(':input').val());
            }
        }
        $(this).children('.input').hide();

    });

    $('.editableOnly').each(function () {
        $(this).children('.text').show();

        if (undefined !== $(this).find(':input').val() && $(this).find(':input').val().length !== 0) {
            $(this).children('.text').text($(this).find('textarea').val());
            $(this).children('.input').find('textarea').text($(this).find('textarea').val());
        }
        $(this).children('.input').hide();
    });

    if($('#quarterly_report').is(':checked')){
        $('.transition_report .text').html('              ');
    }
    if($('#transition_report').is(':checked')){
        $('.quarterly_report .text').html('              ');
    }
}

// $('.datepicker').datepicker();
$('.datepicker').pickadate();

$('.addSignature').on('click', function(){
    var date = $(this).data('date');
    $('.signaturesTable').append(`<TR STYLE="vertical-align: top">
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD></TR>
  <TR STYLE="vertical-align: top">
      <TD STYLE="border-bottom: black 1.5pt solid; font-weight: bold"><FONT STYLE="font-size: 10pt; font-weight: normal">/s/ <span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display:none;">...</span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></FONT></TD>
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center"><FONT STYLE="font-size: 10pt; font-weight: normal"><span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display:none;">...</span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></FONT></TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center"><FONT STYLE="font-size: 10pt; font-weight: normal">`+ date +`</FONT></TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center"><a style="cursor: pointer" class="deleteSignature"><i class="fa fa-times" aria-hidden="true"></i></a></TD></TR>
  <TR STYLE="vertical-align: top">
      <TD STYLE="font-weight: bold"><FONT STYLE="font-size: 10pt; font-weight: normal"><span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display:none;">...</span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></FONT></TD>
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD>
      <TD STYLE="font-weight: bold; text-align: center">&nbsp;</TD></TR>`)
});

$('.add-signature').on('click', function(){
    var date = $(this).data('date');
    $('.mainSignatureTable').append(`<tr height="15">
      <td valign="top">
          <p style="MARGIN: 0px">Dated: <b><span class="editable"><span class="attributes"></span><span class="text"style="font-weight: bold; text-decoration: underline; white-space: pre; display:none;" >`+ date +`</span><span class="input"><input class="datepicker" value="`+ date +`" data-date-format="MM dd, yyyy"></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></b></p>
      </td>
      <td valign="top">
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
      <td style="BORDER-BOTTOM: 1px solid" valign="bottom">
          <p style="MARGIN: 0px">/s/<i> <span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></i></p>
      </td>
      <td>
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
  </tr>
  <tr height="15">
      <td valign="top"></td>
      <td valign="top">
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
      <td valign="top">
          <p style="MARGIN: 0px"><b><span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></b></p>
      </td>
      <td>
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
      <td><a style="cursor: pointer;" class="deleteSignatureRow"><i class="fa fa-times" aria-hidden="true"></i></a></td>
  </tr>
  <tr height="15">
      <td valign="top"></td>
      <td valign="top">
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
      <td valign="top">
          <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="font-weight: bold; display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i></span></p>
      </td>
  </tr>
  <tr height="15">
      <td valign="top"></td>
      <td valign="top">
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
      <td valign="top"> </td>
      <td>
          <p style="MARGIN: 0px">&nbsp;</p>
      </td>
  </tr>`);
    $('.datepicker').pickadate();
    // $('.datepicker').datepicker();
});

$('body').on('click','.deleteSignatureRow', function(){
    $(this).closest('tr').prev('tr').remove();
    $(this).closest('tr').next('tr').next('tr').remove();
    $(this).closest('tr').next('tr').remove();
    $(this).parents("tr").remove();
});

$('body').on('click','.deleteSignature', function(){
    $(this).closest('tr').prev('tr').remove();
    $(this).closest('tr').next('tr').remove();
    $(this).parents("tr").remove();
});

$('body').on('click', '#discard-row', function () {
    $('.add-table-row-div').html('');
});

$('body').on('click', '.delete-row', function () {
    $(this).closest('tr').remove();
});

function updateFilingContent(content){
    $.ajax({
        type: 'POST',
        data: {
            filingId: filingID,
            htmlContent: content,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/editor/save-as-draft',
        success: function (response) {
            console.log('filing has been updated');
        }
    });
}

$('#addExhibitLink').on('click', function () {
    let exhibitName = $('#exhibit').val();
    editorInstance.insertHtml('<a style="text-decoration: none;" href="' + exhibitName + '.html">'+ exhibitName + '</a>');
    $('#exhibitLinkModal').modal('toggle');
});

$(document).on('hidden.bs.modal', '#exhibitLinkModal',function () {
    $(this).find('form').trigger('reset');
});

$('#assignUsers').on('click', function () {
    $('#usersModal').modal('toggle');
});

$(document).on('hidden.bs.modal', '#usersModal',function () {
    $(this).find('form').trigger('reset');
});
