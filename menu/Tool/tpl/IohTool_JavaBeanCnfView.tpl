{^if $current_level^}
{^include file=$comheader_file^}
<link rel="stylesheet" href="/tool/java_bean/common.css" type="text/css" />
<script type="text/javascript" src="/tool/java_bean/common.js"></script>
{^else^}
{^include file=$subheader_file^}
<link rel="stylesheet" href="common.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>
{^/if^}
<table class="frame_box">
  <tr>
    <td class="frame_box_left" valign="top">
      <form method="post" action="{^if $current_level^}{^$sys_app_host^}{^else^}{^$sys_app_host^}{^$current_menu^}/{^$current_act^}/{^/if^}" class="form_input_box">
{^if $current_level^}
        <input type="hidden" name="menu" value="{^$current_menu^}" />
        <input type="hidden" name="act" value="{^$current_act^}" />
{^/if^}
{^foreach from=$class_name_list key=class_idx item=class_name^}
        <div class="form_input_cols">
          <div class="form_input_cols_title">{^if $class_object_list[$class_idx]["class_type"]^}public{^else^}{^$subclass_modifier^}{^/if^} class</div>
          <input type="text" name="class_name_list[{^$class_idx^}]" value="{^$class_name^}"{^if $class_object_list[$class_idx]["class_type"]^} readonly{^/if^} data-class-id="{^$class_idx^}" class="input_box text_box" />
          <input type="hidden" name="class_object_list[{^$class_idx^}][class_type]" value="{^if $class_object_list[$class_idx]["class_type"]^}1{^else^}0{^/if^}" />
        </div>
{^foreach from=$class_object_list[$class_idx]["class_property"] key=prop_idx item=prop_info^}
        <div class="form_input_cols">
          <div class="form_input_cols_title">private</div>
{^if $prop_info["property_datatype_class"]^}
          <div class="form_input_cols_title">
            {^if $prop_info["property_list_flg"]^}List&lt;{^/if^}<span id="class_{^$prop_info["property_datatype_class"]^}">{^$class_name_list[$prop_info["property_datatype_class"]]^}</span>{^if $prop_info["property_list_flg"]^}&gt;{^/if^}
            <input type="hidden" name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_datatype]" value="0" />
            <input type="hidden" name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_datatype_class]" value="{^$prop_info["property_datatype_class"]^}" />
          </div>
{^else^}
          <select name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_datatype]" class="input_box pulldown_box">
{^foreach from=$datatype_list key=type_idx item=type_itm^}
            <option value="{^$type_idx^}"{^if $prop_info["property_datatype"] eq $type_idx^} selected{^/if^}>{^$type_itm^}</option>
{^/foreach^}
          </select>
          <input type="hidden" name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_datatype_class]" value="{^$prop_info["property_datatype_class"]^}" />
{^/if^}
          <div class="form_input_cols_title">{^$prop_info["property_name"]^}</div>
          <input type="hidden" name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_name]" value="{^$prop_info["property_name"]^}" />
          <input type="hidden" name="class_object_list[{^$class_idx^}][class_property][{^$prop_idx^}][property_list_flg]" value="{^if $prop_info["property_list_flg"]^}1{^else^}0{^/if^}" />
        </div>
{^/foreach^}
        <div class="form_input_cols"></div>
{^/foreach^}
      <div class="form_input_cols">
        <label>
          <span class="button blue_button bl_l">返回</span>
          <input type="submit" name="do_rollback" value="1" class="disp_none" />
        </label>
        <label>
          <span class="button orange_button bl_l">生成JavaBean</span>
          <input type="submit" name="do_confirm" value="2" class="disp_none" />
        </label>
      </div>
      </form>
    </td>
    <td class="frame_box_right" valign="top" id="disp_json_code">
      <pre class="disp_json_code_box">{^$disp_json_code^}</pre>
    </td>
  </tr>
</table>
{^include file=$empfooter_file^}