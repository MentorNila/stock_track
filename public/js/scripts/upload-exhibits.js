// Add the following code if you want the name of the file appear on select
$("body").on("change", '.custom-file-input', function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$('.excel-file').val("");
$('body').on('change', '.excel-file', function() {
    $('#next-button').html('');
    $('#next-button').html('<button id="loader" type="submit" value="Next" class="buttonload btn btn-success" style="width: 200px">Next</button>')
    var files = this.files;
    $('#file-name').html('');
    $('#choose-sheets').html('');
    files.forEach((file)=>{
        new getSheetNames().parseExcel(file);
        previewImage(file['name']);
    });
});

function previewImage(file) {
    $('#file-name').append(file+'<br>');
    $('#file-name').show();
}
$('body').on('click','#loader', function(){
    $(this).html('<i class="fa fa-spinner fa-spin"></i> Next')
});

var getSheetNames = function() {
    this.parseExcel = function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            $('#choose-sheets').append('</br><p>Please select sheets from '+ file['name'] +' that you want to convert:</p>')
            $.each(workbook.Workbook.Sheets, function (index, sheet) {
                if(sheet['state'] === 'visible') {
                    $('#choose-sheets').append('<div class="form-check">\n' +
                        '  <input class="form-check-input" type="checkbox" value="' + sheet['name'] + '" name="sheet-name[]" id="default-' + sheet['name'] + '">\n' +
                        '  <label class="form-check-label" for="default-' + sheet['name'] + '">\n' +
                        '    ' + sheet['name'] + '\n' +
                        '  </label>\n' +
                        '</div>');
                }
            });
        };

        reader.onerror = function(ex) {
            console.log(ex);
        };

        reader.readAsBinaryString(file);
    };
};
$('.add-exhibit').on('click', function () {
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
