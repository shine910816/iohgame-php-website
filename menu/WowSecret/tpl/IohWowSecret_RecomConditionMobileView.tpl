{^include file=$mblheader_file^}
<link rel="stylesheet" href="css/wow/talents.css" type="text/css" />
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-iconpos="right">
  <h4>职业选择</h4>
{^foreach from=$talents_list key=classes_id item=talents_info^}
<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
  <legend>{^$classes_list[$classes_id]^}</legend>
{^foreach from=$talents_info key=talent_id item=talent_name^}
  <input type="radio" id="talent_{^$talent_id^}" name="talent_id" value="1" />
  <label for="talent_{^$talent_id^}"><div class="talent_icon talent_icon_32 talent_32_{^$talent_id^}"></div><span>{^$talent_name^}</span></label>
{^/foreach^}
</fieldset>
{^/foreach^}
</div>
{^include file=$mblfooter_file^}