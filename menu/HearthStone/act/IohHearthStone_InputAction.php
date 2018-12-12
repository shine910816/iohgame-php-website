<?php

/**
 * 炉石传说卡牌录入编辑画面
 * @author Kinsama
 * @version 2017-01-09
 */
class IohHearthStone_InputAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("execute")) {
            $ret = $this->_doInputExecute($controller, $user, $request);
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
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $c_id = $request->getAttribute("c_id");
        $edit_mode = $request->getAttribute("edit_mode");
        if ($edit_mode) {
            $card_info_tmp = IohHearthStoneCardDBI::getCardInfoByCId($c_id);
            if ($controller->isError($card_info_tmp)) {
                $card_info_tmp->setPos(__FILE__, __LINE__);
                return $card_info_tmp;
            }
            if (!isset($card_info_tmp[$c_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数c_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $card_info = $card_info_tmp[$c_id];
        } else {
            // SESSION中取得上次录入的内容
            $before_input = array();
            if ($user->hasVariable("before_input")) {
                $before_input = $user->getVariable("before_input");
                $user->freeVariable("before_input");
            }
            // 基本值取得
            $code_list = IohHearthStoneCardEntity::getCodeList();
            $c_from_code_list = array_keys($code_list['c_from']);
            $c_from_max_index = count($c_from_code_list) - 1;
            $column_name_list = IohHearthStoneCardEntity::getNotNullVolumnName();
            // 整理卡牌信息
            $card_info = array(
                'c_id' => $c_id,
                'c_mode' => "0",
                'c_class' => isset($before_input['c_class']) ? $before_input['c_class'] : IohHearthStoneCardEntity::CLASS_DRUID,
                'c_type' => "1",
                'c_cost' => isset($before_input['c_cost']) ? $before_input['c_cost'] : 0,
                'c_name' => "",
                'c_quality' => isset($before_input['c_quality']) ? $before_input['c_quality'] : IohHearthStoneCardEntity::QUALITY_COMMON,
                'c_attack' => "0",
                'c_health' => "0",
                'c_minion' => "0",
                'c_group' => "0",
                'c_descript' => "",
                'c_funny' => "",
                'c_from' => isset($before_input['c_from']) ? $before_input['c_from'] : $c_from_code_list[$c_from_max_index]
            );
            foreach ($column_name_list['keyword'] as $column_name) {
                $card_info[$column_name] = "0";
            }
        }
        $request->setAttribute("card_info", $card_info);
        // 标题导航栏设定
        $page_titles = "新卡录入";
        $c_name = $card_info['c_name'];
        if ($c_name != "") {
            $page_titles = $c_name;
        }
        $request->setAttribute("page_titles", $page_titles);
        return VIEW_DONE;
    }

    /**
     * 执行卡牌录入程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doInputExecute(Controller $controller, User $user, Request $request)
    {
        $c_id = $request->getAttribute("c_id");
        $edit_mode = $request->getAttribute("edit_mode");
        $card_info = $request->getAttribute("card_info");
        if ($edit_mode == "1") {
            unset($card_info['c_id']);
            $update_res = IohHearthStoneCardDBI::updateCard($c_id, $card_info);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
            $controller->redirect("./?menu=hearth_stone&act=admin_list&c_class=" . $card_info['c_class']);
            // 管理员卡牌一览画面作成后，跳转到该画面
        } else {
            $user->setVariable("before_input", array(
                "c_class" => $card_info['c_class'],
                "c_cost" => $card_info['c_cost'],
                "c_quality" => $card_info['c_quality'],
                "c_from" => $card_info['c_from']
            ));
            $insert_res = IohHearthStoneCardDBI::insertCard($card_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
            $controller->redirect("./?menu=hearth_stone&act=input#start_table");
        }
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
        // 编辑模式
        if ($request->hasParameter("edit_mode")) {
            $edit_mode = $request->getParameter("edit_mode");
            if (!$request->hasParameter("c_id")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数c_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $c_id = $request->getParameter("c_id");
        } else {
            $edit_mode = "0";
            $c_id = IohHearthStoneCardDBI::getNextCId();
            if ($controller->isError($c_id)) {
                $c_id->setPos(__FILE__, __LINE__);
                return $c_id;
            }
        }
        $request->setAttribute("c_id", $c_id);
        $request->setAttribute("edit_mode", $edit_mode);
        // 数据整理
        if ($request->hasParameter("execute")) {
            foreach ($volumn_name['info'] as $info_key) {
                if ($info_key == "c_mode") {
                    if ($request->hasParameter("c_mode")) {
                        $data[$info_key] = "1";
                    } else {
                        $data[$info_key] = "0";
                    }
                } else {
                    $data[$info_key] = $request->getParameter($info_key);
                }
            }
            foreach ($volumn_name['keyword'] as $keyword_key) {
                if ($request->hasParameter($keyword_key)) {
                    $data[$keyword_key] = "1";
                } else {
                    $data[$keyword_key] = "0";
                }
            }
            $request->setAttribute("card_info", $data);
        }
        return VIEW_DONE;
    }
}
?>