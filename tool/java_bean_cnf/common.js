// JavaBean作成
$(document).ready(function(){
    $("input.text_box").keyup(function(){
        var class_id = $(this).data("class-id");
        var class_name = $(this).val();
        $("span#class_" + class_id).html(class_name);
    });
});