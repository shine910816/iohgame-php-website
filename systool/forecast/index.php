<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>孩子未来身高预测</title>
<link type="text/css" rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#confirm").click(function(){
        var fa = parseInt($("#fa").val());
        var mo = parseInt($("#mo").val());
        var gender = $("input[name='gender']:checked").val();
        var height = 0;
        if (gender == "1") {
            height = Math.round((fa + mo) * 0.54);
        } else {
            height = Math.round(((fa * 0.923) + mo) / 2);
        }
        $("#height").val(height);
    });
});
</script>
</head>
<body>
<div data-role="content">
  <div class="ui-body ui-body-a ui-corner-all">
    <h4>孩子未来身高预测</h4>
    <label for="fa">父亲身高</label>
    <input type="range" id="fa" value="170" min="140" max="200" />
    <label for="mo">母亲身高</label>
    <input type="range" id="mo" value="160" min="130" max="190" />
    <fieldset data-role="controlgroup" data-type="horizontal">
      <legend>孩子性别</legend>
      <input type="radio" name="gender" id="gender_male" value="1" checked="checked" />
      <label for="gender_male">男</label>
      <input type="radio" name="gender" id="gender_female" value="0" />
      <label for="gender_female">女</label>
    </fieldset>
    <input type="button" id="confirm" value="确定" class="ui-btn" />
    <label for="height">预测值</label>
    <input type="text" id="height" value="178" readonly />
  </div>
</div>
</body>
</html>
