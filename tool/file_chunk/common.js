$(document).ready(function(){
    $("#file_upload").change(function(){
        var file_name = $(this).val();
        var pos = file_name.lastIndexOf("\\");
        file_name = file_name.substring(pos+1); 
        $("#file_name_box").val(file_name);
    });
    $("input.file_content_textbox").focus(function(){
        $(this).select();
    });
});