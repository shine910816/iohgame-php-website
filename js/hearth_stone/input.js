$(document).ready(function(){
    // 消耗
    $("#c_cost_minus").click(function(){
        c_cost = $("#c_cost").val();
        if (c_cost > 0) {
            $("#c_cost").val(c_cost - 1);
        }
    });
    $("#c_cost_plus").click(function(){
        c_cost = $("#c_cost").val();
        if (c_cost < 10) {
            $("#c_cost").val(parseInt(c_cost) + 1);
        }
    });
    // 攻击
    $("#c_attack_minus").click(function(){
        c_attack = $("#c_attack").val();
        if (c_attack > 0) {
            $("#c_attack").val(c_attack - 1);
        }
    });
    $("#c_attack_plus").click(function(){
        c_attack = $("#c_attack").val();
        if (c_attack < 12) {
            $("#c_attack").val(parseInt(c_attack) + 1);
        }
    });
    // 生命
    $("#c_health_minus").click(function(){
        c_health = $("#c_health").val();
        if (c_health > 0) {
            $("#c_health").val(c_health - 1);
        }
    });
    $("#c_health_plus").click(function(){
        c_health = $("#c_health").val();
        if (c_health < 12) {
            $("#c_health").val(parseInt(c_health) + 1);
        }
    });
});