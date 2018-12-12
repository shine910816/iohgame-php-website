/**
 * 获取ObjectID
 */
var setObjectId = function(lang){
    var api_url = "./api/?act=object_id";
    if (lang == "en") {
        api_url += "&lang=1";
    }
    if (lang == "ja") {
        api_url += "&lang=2";
    }
    var object_id_json = $.ajax({url:api_url,async:false}).responseText;
    var option = eval('(' + object_id_json + ')');
    for (idx in option) {
        var dom_selector = "*[data-object-id='" + idx + "']";
        if ($(dom_selector).length > 0) {
            var dom = $(dom_selector);
            switch (dom[0].tagName) {
            case "SPAN":
            case "A":
                dom.empty().html(option[idx]);
                break;
            case "INPUT":
                dom.val(option[idx]);
                break;
            }
        }
    }
};
$(document).ready(function(){
    setObjectId(m_language_selected);
    $("a.language-selected").click(function(){
        setObjectId($(this).data("language"));
    });
});