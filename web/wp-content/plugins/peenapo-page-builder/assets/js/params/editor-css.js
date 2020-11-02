var bwpbCssEditors = {};
$('.bwpb-css-editor').each(function() {
    var $this = $(this);
    var editorId = $this.attr('id');
    
    var $editor = ace.edit( editorId );
    bwpbCssEditors[ editorId ] = $editor;
    
    $editor.setTheme("ace/theme/chrome");
    $editor.getSession().setMode("ace/mode/css");
    
    $editor.clearSelection();
    
    
});