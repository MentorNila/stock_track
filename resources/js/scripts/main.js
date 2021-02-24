$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
        allEditors[i],
        {
            removePlugins: ['ImageUpload']
        }
    );
  }

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2();

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })

    $('.exhibit-select').select2({
        placeholder: 'Select exhibits',
        allowClear: true
    });

  $("#selectSecForm").change(event => {

      let selectedFormType = $(event.target).val();
      $('#exhibit-select').html("");
      $.ajax({
        url: `/form-exhibits?formType=${selectedFormType}`,
        type: "GET",
        contentType: "application/json; charset=utf-8",
        success: exhibitRes => {
            exhibitRes.map(exhibit => {
                $("#exhibit-select").append(`<option value='${exhibit.exhibit.id}' name='${exhibit.exhibit.id}'>${exhibit.exhibit.code} - ${exhibit.exhibit.description}</option>`);
            });
        }
      });
    });
})
