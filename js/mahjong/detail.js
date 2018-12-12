/* 麻将详细 */
var top_box_disp_flg = false;
var east_box_disp_flg = false;
var south_box_disp_flg = false;
var west_box_disp_flg = false;
var north_box_disp_flg = false;
var detail_box_default_height = "3em";
var detail_box_spread_height = "66em";
$(document).ready(function(){
    $("div.top_title").click(function(){
        if(top_box_disp_flg) {
            $("div.top_box").css("height","3em");
            $("div.top_title").css("opacity","1");
            top_box_disp_flg = false;
        } else {
            $("div.top_box").css("height","11.2em");
            $("div.top_title").css("opacity","0.7");
            top_box_disp_flg = true;
        }
    });
    $("div.east_box ul.detail_title").click(function(){
        $("div.detail_box ul.detail_title").css("opacity","1");
        $("div.detail_box").css("height",detail_box_default_height);
        south_box_disp_flg = false;
        west_box_disp_flg = false;
        north_box_disp_flg = false;
        if (east_box_disp_flg) {
            $("div.east_box ul.detail_title").css("opacity","1");
            $("div.east_box").css("height",detail_box_default_height);
            east_box_disp_flg = false;
        } else {
            $("div.east_box ul.detail_title").css("opacity","0.7");
            $("div.east_box").css("height",detail_box_spread_height);
            east_box_disp_flg = true;
        }
    });
    $("div.west_box ul.detail_title").click(function(){
        $("div.detail_box ul.detail_title").css("opacity","1");
        $("div.detail_box").css("height",detail_box_default_height);
        east_box_disp_flg = false;
        south_box_disp_flg = false;
        north_box_disp_flg = false;
        if (west_box_disp_flg) {
            $("div.west_box ul.detail_title").css("opacity","1");
            $("div.west_box").css("height",detail_box_default_height);
            west_box_disp_flg = false;
        } else {
            $("div.west_box ul.detail_title").css("opacity","0.7");
            $("div.west_box").css("height",detail_box_spread_height);
            west_box_disp_flg = true;
        }
    });
    $("div.south_box ul.detail_title").click(function(){
        $("div.detail_box ul.detail_title").css("opacity","1");
        $("div.detail_box").css("height",detail_box_default_height);
        east_box_disp_flg = false;
        west_box_disp_flg = false;
        north_box_disp_flg = false;
        if (south_box_disp_flg) {
            $("div.south_box ul.detail_title").css("opacity","1");
            $("div.south_box").css("height",detail_box_default_height);
            south_box_disp_flg = false;
        } else {
            $("div.south_box ul.detail_title").css("opacity","0.7");
            $("div.south_box").css("height",detail_box_spread_height);
            south_box_disp_flg = true;
        }
    });
    $("div.north_box ul.detail_title").click(function(){
        $("div.detail_box ul.detail_title").css("opacity","1");
        $("div.detail_box").css("height",detail_box_default_height);
        east_box_disp_flg = false;
        south_box_disp_flg = false;
        west_box_disp_flg = false;
        if (north_box_disp_flg) {
            $("div.north_box ul.detail_title").css("opacity","1");
            $("div.north_box").css("height",detail_box_default_height);
            north_box_disp_flg = false;
        } else {
            $("div.north_box ul.detail_title").css("opacity","0.7");
            $("div.north_box").css("height",detail_box_spread_height);
            north_box_disp_flg = true;
        }
    });
    $(".top_selection").click(function(){
        $("input[name='round']").val($(this).data("target-value"));
        $(".top_selection").removeClass("selected");
        $(this).addClass("selected");
    });
    $(".four_selection").click(function(){
        $(".undisp").val("0");
        var target_id = $(this).data("target-id");
        $("#" + target_id).val($(this).data("target-value"));
        $(".four_selection").removeClass("selected");
        $(this).addClass("selected");
    });
    $(".tianhu_selection").click(function(){
        var tianhu_flg = $("#" + $(this).data("target-id")).val();
        if (tianhu_flg == "1") {
            $("#" + $(this).data("target-id")).val("0");
            $(".tianhu_selection").removeClass("selected");
        } else {
            $("#" + $(this).data("target-id")).val("1");
            $(".tianhu_selection").addClass("selected");
        }
    });
    $(".gangkai_selection").click(function(){
        $(".gangkai_selection").removeClass("selected");
        $(this).addClass("selected");
        var target_id = $(this).data("target-id");
        var target_value = $(this).data("target-value");
        var memory_value = $("#" + target_id).val();
        if (target_value == memory_value) {
            $("#" + target_id).val("0");
            $(this).removeClass("selected");
        } else {
            $("#" + target_id).val(target_value);
        }
    });
    $(".important_selection").click(function(){
        $(".undisp").val("0");
        var target_id = $(this).data("target-id");
        $("#" + target_id).val($(this).data("target-value"));
        $(".important_selection").removeClass("important_selected");
        $(this).addClass("important_selected");
        $(".hidden_times_selection").val("0");
        $(".times_selection").removeClass("selected");
    });
    $(".times_selection").click(function(){
        var target_id = $(this).data("target-id");
        var target_value = $("#" + target_id).val();
        if (target_value == "1") {
            $("#" + target_id).val("0");
            $(this).removeClass("selected");
        } else {
            $("#" + target_id).val("1");
            $(this).addClass("selected");
        }
    });
});