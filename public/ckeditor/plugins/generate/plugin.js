CKEDITOR.plugins.add( 'generate', {
    icons: 'generate',
    init: function( editor ) {
        editor.addCommand( 'generateFiling', {
            exec: function( editor ) {
                if (formType === 'Form3' || formType === 'Form4' || formType === 'Form5' || formType === 'FormD' || formType === '13FHR'){
                    generateFormFilings($('#generateFiles'));
                } else {
                    let content = CKEDITOR.instances['document-ckeditor'].getData();
                    let updateContent = cleanTagable(content);
                    $.ajax({
                        type: 'POST',
                        data: {
                            formType: formType,
                            filingId: filingID,
                            htmlContent: updateContent
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: '/generate-filing/generate-filing',
                        success: function(response) {
                            var link = document.createElement("a");
                            link.download = response.file_name;
                            link.href = response.url_to_file;
                            link.click();
                        }
                    });
                }
            }
        });
        editor.ui.addButton( 'generate', {
            label: 'Generate Filing',
            command: 'generateFiling',
            toolbar: 'generating'
        });
    }
});
