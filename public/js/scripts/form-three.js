function expandMenu(){
    $('body').removeClass('menu-collapsed');
    $('body').addClass('menu-expanded');
    $('div.navbar-header').addClass('expanded');
    $('div.navbar-header').addClass('expanded');
    $('div.main-menu-content').css('display','block');
    $('i.toggle-icon').removeClass('bx-circle');
    $('i.toggle-icon').addClass('bx-disc');
}

function select(name){
    var i = 1;
    var opt = '';
    opt += '<option value="" selected>Select a Footnote</option>';
    $('.responseInput').each(function () {
        if($(this).val() != ''){
            opt += '<option value="'+ i +'">Footnote '+i+'</option>';
            i++;
        }
    });
    var sel = '<select class="form-control" name="'+ name +'" id="ownership-footnotes">';
    sel += opt;
    sel += '</select>';
    return sel;
}
$('#add-table-one-item').on('click', function () {
    expandMenu();
    let tableOneForm ='<form id="table-one">\n' +
        '    <label>Table I - Non-Derivative Securities Beneficially Owned</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="title" type="text" placeholder="1. Title of Security (Instr. 4)">\n' +
        '        </br>'+ select('title-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <textarea style="color: #000" class="form-control" name="amount" type="text" placeholder="2. Amount of Securities Beneficially Owned (Instr. 4)"></textarea>\n' +
        '        </br>'+ select('amount-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <textarea style="color: #000" class="form-control" name="ownership" type="text" placeholder="3. Ownership Form: Direct (D) or Indirect (I) (Instr. 5)"></textarea>\n' +
        '        </br>'+ select('ownership-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <textarea style="color: #000" name="nature" class="form-control" rows="3" placeholder="4. Nature of Indirect Beneficial Ownership (Instr. 5)"></textarea>\n' +
        '        </br>'+ select('nature-num') +'\n' +
        '    </div>\n' +
        '    <button type="button" id="add-table-one-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n' +
        '    <button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableOneForm);
});

$('body').on('click','#add-table-one-row', function (e) {
    var inputs = $('form#table-one').serializeArray();
    let data = prepareData(inputs);
    generateTableOneRow(data);
});

function generateTableOneRow(data) {
    if(data['title-num'] == undefined){
        data['title-num'] = '';
    }
    if(data['amount-num'] == undefined){
        data['amount-num'] = '';
    }
    if(data['ownership-num'] == undefined){
        data['ownership-num'] = '';
    }
    if(data['nature-num'] == undefined){
        data['nature-num'] = '';
    }
    let row = '<tr class="non-derivative">\n' +
        '        <td align="left"><span class="FormData filing-data" data-name="title">' + data['title'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="title-num">' + data['title-num'] + '</sup></span></td>\n' +
        '        <td align="center"><span class="FormData filing-data" data-name="amount">' + data['amount'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="amount-num">' + data['amount-num'] + '</sup></span></td>\n' +
        '        <td align="center">\n' +
        '            <span class="FormData filing-data" data-name="ownership">' + data['ownership'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="ownership-num">' + data['ownership-num'] + '</sup></span>\n' +
        '        </td>\n' +
        '        <td align="left"><span class="FormData filing-data" data-name="nature">' + data['nature'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="nature-num">' + data['nature-num'] + '</sup></span></td>\n' +
        '        <td><a style="cursor: pointer" class="delete-row"><i class="bx bx-x" aria-hidden="true"></i></a></td>\n' +
        '    </tr>';
    $('#tableOne > tbody').append(row);
    $('.add-table-row-div').html('');
}

$('#add-table-two-item').on('click', function () {
    expandMenu();
    let tableTwoForm ='<form id="table-two">\n' +
        '    <label>Table II - Derivative Securities Beneficially Owned</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="security-title" type="text" placeholder="1. Title of Derivative Security (Instr. 4)">\n' +
        '        </br>'+ select('security-title-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control datepicker" name="date-exercisable" value="" data-date-format="mm/dd/yyyy" placeholder="Date Exercisable">\n' +
        '        </br>'+ select('date-exercisable-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control datepicker" name="date-expiration" value="" data-date-format="mm/dd/yyyy" placeholder="Expiration Date"/>\n' +
        '        </br>'+ select('date-expiration-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="title" type="text" placeholder="3. Title"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="amount" type="text" placeholder="3. Amount or Number of Shares"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" name="conversion" class="form-control" rows="3" placeholder="4. Conversion or Exercise Price of Derivative Security"/>\n' +
        '        </br>'+ select('conversion-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" name="ownership" class="form-control" rows="3" placeholder="5. Ownership Form: Direct (D) or Indirect (I) (Instr. 5)"/>\n' +
        '        </br>'+ select('ownership-num') +'\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" name="nature" class="form-control" rows="3" placeholder="6. Nature of Indirect Beneficial Ownership (Instr. 5)"/>\n' +
        '        </br>'+ select('nature-num') +'\n'+
        '    </div>\n' +
        '    <button type="button" id="add-table-two-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n' +
        '    <button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
    $('.datepicker').pickadate();

});

$('body').on('click','#add-table-two-row', function (e) {
    var inputs = $('form#table-two').serializeArray();
    let data = prepareData(inputs);
    generateTableTwoRow(data);
});

function prepareData(inputs){
    let data = [];
    $.each(inputs, function (i, field) {
        if (field.name.indexOf("-num") >= 0){
            if (typeof field.value === 'undefined' || field.value === ''){
                data[field.name] = '';
            } else {
                data[field.name] = '(' + field.value + ')';
            }
        } else {
            data[field.name] = field.value;
        }
    });
    return data;
}

function generateTableTwoRow(data) {
    if(data['date-exercisable-num'] == undefined){
        data['date-exercisable-num'] = '';
    }
    if(data['date-expiration-num'] == undefined){
        data['date-expiration-num'] = '';
    }
    if(data['conversion-num'] == undefined){
        data['conversion-num'] = '';
    }
    if(data['ownership-num'] == undefined){
        data['ownership-num'] = '';
    }
    if(data['nature-num'] == undefined){
        data['nature-num'] = '';
    }
    let row = '<tr class="derivative">\n' +
        '        <td align="left"><span class="FormData filing-data" data-name="security-title">' + data['security-title'] + '</span></td>\n' +
        '        <td align="center">\n' +
        '<span class="SmallFormData">\n' +
        '\n' +
        '            </span><span class="FormData filing-data" data-name="date-exercisable">' + data['date-exercisable'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="date-exercisable-num">' + data['date-exercisable-num'] + '</sup></span>\n' +
        '        </td>\n' +
        '        <td align="center">\n' +
        '<span class="SmallFormData">\n' +
        '\n' +
        '            </span><span class="FormData filing-data" data-name="date-expiration">' + data['date-expiration'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="date-expiration-num">' + data['date-expiration-num'] + '</sup></span>\n' +
        '        </td>\n' +
        '        <td align="center"><span class="FormData filing-data" data-name="title">' + data['title'] + '</span></td>\n' +
        '        <td align="center"><span class="FormData filing-data" data-name="amount">' + data['amount'] + '</span></td>\n' +
        '        <td align="center"><span class="FormData filing-data" data-name="conversion">' + data['conversion'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="conversion-num">' + data['conversion-num'] + '</sup></span></td>\n' +
        '        <td align="center">\n' +
        '            <span class="FormData filing-data" data-name="ownership">' + data['ownership'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="ownership-num">' + data['ownership-num'] + '</sup></span>\n' +
        '        </td>\n' +
        '        <td align="left"><span class="FormDatafiling-data filing-data" data-name="nature">' + data['nature'] + '</span><span class="FootnoteData"><sup class="filing-data" data-name="nature-num">' + data['nature-num'] + '</sup></span></td>\n' +
        '        <td><a style="cursor: pointer" class="delete-row"><i class="bx bx-x" aria-hidden="true"></i></a></td>\n' +
        '    </tr>';

    $('#tableTwo > tbody').append(row);
    $('.add-table-row-div').html('');
}

$('#add-reporting-person, #fill-reporting-person').on('click', function () {
    expandMenu();
    let tableTwoForm ='<form id="table-reporting-person">\n' +
        '    <label>Reporting Person Information</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="name-address" type="text" placeholder="1. Name and Address of Reporting Person*">\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="cik" type="text" placeholder="CIK"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="street" type="text" placeholder="Street"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="street2" type="text" placeholder="Street 2"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="city" type="text" placeholder="City"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="state" type="text" placeholder="State"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="zip" type="text" placeholder="Zip"/>\n' +
        '    </div>\n';

    if ($(this).attr('id') === 'fill-reporting-person'){
        tableTwoForm += '<button type="button" id="fill-reporting-person-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    } else {
        tableTwoForm += '<button type="button" id="add-reporting-person-row" data-type="fill" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    }
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click','#add-reporting-person-row', function (e) {
    let data = [];
    var inputs = $('form#table-reporting-person').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    })
    data['stateOrCountryDescription'] = $('#stateOne option:selected').text();

    generateTableRPRow(data);
});

$('body').on('click','#fill-reporting-person-row', function () {

    let data = [];
    var inputs = $('form#table-reporting-person').serializeArray();
    $.each(inputs, function (i, field) {
        if (field.name === 'cik'){
            $('#name-address').closest('a').attr('data-cik',field.value);
            field.value = '/cgi-bin/browse-edgar?action=getcompany&amp;CIK=' + field.value;
            $('#name-address').closest('a').attr('href',field.value);
        } else {
            $('#'+field.name).text(field.value);
        }
    });
    $('.add-table-row-div').html('');
});

//RP - Reporting Person
function generateTableRPRow(data) {
    let row = '<tr><td valign="top" class="reporting-person">\n' +
        '            <span class="MedSmallFormText">1. Name and Address of Reporting Person<sup>*</sup></span><table border="0" width="100%"><tr><td><a class="filing-data" data-cik="'+ data['cik'] +'" data-name="name-address" href="/cgi-bin/browse-edgar?action=getcompany&amp;CIK=' + data['cik'] + '">' + data['name-address'] + '</a></td></tr></table>\n' +
        '            <hr width="98%">\n' +
        '            <table border="0" width="100%"><tr>\n' +
        '                    <td width="33%" class="MedSmallFormText">(Last)</td>\n' +
        '                    <td width="33%" class="MedSmallFormText">(First)</td>\n' +
        '                    <td width="33%" class="MedSmallFormText">(Middle)</td>\n' +
        '                </tr></table>\n' +
        '            <table border="0" width="100%">\n' +
        '                <tr><td><span class="FormData filing-data" data-name="street">' + data['street'] + '</span></td></tr>\n' +
        '                <td><span class="FormData filing-data" data-name="street2">' + data['street2'] + '</span></td>\n' +
        '                <tr><td><span class="FormData"></span></td></tr>\n' +
        '            </table>\n' +
        '            <hr width="98%">\n' +
        '            <span class="MedSmallFormText">(Street)</span><span class="MedSmallFormText"></span><table border="0" width="100%"><tr>\n' +
        '                    <td width="33%"><span class="FormData filing-data" data-name="city">' + data['city'] + '</span></td>\n' +
        '                    <td width="33%"><span class="FormData filing-data" data-name="state">' + data['state'] + '</span></td>\n' +
        '                    <td width="33%"><span class="FormData filing-data" data-name="zip">' + data['zip'] + '</span></td>\n' +
        '                </tr></table>\n' +
        '            <hr width="98%">\n' +
        '            <table border="0" width="100%"><tr>\n' +
        '                    <td width="33%" class="MedSmallFormText">(City)</td>\n' +
        '                    <td width="33%" class="MedSmallFormText">(State)</td>\n' +
        '                    <td width="33%" class="MedSmallFormText">(Zip)</td>\n' +
        '                </tr>' +
        '</table>\n' +
        '        </td>' +
        '        <td>\n' +
        '           <button type="button" class="btn btn-danger btn-sm delete-row">Delete Reporting Person</button>\n' +
        '        </td>\n' +
        '</tr>';

    $('#reporting-person').append(row);
    $('.add-table-row-div').html('');
}


let index = 1;
$('body').on('click', '#add-exp-rsp', function () {
    let row = '<tr><td class="FootnoteData"><span class="editable"><span class="attributes"></span><span class="text filing-data" id="footnote" data-name="footnote"></span><span class="input"><input class="responseInput" size="200" type="text" placeholder="" value='+index+'.></span></span></td>\n' +
        '<td><a style="cursor: pointer" class="delete-row"><i class="bx bx-x" aria-hidden="true"></i></a></td></tr>';

    $('#footnotes').append(row);
    index++;
});



$('body').on('click', '#add-remark-field', function () {
    let row = '<tr><td class="FootnoteData"><span class="editable"><span class="attributes"></span><span class="text filing-data" data-name="remark-field"></span><span class="input"><input class="remarkInput" size="200" type="text" placeholder="" value=""/></span></span></td>\n' +
        '<td><a style="cursor: pointer" class="delete-row"><i class="bx bx-x" aria-hidden="true"></i></a></td></tr>';

    $('#remarks').append(row);
});


$('#add-signature').on('click', function () {
    expandMenu();
    let tableTwoForm ='<form id="table-signature">\n' +
        '    <label>Signature</label>\n' +
        '    <div class="form-group">\n' +
        '        <textarea style="color: #000" class="form-control" name="sig-person" type="text" placeholder="Signature of Reporting Person"></textarea>\n' +
        '    </div>\n' +
        '        <input style="color: #000" class="form-control datepicker " name="date" value="" data-date-format="mm/dd/yyyy" placeholder="Date"/>\n' +
        '    </div>\n' +
        '    </br>' +
        '    <button type="button" id="add-signature-content" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n' +
        '    <button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
    $('.datepicker').pickadate();

});

$('body').on('click','#add-signature-content', function (e) {
    let data = [];
    var inputs = $('form#table-signature').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    generateTableSignatureRow(data);
});

function generateTableSignatureRow(data) {
    let row = '<tr class="signature">\n' +
        '        <td width="60%"></td>\n' +
        '        <td width="20%"><u><span class="FormData filing-data" data-name="ownerSignature">' + data['sig-person'] + '</span></u></td>\n' +
        '        <td width="20%"><u><span class="FormData filing-data" data-name="signatureDate">' + data['date'] + '</span></u></td>\n' +
        '        <td><a style="cursor: pointer;" class="delete-row"><i class="bx bx-x" aria-hidden="true"></i></a></td>\n' +
        '    </tr>';

    $(row).insertBefore('table#signatures > tbody > tr:first');
    $('.add-table-row-div').html('');
}

/*
This method will generate filing only for Forms 3,4,5
 */
function generateFormFilings($button){
    var data = {};
    data['general-data'] = {};
    $('.general-data .filing-data').each(function() {
        if ($(this).data('name') === 'company-name'){
            data['general-data']['cik'] = $(this).attr('href');
        }
        if ($(this).text() === "☒"){
            data['general-data'][$(this).data('name')] = '1';

        } else if ($(this).text() === "☐"){
            data['general-data'][$(this).data('name')] = '0';
        } else {
            data['general-data'][$(this).data('name')] = $(this).text();
        }
    });


    data['non-derivative'] = {};
    data['derivative'] = {};
    $('.non-derivative, .derivative').each(function() {
        let className = $(this).attr('class');
        let i = Object.keys(data[className]).length;
        data[className][i] = {};
        $(this).find('.filing-data').each(function () {
            data[className][i][$(this).data('name')] = $(this).text();
        });
    });

    data['reporting-person'] = {};
    $('.reporting-person').each(function () {
        let i = Object.keys(data['reporting-person']).length;
        data['reporting-person'][i] = {};
        $(this).find('.filing-data').each(function () {
            if ($(this).data('name') === 'name-address'){
                data['reporting-person'][i]['cik'] = $(this).attr('href');
                data['reporting-person'][i]['cik-number'] = $(this).data('cik');
            } else if ($(this).data('code')) {
                data['reporting-person'][i][$(this).data('name')] = $(this).data('code-description');
                data['reporting-person'][i][$(this).data('code')] = $(this).text();
            }
            else {
                data['reporting-person'][i][$(this).data('name')] = $(this).text();
            }
        });
    });



    data['footnotes'] = {};
    $('#footnotes .filing-data').each(function () {
        let i = Object.keys(data['footnotes']).length;
        data['footnotes'][i] = {};
        data['footnotes'][i] = $(this).text();
    });

    data['remarks'] = {};
    $('#remarks .filing-data').each(function () {
        let i = Object.keys(data['remarks']).length;
        data['remarks'][i] = {};
        data['remarks'][i] = $(this).text();
    });

    data['signatures'] = {};
    $('.signature').each(function () {
        let i = Object.keys(data['signatures']).length;
        data['signatures'][i] = {};
        $(this).find('.filing-data').each(function () {
            data['signatures'][i][$(this).data('name')] = $(this).text();
        });
    });

    let htmlContent = $("#content").html();

    let stringJson = JSON.stringify(data);
    $.ajax({
        type: 'POST',
        data: {
            formType: formType,
            filingId: filingID,
            data: stringJson,
            htmlContent: htmlContent,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/generate-filing/generate-filing',
        success: function(response) {
            var link = document.createElement("a");
            link.download = response.file_name;
            link.href = response.url_to_file;
            link.click();
            $('#generateFiles').html('Generate Files');
            $('#generateFiles').removeAttr("disabled");
        }
    });
}
