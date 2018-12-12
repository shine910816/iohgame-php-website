/* 阴阳师 */
$(document).ready(function(){
    $("span.skin_btn").click(function(){
        // 参数获取
        var s_id = "#skgm_" + $(this).data("skgm-id");
        var img_path = "#" + $(this).data("img-path");
        var awake_path = $(this).data("awake-path");
        var awake_status = $(this).data("awake-status");
        $(s_id + ">.skgm_name_img_box>.skgm_name_skin_box>.skgm_skin_box>li>.skin_btn_slct").removeClass("skin_btn_slct");
        $(this).addClass("skin_btn_slct");
        $(s_id + ">.skgm_name_img_box>.skgm_img_box>img.disp").removeClass("disp");
        $(img_path).addClass("disp");
        if (awake_status) {
            $(s_id + ">.skgm_info_box>.skgm_prop_all_box>div.skgm_prop_box").removeClass("before_slct after_slct");
            $("#prop_" + awake_path).addClass("after_slct");
        } else {
            $(s_id + ">.skgm_info_box>.skgm_prop_all_box>div.skgm_prop_box").removeClass("before_slct after_slct");
            $("#prop_" + awake_path).addClass("before_slct");
        }
        $(s_id + ">.skgm_info_box>div.disp").removeClass("disp");
        $("#skill_" + awake_path).addClass("disp");
    });
});
