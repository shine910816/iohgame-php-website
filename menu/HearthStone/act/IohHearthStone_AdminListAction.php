<?php

/**
 * 炉石传说卡牌管理员一览画面
 * @author Kinsama
 * @version 2017-03-06
 */
class IohHearthStone_AdminListAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        return $ret;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        // 公共信息
        $code_list = IohHearthStoneCardEntity::getCodeList();
        $request->setAttribute("c_class_list", $code_list['c_class']);
        $request->setAttribute("c_quality_list", $code_list['c_quality']);
        $request->setAttribute("c_minion_list", $code_list['c_minion']);
        $request->setAttribute("c_from_list", $code_list['c_from']);
        $request->setAttribute("c_group_list", $code_list['c_group']);
        $request->setAttribute("c_type_list", $code_list['c_type']);
        $color_list = IohHearthStoneCardEntity::getColorList();
        $request->setAttribute("c_class_color_list", $color_list['c_class']);
        $request->setAttribute("c_quality_color_list", $color_list['c_quality']);
        $request->setAttribute("volumn_name_list", IohHearthStoneCardEntity::getVolumnName());
        $volumn_name = IohHearthStoneCardEntity::getNotNullVolumnName();
        $request->setAttribute("c_keyword_list", $volumn_name['keyword']);
        // 画面信息
        $c_class = IohHearthStoneCardEntity::CLASS_DRUID;
        if ($request->hasParameter("c_class")) {
            $c_class = $request->getParameter("c_class");
        }
        $disp_mode = "0";
        if ($request->hasParameter("disp_mode")) {
            $disp_mode = $request->getParameter("disp_mode");
        }
        $code_list = IohHearthStoneCardEntity::getCodeList();
        if (!Validate::checkAcceptParam($c_class, array_keys($code_list['c_class']))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数c_class值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!Validate::checkAcceptParam($disp_mode, array(
            "0",
            "1"
        ))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数disp_mode值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("c_class", $c_class);
        $request->setAttribute("disp_mode", $disp_mode);
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $c_class = $request->getAttribute("c_class");
        $disp_mode = $request->getAttribute("disp_mode");
        $card_info = IohHearthStoneCardDBI::getCardInfoByCClassForAdminList($c_class, $disp_mode);
        if ($controller->isError($card_info)) {
            $card_info->setPos(__FILE__, __LINE__);
            return $card_info;
        }
        if (!empty($card_info)) {
            foreach ($card_info as $c_id => $c_info) {
                $card_info[$c_id]["c_descript"] = Utility::transContext($c_info["c_descript"]);
            }
        }
        $request->setAttribute("card_info", $card_info);
        return VIEW_DONE;
    }
}
?>