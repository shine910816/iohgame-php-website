{^include file=$mblheader_file^}
{^foreach from=$talents_list key=classes_id item=talents_info^}
<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
  <legend>{^$classes_list[$classes_id]^}</legend>
{^foreach from=$talents_info key=talent_id item=talent_name^}
  <input type="radio" id="talent_{^$talent_id^}" name="talent_id" value="1" />
  <label for="talent_{^$talent_id^}">{^$talent_name^}</label>
{^/foreach^}
</fieldset>
{^/foreach^}
{^include file=$mblfooter_file^}