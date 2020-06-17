{^include file=$mblheader_file^}
<a href="./?menu=pubg&act=stats{^if !$fpp_flg^}&fpp_mode=1{^/if^}" class="ui-btn ui-corner-all ui-btn-{^if $fpp_flg^}b{^else^}a{^/if^}" data-ajax="false">FPP</a>
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-collapsed="false">
  <h4>技术统计</h4>
  <div data-role="tabs" id="tabs">
    <div data-role="navbar">
      <ul>
        <li><a href="#season" data-ajax="false">休闲模式</a></li>
        <li><a href="#ranked" data-ajax="false">竞技模式</a></li>
      </ul>
    </div>
    <div id="season" class="ui-body-d ui-content">
    </div>
    <div id="ranked" class="ui-body-d ui-content">
    </div>
  </div>
</div>
<a href="./?menu=pubg&act=bind_account" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">修改绑定角色</a>
{^include file=$mblfooter_file^}