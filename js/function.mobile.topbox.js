// 智能手机顶部扩展
var top_box_extend_flg = false;
$(document).ready(function(){
    $(".top_box").click(function(){
        var button = $(this).children("div.top_box_extend_btn").children("i.fa");
        if (top_box_extend_flg) {
            $(".top_box_extend_box").css("display","none");
            button.removeClass("fa-chevron-up");
            button.addClass("fa-chevron-down");
            top_box_extend_flg = false;
        } else {
            $(".top_box_extend_box").css("display","block");
            button.removeClass("fa-chevron-down");
            button.addClass("fa-chevron-up");
            top_box_extend_flg = true;
        }
    });
});