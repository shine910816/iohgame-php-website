{^if $current_level^}
{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
{^else^}
{^include file=$subheader_file^}
{^/if^}
<style type="text/css">
/* 错误画面 */
.error_box {
  width:500px;
  border:1px solid #F00;
  background-color:#FFF;
}
.error_box .error_title {
  width:480px;
  height:40px;
  background-color:#F00;
  padding-left:20px;
  font-size:16px;
  line-height:40px;
  color:#FFF;
}
.error_box ul {
  width:400px;
  list-style:none;
  margin:20px auto 0;
}
.error_box ul li {
  width:400px;
  height:25px;
  line-height:25px;
}
</style>
<div class="error_box bl_c mt_30 pb_20">
<div class="error_title"><i class="fa fa-warning fa-lg"></i> 出错啦</div>
<ul>
  <li>错误代码： {^$err_code^}</li>
  <li>发生时间： {^$err_date|date_format:"%Y-%m-%d %H:%M:%S"^}</li>
  <li>对您造成了不便敬请谅解</li>
</ul>
<ul>
  <li>您可以尝试以下操作避免发生错误</li>
  <li>■ 点击下方返回按钮，返回上一页面重新操作</li>
  <li>■ 请勿擅自修改地址栏及源代码中的内容</li>
  <li>■ 如遇系统繁忙，请稍后再试</li>
</ul>
<ul>
  <li><input type="button" class="button btn_grey bl_c" onclick="javascript:history.back()" value="返回" /></li>
</ul>
<ul></ul>
</div>
{^if $current_level^}
{^include file=$comfooter_file^}
{^else^}
{^include file=$empfooter_file^}
{^/if^}
