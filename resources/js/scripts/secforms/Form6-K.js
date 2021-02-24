
function generateFormFilings($button) {
    var data = {};

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
        success: function (response) {
            var link = document.createElement("a");
            link.download = response.file_name;
            link.href = response.url_to_file;
            link.click();
        }
    });
}
