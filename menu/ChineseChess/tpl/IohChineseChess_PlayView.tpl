<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中国象棋</title>
<link rel="stylesheet" href="css/chinese_chess/play.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/chinese_chess/play.js"></script>
</head>
<body>
<div class="chess-area">
<div class="chess-place">
<table class="chess-table">
{^for $cols = 0 to 9^}
  <tr id="cols{^$cols^}">
{^for $rows = 0 to 8^}
    <td class="chess-box" id="rows{^$rows^}">
{^if isset($chess_list[$cols][$rows])^}
      <span class="chess {^if $chess_list[$cols][$rows]['group']^}cl_blk{^else^}cl_wht{^/if^}" request-chess-id="{^$chess_list[$cols][$rows]['chess_id']^}">{^$chess_info[$chess_list[$cols][$rows]['group']][$chess_list[$cols][$rows]['value']]^}</span>
{^/if^}
    </td>
{^/for^}
  </tr>
{^/for^}
</table>
</div>
<div class="chess-ctrl">
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="game_id" value="{^$game_id^}" id="game_id" />
<input type="hidden" name="chess_id" value="" id="chess_id" />
<input type="hidden" name="to_cols_num" value="" id="to_cols_num" />
<input type="hidden" name="to_rows_num" value="" id="to_rows_num" />
<input type="submit" name="do_chess_mobile" value="确定" />
<input type="button" value="重置" id="cleanup" />
<input type="submit" name="do_refresh_chess" value="刷新" />
</form>
</div>
</div>
</body>
</html>