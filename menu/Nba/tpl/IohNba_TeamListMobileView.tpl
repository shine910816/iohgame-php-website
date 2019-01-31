{^include file=$mblheader_file^}
<a href="./?menu=nba&act=team_list" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "0"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">全联盟</a>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=team_list&conf=1" class="ui-btn ui-btn-{^if $conference eq "1" and $division eq "0"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$conf_list["cn"][1]^}</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=team_list&conf=2" class="ui-btn ui-btn-{^if $conference eq "2" and $division eq "0"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$conf_list["cn"][2]^}</a></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a"><a href="./?menu=nba&act=team_list&divi=1" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "1"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][1]^}</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=team_list&divi=2" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "2"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][2]^}</a></div>
  <div class="ui-block-c"><a href="./?menu=nba&act=team_list&divi=3" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "3"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][3]^}</a></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a"><a href="./?menu=nba&act=team_list&divi=4" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "4"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][4]^}</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=team_list&divi=5" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "5"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][5]^}</a></div>
  <div class="ui-block-c"><a href="./?menu=nba&act=team_list&divi=6" class="ui-btn ui-btn-{^if $conference eq "0" and $division eq "6"^}b{^else^}a{^/if^} ui-corner-all ui-shadow" data-ajax="false">{^$divi_list["cn"][6]^}</a></div>
</fieldset>
{^if !empty($team_list)^}
{^foreach from=$team_list item=team_item^}
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-collapsed="false" data-iconpos="right">
  <h4>{^$team_item["t_name_short"]^}</h4>
  <div style="width:100%; height:309px;">
    <img src="https://china.nba.com/media/img/teams/logos/{^$team_item["t_name_short"]^}_logo.svg" style="width:309px; height:309px; margin:0 auto;"/>
  </div
  <p>{^$team_item["t_city_cn"]^} {^$team_item["t_name_cn"]^}</p>
  <p>{^$team_item["t_name"]^}</p>
  <p>{^$team_item["t_city_ja"]^}·{^$team_item["t_name_ja"]^}</p>
  <hr/>
  <p>{^$conf_list["cn"][$team_item["t_conference"]]^} / {^$divi_list["cn"][$team_item["t_division"]]^}</p>
  <p>{^$conf_list["en"][$team_item["t_conference"]]^} / {^$divi_list["en"][$team_item["t_division"]]^}</p>
  <p>{^$conf_list["ja"][$team_item["t_conference"]]^} / {^$divi_list["ja"][$team_item["t_division"]]^}</p>
</div>
{^/foreach^}
{^/if^}
{^include file=$mblfooter_file^}