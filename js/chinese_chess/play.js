/**
 * 中国象棋
 */
$(document).ready(function(){
    var game_id = $("#game_id").val();
    var ajax_url = "./?menu=chinese_chess&act=play";
    var chess_cnf_flg = 0;
    var chess_cmp_flg = 0;
    var chess_temp = "";
    var cleanup = function(){
        $("#chess_id").val("");
        $(".disappear").removeClass("disappear");
        $(".tempchess").remove();
        $(".chess-select-confirm").removeClass("chess-select-confirm");
        $(".chess-select-complete").removeClass("chess-select-complete");
        $("#to_cols_num").val("");
        $("#to_rows_num").val("");
        $("#chess_temp_str").val("");
        chess_cnf_flg = 0;
        chess_cmp_flg = 0;
        chess_temp = "";
    };
    $(".chess").each(function(){
        $(this).click(function(){
            var chess_id = $(this).attr("request-chess-id");
            if (!chess_cnf_flg) {
                $("#chess_id").val(chess_id);
                chess_cnf_flg = 1;
                chess_temp = "<span class=\""+$(this).parent().find("span").attr("class")+" tempchess\">"+$(this).parent().find("span").html()+"</span>";
                $(this).parent().addClass("chess-select-complete");
                $.ajax({
                    url:ajax_url+"&get_chess_mobile="+chess_id+"&game_id="+game_id,
                    success:function(data){
                        var dataObj = eval("("+data+")");
                        if (dataObj.result) {
                            $.each(dataObj.content,function(idx,item){
                                choose = ".chess-table #cols"+item.c+" #rows"+item.r;
                                $(choose).addClass("chess-select-confirm");
                            });
                            $(".chess-select-confirm").each(function(){
                                $(this).click(function(){
                                    if (!chess_cmp_flg) {
                                        chess_cmp_flg = 1;
                                        var cols_num = $(this).parent().attr("id");
                                        var rows_num = $(this).attr("id");
                                        var target = $(".chess-table #"+cols_num+" #"+rows_num);
                                        if (target.find("span").html()) {
                                            target.find("span").addClass("disappear");
                                        }
                                        $(".chess-select-confirm").removeClass("chess-select-confirm");
                                        target.append(chess_temp);
                                        target.addClass("chess-select-complete");
                                        $("span[request-chess-id="+$("#chess_id").val()+"]").addClass("disappear");
                                        $("span[request-chess-id="+$("#chess_id").val()+"]").parent().addClass("chess-select-complete");
                                        $("#to_cols_num").val(cols_num);
                                        $("#to_rows_num").val(rows_num);
                                    }
                                });
                            });
                        } else {
                            cleanup();
                        }
                    }
                });
            } else {
                if ($("#chess_id").val() == chess_id) {
                    cleanup();
                }
            }
        });
    });
    $("#cleanup").click(function(){
        cleanup();
    });
});