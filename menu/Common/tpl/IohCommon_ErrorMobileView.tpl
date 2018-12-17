{^include file=$mblheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h1>出错啦</h1>
  </div>
  <div class="ui-body ui-body-a">
    <p>错误代码： {^$err_code^}<br/>发生时间： {^$err_date|date_format:"%Y-%m-%d %H:%M:%S"^}<br/>对您造成了不便敬请谅解</p>
  </div>
</div>
<h1></h1>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h1>您可以尝试以下操作避免发生错误</h1>
  </div>
  <div class="ui-body ui-body-a">
    <p>■ 点击返回按钮至上一页面重新操作<br/>■ 请勿擅自修改地址栏及源代码中的内容<br/>■ 如遇系统繁忙请稍后再试</p>
  </div>
</div>
<h1></h1>
<button class="ui-btn ui-icon-carat-l ui-btn-icon-left" onclick="javascript:history.back()">返回</button>
{^include file=$mblfooter_file^}