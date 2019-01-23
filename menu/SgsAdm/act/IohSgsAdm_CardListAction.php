<?php

/**
 *
 * @author Kinsama
 * @version 2019-01-23
 */
class IohSgsAdm_CardListAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_submit")) {
            $ret = $this->_doSubmitExecute($controller, $user, $request);
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
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $card_info = IohSgsgzCardDBI::selectCard();
        if ($controller->isError($card_info)) {
            $card_info->setPos(__FILE__, __LINE__);
            return $card_info;
        }
        $card_type_info = IohSgsgzCardDBI::selectCardType();
        if ($controller->isError($card_type_info)) {
            $card_type_info->setPos(__FILE__, __LINE__);
            return $card_type_info;
        }
        $card_type_list = IohSgsgzCardEntity::getCardTypeList();
        foreach ($card_info as $c_id => $card_info_item) {
            $card_info[$c_id]["suit_number"] = IohSgsgzCardEntity::getSuitNumber($card_info_item["c_suit"], $card_info_item["c_number"]);
            $select_content = "<option value=\"0\">未选择</option>";
            
            foreach ($card_type_info as $card_type => $card_info_list) {
                $select_content .= sprintf('<optgroup label="%s">', $card_type_list[$card_type]);
                foreach ($card_info_list as $card_id => $card_type_info_item) {
                    $selected_text = "";
                    if ($card_info_item["card_id_1"] == $card_id) {
                        $selected_text = " selected";
                    }
                    $select_content .= sprintf('<option value="%s"%s>%s</option>', $card_id, $selected_text, $card_type_info_item["card_name"]);
                }
                $select_content .= "</optgroup>";
            }
            
            $card_info[$c_id]["content"] = $select_content;
        }
        $request->setAttribute("card_info", $card_info);
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $card_info = $request->getParameter("card_info");
        foreach ($card_info as $c_id => $card_id_1) {
            $update_arr = array(
                "card_id_1" => $card_id_1
            );
            $update_res = IohSgsgzCardDBI::updateCard($c_id, $update_arr);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        }
        $controller->redirect("./?menu=sgs_adm&act=card_list");
    }
}
?>