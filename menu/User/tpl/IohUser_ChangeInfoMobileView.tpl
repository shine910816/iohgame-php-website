{^include file=$mblheader_file^}
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>修改个人信息</h3>
{^if !$confirm_flg^}
  <fieldset data-role="controlgroup" data-type="horizontal">
    <legend>性别</legend>
    <input name="custom_info[custom_gender]" id="custom_gender_male" value="1" type="radio" />
    <label for="custom_gender_male">男&#9794;</label>
    <input name="custom_info[custom_gender]" id="custom_gender_female" value="0" type="radio" checked />
    <label for="custom_gender_female">女&#9792;</label>
  </fieldset>
  <label for="birthday">生日</label>
  <input name="custom_info[custom_birth]" id="birthday" value="{^$custom_birth^}" type="date">
  <p><span class="fc_orange">*性别与生日确认后不可更改</span></p>
{^/if^}
  <fieldset data-role="controlgroup" data-iconpos="right">
    <legend>公开状态</legend>
{^foreach from=$open_level_list key=open_level_key item=open_level_item^}
    <input name="custom_info[open_level]" id="open_level_{^$open_level_key^}" value="{^$open_level_key^}" type="radio"{^if $open_level_key eq $open_level^} checked{^/if^} />
    <label for="open_level_{^$open_level_key^}">{^$open_level_item^}</label>
{^/foreach^}
  </fieldset>
</div>
<button type="submit" name="do_change" class="ui-btn ui-corner-all ui-btn-b" />确认修改</button>
<a href="./?menu=user&act=disp" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
</form>
{^include file=$mblfooter_file^}