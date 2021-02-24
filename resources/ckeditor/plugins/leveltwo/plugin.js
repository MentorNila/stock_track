CKEDITOR.plugins.add( 'leveltwo', {
    icons: 'leveltwo',
    init: function( editor ) {
        editor.addCommand( 'leveltwo', {
            exec: function( editor ) {
                let selectedText = editor.getSelection().getSelectedText();
                tagType = 'text-block';
                levelOfTag = '2';
                if (selectedText !== "") {
                    let span = new CKEDITOR.dom.element("span");
                    span.setAttributes({id: 'selectedHtml'});
                    let sel = editor.getSelection();
                    let ranges = sel.getRanges();
                    for (var i = 0, len = ranges.length; i < len; ++i) {
                        span.append(ranges[i].cloneContents());
                    }
                    let html = span.$.innerHTML;
                    loadModal(levelOfTag, html);
                    activeSectionId = true;
                    taglevels = true;
                }
            }
        });
        editor.ui.addButton( 'leveltwo', {
            label: 'Level 2',
            command: 'leveltwo',
            toolbar: 'tagging'
        });
    }
});
