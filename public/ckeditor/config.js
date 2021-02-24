/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.toolbar = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
        { name: 'forms', items: ['Checkbox', 'Radio', 'TextField', 'Textarea', 'Select'] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Blockquote', 'CreateDiv', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak' ] },
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
        { name: 'others', items: [ '-' ] },
        { name: 'checkboxes', items: ['checked', 'unchecked', 'exhibitLink' ]  },
        { name: 'tagging', items: ['levelone', 'leveltwo', 'levelthree', 'levelfour']  },
        { name: 'generating', items: ['generate', 'users', 'comment'] },
        // { name: 'about', items: [ 'About' ] }
    ];

    config.resize_enabled = false;
    config.height = '70vh';
    config.allowedContent = true;
    config.extraAllowedContent = 'div(*)';
    config.skin = 'office2013';

};
