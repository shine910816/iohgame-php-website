<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{^$system_page_keyword^}">
<meta name="description" content="{^$system_page_description^}">
<title>天津麻将</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/mahjong_game/mahjong_card.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
var api_base_url = "./api/?act=mahjong_game&m_room_id={^$m_room_id^}";
var refresh_flg = {^if $refresh_flg^}true{^else^}false{^/if^};
var target_player = "{^$target_player^}";
var error_text = "Server error happened";
$(document).ready(function(){
    if (refresh_flg) {
        setInterval(function(){
            var url = api_base_url + "&refresh="
            $.ajax({
                type:"GET",
                url:url,
                dataType:"xml",
                success:function(data){
                    var status = $(data).find("status").text();
                    var error = $(data).find("error").text();
                    if (status == "200" && error == "0") {
                        if ($(data).find("results").find("target").text() != target_player) {
                            window.location.reload();
                        }
                    } else {
                        alert(error_text);
                    }
                },
                error:function(){
                    alert(error_text);
                }
            });
        }, 3000);
    }
    $(".card_drop_able").click(function(){
        if (!refresh_flg) {
            var url = api_base_url + "&drop=" + $(this).data("order-id");
            $.ajax({
                type:"GET",
                url:url,
                dataType:"xml",
                success:function(data){
                    var status = $(data).find("status").text();
                    var error = $(data).find("error").text();
                    if (status == "200" && error == "0") {
                        window.location.reload();
                    } else {
                        alert(error_text);
                    }
                },
                error:function(){
                    alert(error_text);
                }
            });
        }
    });
});
</script>
<style type="text/css">
.card_cols {
  width:1012px;
  height:80px;
  list-style:none;
}
.card_box {
  width:60px;
  height:80px;
  margin-right:-4px;
  float:left;
}
</style>
</head>
<body>
<ul class="card_cols">
{^foreach from=$player_hand_card_info item=player_hand_card^}
  <li class="card_box">
    <div class="mahjong_card card_{^$player_hand_card["c_img"]^} {^if $player_hand_card["m_card_hand_disp_flg"]^}card_mask_disp{^elseif $player_hand_card["m_card_dora_flg"]^}card_mask_dora card_drop_able{^elseif $player_hand_card["m_card_target_flg"]^}card_mask_target card_drop_able{^else^}card_mask_common card_drop_able{^/if^}" data-order-id="{^$player_hand_card["m_order_id"]^}">
      <div><!--蒙版_{^$player_hand_card["c_tile"]^}--></div>
    </div>
  </li>
{^/foreach^}
</ul>
</body>
</html>