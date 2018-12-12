/* 麻将开始 */
var top_box_disp_flg = false;
$(document).ready(function(){
    $("#new_game_box").click(function(){
        if (top_box_disp_flg) {
            $("#top_box").css("height","3em");
            $("#new_game_box").css("opacity","1");
            top_box_disp_flg = false;
        } else {
            $("#top_box").css("height","32em")
            $("#new_game_box").css("opacity","0.7");
            top_box_disp_flg = true;
        }
    });
});