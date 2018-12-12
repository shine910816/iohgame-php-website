$(document).ready(function(){
    $("#file_upload").change(function(){
        var file_name = $(this).val();
        var pos = file_name.lastIndexOf("\\");
        file_name = file_name.substring(pos+1); 
        $("#file_name_box").val(file_name);
    });
    $('input').keypress(function(e){
        if(e.keyCode == 13){
            e.preventDefault();
        }
    });
});