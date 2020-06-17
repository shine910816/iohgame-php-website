{^include file=$mblheader_file^}
<div data-role="tabs" id="tabs">
  <div data-role="navbar">
    <ul>
      <li><a href="#season" data-ajax="false">休闲模式</a></li>
      <li><a href="#ranked" data-ajax="false">竞技模式</a></li>
    </ul>
  </div>
  <div id="season" class="ui-body-d ui-content">
    <div data-role="tabs" id="season_tabs">
      <div data-role="navbar">
        <ul>
          <li><a href="#season-tpp" data-ajax="false">TPP</a></li>
          <li><a href="#season-fpp" data-ajax="false">FPP</a></li>
        </ul>
      </div>
      <div id="season-tpp" class="ui-body-d ui-content">
        <h3>休闲-TPP</h3>
      </div>
      <div id="season-fpp" class="ui-body-d ui-content">
        <h3>休闲-FPP</h3>
      </div>
    </div>
  </div>
  <div id="ranked" class="ui-body-d ui-content">
    <div data-role="tabs" id="season_tabs">
      <div data-role="navbar">
        <ul>
          <li><a href="#ranked-tpp" data-ajax="false">TPP</a></li>
          <li><a href="#ranked-fpp" data-ajax="false">FPP</a></li>
        </ul>
      </div>
      <div id="ranked-tpp" class="ui-body-d ui-content">
        <h3>竞技-TPP</h3>
      </div>
      <div id="ranked-fpp" class="ui-body-d ui-content">
        <h3>竞技-FPP</h3>
      </div>
    </div>
  </div>
</div>
{^include file=$mblfooter_file^}