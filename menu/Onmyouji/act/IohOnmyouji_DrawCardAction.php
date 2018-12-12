<?php

/**
 * 阴阳师抽卡预测
 * @author Kinsama
 * @version 2017-05-22
 */
class IohOnmyouji_DrawCardAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("draw_card")) {
            $ret = $this->_doDrawCardExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("view_card")) {
            $ret = $this->_doViewCardExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        return $ret;
    }

    /**
     * 执行默认主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $request->setAttribute("omj_disp_list", array());
        return VIEW_DONE;
    }

    /**
     * 执行抽卡主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doDrawCardExecute(Controller $controller, User $user, Request $request)
    {
        $xml_trans_obj = Translate::getInstance();
        $draw_card_num = $request->getAttribute("draw_card_num");
        $omj_disp_list_xml_file = SYSTEM_API_HOST . "?act=onmyouji_draw_card&draw_num=" . $draw_card_num;
        $omj_disp_list = $xml_trans_obj->transXMLToArray($omj_disp_list_xml_file);
        if ($controller->isError($omj_disp_list)) {
            $omj_disp_list->setPos(__FILE__, __LINE__);
            return $omj_disp_list;
        }
        $omj_disp_list = $omj_disp_list['result'];
        if ($draw_card_num == "1") {
            $omj_disp_list = array(
                $omj_disp_list
            );
        }
        $request->setAttribute("omj_disp_list", $omj_disp_list);
        return VIEW_DONE;
    }

    /**
     * 执行查看主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doViewCardExecute(Controller $controller, User $user, Request $request)
    {
        $s_id = null;
        if ($request->hasParameter("s_id")) {
            $s_id = $request->getParameter("s_id");
        }
        $omj_disp_list = IohOnmyoujiDBI::selectShikigamiInfo($s_id);
        if ($controller->isError($omj_disp_list)) {
            $omj_disp_list->setPos(__FILE__, __LINE__);
            return $omj_disp_list;
        }
        $skin_list = IohOnmyoujiDBI::selectShikigamiSkin();
        if ($controller->isError($skin_list)) {
            $skin_list->setPos(__FILE__, __LINE__);
            return $skin_list;
        }
        $skill_list = IohOnmyoujiDBI::selectShikigamiSkill();
        if ($controller->isError($skill_list)) {
            $skill_list->setPos(__FILE__, __LINE__);
            return $skill_list;
        }
        foreach ($omj_disp_list as $s_id => $info_item) {
            $skin_arr = array();
            $skill_arr = array();
            if (isset($skin_list[$s_id])) {
                $skin_arr = $skin_list[$s_id];
            }
            if (isset($skill_list[$s_id])) {
                $skill_arr = $skill_list[$s_id];
            }
            $omj_disp_list[$s_id]['skin'] = $skin_arr;
            $omj_disp_list[$s_id]['skill'] = $skill_arr;
        }
        $request->setAttribute("omj_disp_list", $omj_disp_list);
        return VIEW_DONE;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $draw_card_num = 0;
        if ($request->hasParameter("draw_card")) {
            $draw_card_num = $request->getParameter("draw_card");
            if (!Validate::checkAcceptParam($draw_card_num, array(
                "1",
                "5",
                "10"
            ))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "draw_card_num = " . $draw_card_num);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        if ($request->hasParameter("view_card")) {
            $draw_card_num = 99;
        }
        $request->setAttribute("draw_card_num", $draw_card_num);
        return VIEW_DONE;
    }
}
?>