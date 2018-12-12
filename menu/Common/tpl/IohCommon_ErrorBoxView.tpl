{^if $user_err_flg^}
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
<div class="error_box bl_c mt_30 pb_10">
<div class="error_title"><i class="fa fa-warning fa-lg"></i> 以下所述的内容可能存在错误</div>
<ul class="mt_10">
  {^foreach from=$user_err_list item=user_err^}<li>■ {^$user_err^}</li>{^/foreach^}
</ul>
</div>
{^/if^}