<?php

/**
 * 阴阳师抽卡预测
 * @author Kinsama
 * @version 2017-05-22
 */
class IohUsrApi_OnmyoujiDrawCardAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $info = array();
        $res = IohOnmyoujiDBI::selectDrawCardInfo();
        if ($controller->isError($res)) {
            $res->setPos(__FILE__, __LINE__);
            return $res;
        }
        foreach ($res as $s_id => $s_info) {
            $s_level = "";
            if ($s_info['s_level'] == "1") {
                $s_level = "r";
            } elseif ($s_info['s_level'] == "2") {
                $s_level = "sr";
            } elseif ($s_info['s_level'] == "3") {
                $s_level = "ssr";
            } else {
                $s_level = "n";
            }
            $info[$s_level][] = $s_info;
        }
        $draw_num = $request->getAttribute("draw_num");
        $omj_disp_list = array();
        for ($idx = 0; $idx < $draw_num; $idx++) {
            $level_random_num = rand(1, 100);
            $s_level = "";
            if ($draw_num == 5) {
                if ($level_random_num > 87) {
                    $s_level = "r";
                } else {
                    $s_level = "n";
                }
            } else {
                if ($level_random_num == 100) {
                    $s_level = "ssr";
                } elseif ($level_random_num <= 79) {
                    $s_level = "r";
                } else {
                    $s_level = "sr";
                }
            }
            // $s_level = "ssr";
            $s_random_list = $info[$s_level];
            $max_index_num = count($s_random_list) - 1;
            $s_index = rand(0, $max_index_num);
            // $s_index = "12";
            $omj_disp_list[$idx] = $s_random_list[$s_index];
        }
        return $omj_disp_list;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $draw_num = 10;
        if ($request->hasParameter("draw_num")) {
            $draw_num = $request->getParameter("draw_num");
        }
        if (!Validate::checkAcceptParam($draw_num, array(
            1,
            5,
            10
        ))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "draw_num = " . $draw_num);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("draw_num", $draw_num);
        return VIEW_DONE;
    }
}
?>