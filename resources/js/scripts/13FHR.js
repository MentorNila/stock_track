function expandMenu(){
    $('body').removeClass('menu-collapsed');
    $('body').addClass('menu-expanded');
    $('div.navbar-header').addClass('expanded');
    $('div.navbar-header').addClass('expanded');
    $('div.main-menu-content').css('display','block');
    $('i.toggle-icon').removeClass('bx-circle');
    $('i.toggle-icon').addClass('bx-disc');
}
$('#add-reporting-manager').on('click', function () {
    expandMenu();
    let tableTwoForm = '<form id="table-reporting">\n' +
        '    <label>List of Other Managers Reporting for this Manager:\n' +
        '[If there are no entries in this list, omit this section.]</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" maxlength="10" name="cik-number" type="text" placeholder="Cik"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input type="text" style="color: #000" class="form-control"  maxlength="17"  name="file-number" type="text" placeholder="Form 13F File Number"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="file-name" type="text" placeholder="Name"/>\n' +
        '    </div>\n';

    tableTwoForm += '<button type="button" id="add-reporting-manager-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click', '#add-reporting-manager-row', function (e) {
    let data = [];
    var inputs = $('form#table-reporting').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    generateTableRPRow(data);
});

function generateTableRPRow(data) {

        let Manager = ' ' +
            '<tr class="reported-managers">\n' +
            '<td></td>' +
            '<td class="FormData filing-data" style="display:none"  data-name="cik-number">' + data['cik-number'] + '</td>' +
            '<td></td>' +
            '<td class="FormData filing-data" data-name="file-number">' + data['file-number'] + '</td>' +
            '<td class="FormData  filing-data" data-name="file-name">' + data  ['file-name'] + '</td>' +
            '<td><a style="cursor: pointer;" class="delete-reporting-manager"><i class="bx bx-x" aria-hidden="true"></i></a>\n</td>' +
            '</tr>\n';

        $('.reporting').append(Manager);
        $('.add-table-row-div').html('');

}

$('body').on('click', '.delete-reporting-manager', function () {
    $(this).closest('.reported-managers').remove();
    $(this).closest('#title_label').remove();

        if($("[data-name='file-number']").length ===0){
            $('div #title_label').text("").hide();
            $('.reporting .file-numbers').hide();
            $('.reporting .ciknumber').hide();
            // $(this).parent().parent().parent().remove();

    }
});



$('body').on('click', '#add-reporting-manager-row', function () {

    if($("[data-name='file-number']").length ===1){
        $('div #title_label').text("List of Other Managers Reporting for this Manager:\n" +
            "[If there are no entries in this list, omit this section.]").show();
        $('.reporting .file-numbers').show();
        $('.reporting .ciknumber').hide();
        // $(this).parent().parent().parent().show();
    }
});





$('#add-listed-managers').on('click', function () {
    expandMenu();
    let tableTwoForm = '<form id="table-managers">\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" maxlength="10" name="cik-manager" type="text" placeholder="Cik"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="number" type="text" placeholder="No"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" maxlength="17" name="list-number" type="text" placeholder="Form 13F File Number"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="list-name" type="text" placeholder="Name"/>\n' +
        '    </div>\n';

    tableTwoForm += '<button type="button" id="add-listed-managers-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click', '#add-listed-managers-row', function (e) {
    let data = [];
    var inputs = $('form#table-managers').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    generateTableRow(data);
});

function generateTableRow(data) {

        let List = '' +
            '<tr class="listed-managers">' +
            '<td class="FormData filing-data" style="display:none"  data-name="cik-manager">' + data['cik-manager'] + '</td>' +
            '<td></td>' +
            '<td class="FormData filing-data" data-name="number">' + data['number'] + '</td>' +
            '<td class="FormData filing-data" data-name="list-number">' + data['list-number'] + '</td>' +
            '<td class="FormData  filing-data" data-name="list-name">' + data['list-name'] + '</td>' +
            '<td><a style="cursor: pointer;" class="delete-listed-managers"><i class="bx bx-x" aria-hidden="true"></i></a>\n</td>' +
            '</tr>\n';

    $('.managers').append(List);
    $('.add-table-row-div').html('');

}


$('body').on('click', '.delete-listed-managers', function () {
    $(this).parent().parent().remove();

    if($("[data-name='number']").length ===0){
        $('.managers .names').hide();
        // $(this).parent().parent().parent().remove();

    }
});


$('body').on('click', '#add-listed-managers-row', function () {

    if($("[data-name='list-number']").length ===1){
        $('.managers .names').show();
        // $(this).parent().parent().parent().show();
    }
});

$('#add-table-informations').on('click', function () {
    expandMenu();
    let tableTwoForm = '<form id="table-informations">\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control"  name="name" type="text" placeholder="NAME OF ISSUER"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input type="text" style="color: #000" class="form-control"   name="title" type="text" placeholder="TITLE OF CLASS\t"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="cusip" type="text" placeholder="CUSIP"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control"  name="value" type="text" placeholder="VALUE(x$1000)\t"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input type="text" style="color: #000" class="form-control"   name="shrs" type="text" placeholder="SHRS OR PRN AMT"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input type="text" style="color: #000" class="form-control"   name="sh" type="text" placeholder="SH/ PRN"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="put-call" type="text" placeholder="PUT/CALL"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control"  name="investment" type="text" placeholder="INVESTMENT/DISCRETION"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input type="text" style="color: #000" class="form-control"   name="other" type="text" placeholder="OTHER MANAGER"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="sole" type="text" placeholder="SOLE"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="shared" type="text" placeholder="SHARED"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="none" type="text" placeholder="NONE"/>\n' +
        '    </div>\n ';

    tableTwoForm += '<button type="button" id="add-table-informations-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});


$('body').on('click', '#add-table-informations-row', function (e) {
    let data = [];
    var inputs = $('form#table-informations').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    generateTableRRow(data);
});

function generateTableRRow(data) {


    let TableInfo = ' ' +
        '<tr class="table-info">\n' +
        '<td class="FormData filing-data" style="color:blue;"  data-name="name">' + data['name'] + '</td>' +
        '<td class="FormData filing-data" style="color:blue;"  data-name="title">' + data['title'] + '</td>' +
        '<td class="FormData  filing-data" style="color:blue;"  data-name="cusip">' + data  ['cusip'] + '</td>' +
        '<td class="FormDataR filing-data" style="color:blue;"  data-name="value">' + data['value'] + '</td>' +
        '<td class="FormDataR filing-data" style="color:blue;"   data-name="shrs">' + data['shrs'] + '</td>' +
        '<td class="FormData filing-data"  style="color:blue;"  data-name="sh">' + data['sh'] + '</td>' +
        '<td class="FormData filing-data"  style="color:blue;"  data-name="put-call">' + data['put-call'] + '</td>' +
        '<td class="FormData  filing-data" style="color:blue;"  data-name="investment">' + data  ['investment'] + '</td>' +
        '<td class="FormData filing-data" style="color:blue;"  data-name="other">' + data['other'] + '</td>' +
        '<td class="FormDataR filing-data" style="color:blue;"  data-name="sole">' + data['sole'] + '</td>' +
        '<td class="FormDataR filing-data" style="color:blue;"  data-name="shared">' + data['shared'] + '</td>' +
        '<td class="FormDataR filing-data" style="color:blue;"  data-name="none">' + data  ['none'] + '</td>' +
        '<td><a style="cursor: pointer;" style="color:blue;"  class="delete-table"><i class="bx bx-x" aria-hidden="true"></i></a>\n</td>' +
        '</tr>\n';

    $('.table-informations').append(TableInfo);
    $('.add-table-row-div').html('');

}

$('body').on('click', '.delete-table', function () {
    $(this).closest('.table-info').remove();
});


function generateFormFilings($button) {
    var data = {};

    $('span[data-name="state"]').text($('#state').children('option:selected').val());
    $('span[data-name="stateCountry"]').text($('#stateCountry').children('option:selected').val());


    data['calendar'] = {};
    $('.calendar .filing-data').each(function () {
            data['calendar'][$(this).data('name')] = $(this).text();
    });

    data['hidden_div'] = {};
    $('.hidden_div .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['hidden_div'][$(this).data('parent') === 'undefined']) {
                    data['hidden_div'][$(this).data('parent')] = {};
                }
                data['hidden_div'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['hidden_div'][$(this).data('name')] = '1';
            }

        } else if ($(this).text() === "☐") {

        } else {

        }
    });

    data['table-info'] = {};
    $('.table-info').each(function () {
        let i = Object.keys(data['table-info']).length;
        data['table-info'][i] = {};
        $(this).find('.filing-data').each(function () {
            data['table-info'][i][$(this).data('name')] = $(this).text();
        });
    });

    data['amendment-informations'] = {};
    $('.amendment-informations .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['amendment-informations'][$(this).data('parent') === 'undefined']) {
                    data['amendment-informations'][$(this).data('parent')] = {};
                }
                data['amendment-informations'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['amendment-informations'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['amendment-informations'][$(this).data('name')] = $(this).text();

        }
    });

    data['filing-manager'] = {};
    $('.filing-manager .filing-data').each(function () {
        if ($(this).data('code')) {
            data['filing-manager'][$(this).data('name')] = $(this).data('code-description');
            data['filing-manager'][$(this).data('code')] = $(this).text();
        }
        else {
            data['filing-manager'][$(this).data('name')] = $(this).text();

        }

    });

    data['signature-informations'] = {};
    $('.signature-informations .filing-data').each(function () {
        if ($(this).data('code')) {
            data['signature-informations'][$(this).data('name')] = $(this).data('code-description');
            data['signature-informations'][$(this).data('code')] = $(this).text();
        } else {
            data['signature-informations'][$(this).data('name')] = $(this).text();
        }
    });

    data['report-type-informations'] = {};
    $('.report-type-informations .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['report-type-informations'][$(this).data('parent') === 'undefined']) {
                    data['report-type-informations'][$(this).data('parent')] = {};
                }
                data['report-type-informations'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['report-type-informations'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {

        }
    });

    data['report-summary'] = {};
    $('.report-summary .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['report-summary'][$(this).data('parent') === 'undefined']) {
                    data['report-summary'][$(this).data('parent')] = {};
                }
                data['report-summary'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['report-summary'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['report-summary'][$(this).data('name')] = $(this).text();
        }
    });

    data['reported-managers'] = {};
    $('.reported-managers').each(function () {
        let i = Object.keys(data['reported-managers']).length;
        data['reported-managers'][i] = {};
        $(this).find('.filing-data').each(function () {
            data['reported-managers'][i][$(this).data('name')] = $(this).text();
        });
    });

    data['listed-managers'] = {};
    $('.listed-managers').each(function () {
        let i = Object.keys(data['listed-managers']).length;
        data['listed-managers'][i] = {};
        $(this).find('.filing-data').each(function () {
            data['listed-managers'][i][$(this).data('name')] = $(this).text();
        });
    });

    data['additional-info'] = {};
    $('.additional-info .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['additional-info'][$(this).data('parent') === 'undefined']) {
                    data['additional-info'][$(this).data('parent')] = {};
                }
                data['additional-info'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['additional-info'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['additional-info'][$(this).data('name')] = $(this).text();
        }
    });


    let tableContent = $("#table").html();
    let content = $('#content');
    let htmlContent = content.html();
    let updateContent = removeTable(content);
    $("#content").html(htmlContent);


    function removeTable(content){
        content.find('#table').remove();
        return content.html();
    }

    let stringJson = JSON.stringify(data);
    $.ajax({
        type: 'POST',
        data: {
            formType: formType,
            filingId: filingID,
            data: stringJson,
            htmlContent: updateContent,
            tableContent: tableContent,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/generate-filing/generate-filing',
        success: function (response) {
            var link = document.createElement("a");
            link.download = response.file_name;
            link.href = response.url_to_file;
            link.click();
            $('#generateFiles').html('Generate Files');
            $('#generateFiles').removeAttr("disabled");
        }
    });
}

function yesnoCheck() {
    if (document.getElementById('yes').checked) {
        document.getElementById('text').style.display = 'block';
    }
    else document.getElementById('text').style.display = 'none';

}

function myFunction() {
    var checkBox = document.getElementById("confidential");
    var text = document.getElementById("confidential-text");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
}



