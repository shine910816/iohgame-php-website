<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Object ID 转换工具</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/common/common.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/object_id.js"></script>
<script type="text/javascript">
var url = "./?menu=tool&act=trans_object_id&trans_object_id=";
$(document).ready(function(){
    $("#base").blur(function(){
        $.get(url + encodeURIComponent($("#base").val()), function(result){
            $("#trans_object_id").val(result);
        });
    });
    $("#base").keyup(function(){
        $("#en").val($("#base").val());
    });
    $(".object_id_box").focus(function(){
        $(this).select();
    });
    $(".update_object_id").click(function(){
        var target_id = "tr#o_id_" + $(this).data("o-id");
        $(target_id + " td span.def_disp").addClass("no_disp");
        $(target_id + " td span.upd_disp").removeClass("no_disp");
    });
});
</script>
<style type="text/css">
form {
  width:1000px;
  margin: 10px auto;
}
th, td {
  height:30px;
}
.no_disp {
  display:none;
}
.object_id_box {
  width:310px;
  font-family:Ubuntu;
  font-size:17px;
  background-color:#EEE;
  text-align:center;
}
.input_text_box {
  width:134px;
}
.input_text_box,
.object_id_box {
  height:28px;
  padding:0 5px;
  border:1px solid #000;
  line-height:28px;
}
.input_text_box:focus,
.object_id_box:focus {
  border:1px solid #0DF;
}
.icon_box {
  text-align:center!important;
}
.icon_box i {
  color:#F60;
}
</style>
</head>
<body>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th width="150px">基本词</th>
    <th width="400px">Object ID</th>
    <th width="150px">中文</th>
    <th width="150px">English</th>
    <th width="150px">日本語</th>
    <th width="50px">操作</th>
  </tr>
  <tr>
    <td><input type="text" name="new[o_base]" id="base" class="input_text_box" /></td>
    <td><input type="text" name="new[object_id]" id="trans_object_id" class="object_id_box" value="" readonly></td>
    <td><input type="text" name="new[o_cn]" class="input_text_box" /></td>
    <td><input type="text" name="new[o_en]" id="en" class="input_text_box" /></td>
    <td><input type="text" name="new[o_ja]" class="input_text_box" /></td>
    <td class="icon_box">
      <label>
        <span title="上传"><i class="fa fa-plus fa-2x"></i></span>
        <input type="submit" name="do_submit" value="1" class="no_disp" />
      </label>
    </td>
  </tr>
{^if !empty($object_id_list)^}
{^foreach from=$object_id_list item=object_id_item^}
  <tr id="o_id_{^$object_id_item["o_id"]^}">
    <td>{^$object_id_item["o_base"]^}</td>
    <td><input type="text" class="object_id_box" value="{^$object_id_item["object_id"]^}" readonly></td>
    <td>
      <span class="def_disp">{^$object_id_item["o_cn"]^}</span>
      <span class="upd_disp no_disp">
        <input type="text" name="update[{^$object_id_item["o_id"]^}][o_cn]" value="{^$object_id_item["o_cn"]^}" class="input_text_box" />
      </span>
    </td>
    <td>
      <span class="def_disp">{^$object_id_item["o_en"]^}</span>
      <span class="upd_disp no_disp">
        <input type="text" name="update[{^$object_id_item["o_id"]^}][o_en]" value="{^$object_id_item["o_en"]^}" class="input_text_box" />
      </span>
    </td>
    <td>
      <span class="def_disp">{^$object_id_item["o_ja"]^}</span>
      <span class="upd_disp no_disp">
        <input type="text" name="update[{^$object_id_item["o_id"]^}][o_ja]" value="{^$object_id_item["o_ja"]^}" class="input_text_box" />
      </span>
    </td>
    <td class="icon_box">
      <span class="def_disp update_object_id" data-o-id="{^$object_id_item["o_id"]^}" title="修改"><i class="fa fa-pencil fa-2x"></i></span>
      <span class="upd_disp no_disp" title="上传">
        <label>
          <span><i class="fa fa-refresh fa-2x"></i></span>
          <input type="submit" name="do_update" value="{^$object_id_item["o_id"]^}" class="no_disp" />
        </label>
      </span>
    </td>
  </tr>
{^/foreach^}
{^/if^}
</table>
</form>
</body>
</html>