{^if $test_box_disp_flg^}
<style type="text/css">
.test_box {
  width:990px;
  height:90px;
  padding:5px;
  margin:0 auto;
  border-bottom:1px solid #000;
}
</style>
<div class="test_box">
<b>Test Info</b><br/>
Current-Menu: {^$current_menu^}<br/>
Current-Action: {^$current_act^}<br/>
Auth-Level: {^$test_mode_info['auth_level']^}<br/>
User-Agent: {^$test_mode_info['user_agent']^}<br/>
</div>
{^/if^}