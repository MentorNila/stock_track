$('.choose-form-btn').on('click', function () {
    var companyId = $('#company_id').val();
    var formType = $('#selectSecForm').val();
    if(formType && companyId){
        $.ajax({
            type: 'GET',
            data: {
                companyId: companyId,
                formType: formType,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/generate-filing/upload-data',
            success: function(response) {
                if(response.url != null){
                    window.location.href = response.url;
                } else {
                    $('#statements-exhibits-content').html(response.view);
                    $('.datepicker').datepicker();
                    $("#fiscal_year_focus").datepicker({
                        format: "yyyy",
                        viewMode: "years",
                        minViewMode: "years"
                    });
                    $("#year_end_date").datepicker({
                        format: "--mm-dd"
                    });
                }
            }
        });
    }
});

$('.excel-file').val("");
$('body').on('change', '.excel-file', function() {
    var files = this.files;
    $('#file-name').html('');
    $('#choose-sheets').html('');
    Array.from(files).forEach(file => {
        new getSheetNames().parseExcel(file);
        previewImage(file['name']);
    });
});
function previewImage(file) {
    $('#file-name').append(file+'<br>');
    $('#file-name').show();
}
var getSheetNames = function() {
    this.parseExcel = function(file) {
        // console.log('changed js here');
        // var reader = new FileReader();
        // reader.onload = function(e) {
        //     var data = e.target.result;
        //     var workbook = XLSX.read(data, {
        //         type: 'binary'
        //     });
        //     $('#choose-sheets').append('<p class="blue sheet-name-p">Please select sheets from '+ file['name'] +' that you want to convert:</p>')
        //     $.each(workbook.Workbook.Sheets, function (index, sheet) {
        //         if(sheet['state'] === 'visible') {
        //             $('#choose-sheets').append('<div class="form-check">\n' +
        //                 '  <input class="form-check-input" type="checkbox" value="' + sheet['name'] + '" name="sheet-name[]" id="default-' + sheet['name'] + '">\n' +
        //                 '  <label class="form-check-label blue" for="default-' + sheet['name'] + '">\n' +
        //                 '    ' + sheet['name'] + '\n' +
        //                 '  </label>\n' +
        //                 '</div>');
        //         }
        //     });
        // };

        // reader.onerror = function(ex) {
        //     console.log(ex);
        // };
        //
        // reader.readAsBinaryString(file);
    };
};

$('body').on('change', '.exhibit-file', function() {
    var file = this.files;
    $(this).parent().next().html(file[0]['name']);
    $(this).parent().next().show();
});

$('body').on('click', '.add-exhibit',function () {
    var countExhibits = $('.exhibits').length;
    $.ajax({
        type: 'GET',
        data: {
            exhibitNumber: countExhibits,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/generate-filing/add-new-exhibit',
        success: function(response) {
            $('#exhibits-content').append(response.exhibit);

        }
    });
});

$('body').on('click', '.delete-exhibit',function () {
    $(this).closest('.exhibits').remove();
});

$('body').on('click','#loader', function(){
    $(this).html('<i class="fa fa-spinner fa-spin"></i> Next')
});

$('body').on('change', '.word-file', function() {
    $('.word-file-name').html('');
    $('.word-file-name').show();
    var files = this.files;
    $('.word-file-name').html(files[0]['name']);
});
