{^if $current_level^}
{^include file=$comheader_file^}
<link rel="stylesheet" href="/tool/java_bean/common.css" type="text/css" />
<script type="text/javascript" src="/tool/java_bean/common.js"></script>
{^else^}
{^include file=$subheader_file^}
<link rel="stylesheet" href="common.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>
{^/if^}
{^include file=$usererror_file^}
<form method="post" action="{^if $current_level^}{^$sys_app_host^}{^else^}{^$sys_app_host^}{^$current_menu^}/{^$current_act^}/{^/if^}" class="form_input_box">
{^if $current_level^}
  <input type="hidden" name="menu" value="{^$current_menu^}" />
  <input type="hidden" name="act" value="{^$current_act^}" />
{^/if^}
  <div class="form_input_cols">
    <div class="form_input_cols_title">package</div>
    <input type="text" name="package_name" value="{^$package_name^}" class="input_box text_box" />
  </div>
  <div class="form_input_cols">
    <div class="form_input_cols_title">文件名</div>
    <input type="text" name="class_name" value="{^$class_name^}" class="input_box text_box" />
  </div>
  <div class="form_input_cols">
    <div class="form_input_cols_title">内部类修饰符</div>
    <select name="subclass_modifier" class="input_box pulldown_box">
{^foreach from=$modifier_list key=modifier_idx item=modifier_itm^}
      <option value="{^$modifier_idx^}"{^if $modifier_idx eq $subclass_modifier^} selected{^/if^}>{^$modifier_itm^}</option>
{^/foreach^}
    </select>
  </div>
  <div class="form_input_cols textarea_cols">
    <div class="form_input_cols_title">Json内容</div>
    <textarea name="json_code" class="input_box textarea_box" wrap="off">{^$json_code^}</textarea>
  </div>
  <div class="form_input_cols">
    <label>
      <input type="submit" name="do_upload" value="1" class="disp_none" />
      <span class="button select_button">解析Json结构</span>
    </label>
  </div>
</form>
{^include file=$empfooter_file^}