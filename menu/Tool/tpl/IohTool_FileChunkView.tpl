{^if $current_level^}
{^include file=$comheader_file^}
<link rel="stylesheet" href="/tool/file_chunk/common.css" type="text/css" />
<script type="text/javascript" src="/tool/file_chunk/common.js"></script>
{^else^}
{^include file=$subheader_file^}
<link rel="stylesheet" href="common.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>
{^/if^}
<table class="disp_box">
  <tr>
    <td class="disp_box_left" valign="top">
      <form class="upload_file_box" method="post" action="{^if $current_level^}{^$sys_app_host^}{^else^}{^$sys_app_host^}{^$current_menu^}/{^$current_act^}/{^/if^}" enctype="multipart/form-data">
{^if $current_level^}
        <input type="hidden" name="menu" value="{^$current_menu^}" />
        <input type="hidden" name="act" value="{^$current_act^}" />
{^/if^}
        <input type="hidden" name="current_page" value="{^$current_page^}" />
        <div class="input_cols">
          <input type="text" id="file_name_box" value="还未选择文件" class="textbox filename_textbox bl_l" readonly />
          <label>
            <span class="ml_10 button select_button bl_l">选择文件</span>
            <input type="file" name="upload_file" id="file_upload" class="none" />
          </label>
        </div>
        <div class="input_cols">
          <label>
            <span class="ml_10 button submit_button">上传</span>
            <input type="submit" name="do_upload" value="1" class="none" />
          </label>
        </div>
      </form>
    </td>
    <td rowspan="2" class="disp_box_right" valign="top">
      <div class="file_chunk_box">
{^if empty($file_context_arr)^}
        <div class="file_chunk_cols file_chunk_hint">还未选择文件</div>
{^else^}
{^section name=idx_content loop=$file_context_arr^}
        <div class="file_chunk_cols">
          <div class="file_chunk_index">{^$smarty.section.idx_content.index+1^}</div>
          <input type="text" value="{^$file_context_arr[idx_content]^}" class="textbox file_content_textbox" />
        </div>
{^/section^}
{^/if^}
      </div>
    </td>
  </tr>
  <tr>
    <td valign="top">
{^if !empty($file_list)^}
      <div class="file_display_box">
{^section name=idx_list loop=$file_list^}
        <div class="file_display_cols{^if $file_id eq $file_list[idx_list].file_id^}_selected{^/if^}">
          <div class="file_type_box"><i class="fa {^$file_list[idx_list].file_css_text^} fa-4x"></i></div>
          <div class="file_name_box">{^$file_list[idx_list].file_name_upload^}</div>
          <div class="file_time_box">{^$file_list[idx_list].display_date^}</div>
          <div class="operate_icon_box"><a href="{^if $current_level^}{^$sys_app_host^}?menu={^$current_menu^}&act={^$current_act^}&{^else^}{^$sys_app_host^}{^$current_menu^}/{^$current_act^}/?{^/if^}page={^$current_page^}&file_id={^$file_list[idx_list].file_id^}"><i class="fa fa-arrow-circle-right fa-2x"></i></a></div>
          <div class="operate_icon_box"><a href="{^if $current_level^}{^$sys_app_host^}?menu={^$current_menu^}&act={^$current_act^}&{^else^}{^$sys_app_host^}{^$current_menu^}/{^$current_act^}/?{^/if^}download_file_id={^$file_list[idx_list].file_id^}" target="_blank"><i class="fa fa-arrow-circle-down fa-2x"></i></a></div>
        </div>
{^/section^}
      </div>
{^include file=$compagina_file^}
{^/if^}
    </td>
  </tr>
</table>
{^include file=$empfooter_file^}