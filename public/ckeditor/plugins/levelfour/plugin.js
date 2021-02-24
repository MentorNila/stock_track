CKEDITOR.plugins.add( 'levelfour', {
    icons: 'levelfour',
    init: function( editor ) {
        editor.addCommand( 'levelfour', {
            exec: function( editor ) {
                let selectedText = editor.getSelection().getSelectedText();
                tagType = 'tag';
                levelOfTag = '4';
                if (selectedText !== "" && editor.getSelection().getStartElement().getParent().$.closest('.sections') !== null) {
                    loadModal(levelOfTag, selectedText);
                    taglevels = true;
                    activeSectionId = editor.getSelection().getStartElement().getParent().$.closest('.sections').getAttribute('tag-id');
                } else {
                    alert('Tags must be under a specific section. Please create a section for a specific part of the document.');
                }
            }
        });
        editor.ui.addButton( 'levelfour', {
            label: 'Level 4',
            command: 'levelfour',
            toolbar: 'tagging'
        });
    }
});
