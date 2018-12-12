{^if $current_level^}
{^include file=$comheader_file^}
<link rel="stylesheet" href="/tool/dummy/common.css" type="text/css" />
<script type="text/javascript" src="/tool/dummy/common.js"></script>
{^else^}
{^include file=$subheader_file^}
<link rel="stylesheet" href="common.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>
{^/if^}
<form method="post" class="disp_box">
  <div class="creat_file_box">
    <div class="disp_word disp_title">月次購入データ出力</div>
    <div class="box_cols mt_10">
      <div class="disp_word sub_disp_title bl_l">年月</div>
      <input type="text" name="start_date" value="{^$start_date^}" class="text_box bl_l" />
      <div class="disp_word sub_disp_title bl_l">コード</div>
      <select name="word_code" class="text_box word_code_list bl_l">
{^foreach from=$word_code_list key=word_code_key item=word_code_val^}
        <option value="{^$word_code_key^}">{^$word_code_val^}</option>
{^/foreach^}
      </select>
    </div>
    <div class="box_cols mt_10">
      <div class="disp_word sub_disp_title bl_l">企業ID</div>
      <input type="text" name="group_id" value="{^$group_id^}" class="text_box bl_l" />
      <div class="disp_word sub_disp_title bl_l">企業名称</div>
      <input type="text" name="group_name" value="{^$group_name^}" class="text_box bl_l" />
    </div>
    <div class="box_cols mt_10">
      <div class="disp_word sub_disp_title bl_l">店舗コード</div>
      <input type="text" name="store_code" value="{^$store_code^}" class="text_box bl_l" />
      <div class="disp_word sub_disp_title bl_l">店舗名</div>
      <input type="text" name="store_name" value="{^$store_name^}" class="text_box bl_l" />
    </div>
    <div class="box_cols mt_10">
      <label>
        <span class="disp_submit_button orange_btn"><i class="fa fa-tag"></i> 該当年月の購入データを作成する</span>
        <input type="submit" name="creat_data" value="1" class="submit_button" />
      </label>
    </div>
  </div>
  <div class="hr_line"></div>
  <div class="aggregate_box">
    <div class="disp_word disp_title">集計データ出力</div>
    <div class="box_cols mt_10 text_list_box_cols">
      <select multiple="multiple" class="text_list_box" name="data_id[]">
{^if $disp_num > 0^}
{^foreach from=$disp_list item=disp_item^}
        <option value="{^$disp_item['data_id']^}">{^$disp_item['months']^}　{^$disp_item['group_name']^}　{^$disp_item['store_name']^}　[{^$disp_item['creat_time']^}]</option>
{^/foreach^}
{^/if^}
      </select>
    </div>
    <div class="box_cols mt_10">
      <label>
        <span class="disp_submit_button orange_btn"><i class="fa fa-arrow-circle-down"></i> 集計データを出力する</span>
        <input type="submit" name="download" value="1" class="submit_button" />
      </label>
    </div>
    <div class="box_cols mt_10">
      <label>
        <span class="disp_submit_button blue_btn"><i class="fa fa-trash-o"></i> 削除する</span>
        <input type="submit" name="delete" value="1" class="submit_button" />
      </label>
    </div>
  </div>
</form>
{^include file=$empfooter_file^}