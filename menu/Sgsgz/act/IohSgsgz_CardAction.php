<?php

/**
 *
 * @author Kinsama
 * @version 2019-01-23
 */
class IohSgsgz_CardAction extends ActionBase
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
        $mode = "1";
        if ($request->hasParameter("mode")) {
            $mode = $request->getParameter("mode");
        }
        if (!Validate::checkAcceptParam($mode, array("1", "2", "3"))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数p_type值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("mode", $mode);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $mode = $request->getAttribute("mode");
        $card_info = array();
        if ($mode == "2") {
            $card_info = IohSgsgzCardDBI::selectExtendCard();
            if ($controller->isError($card_info)) {
                $card_info->setPos(__FILE__, __LINE__);
                return $card_info;
            }
        } elseif ($mode == "3") {
            $card_info = IohSgsgzCardDBI::selectEmperorCard();
            if ($controller->isError($card_info)) {
                $card_info->setPos(__FILE__, __LINE__);
                return $card_info;
            }
        } else {
            $card_info = IohSgsgzCardDBI::selectCommonCard();
            if ($controller->isError($card_info)) {
                $card_info->setPos(__FILE__, __LINE__);
                return $card_info;
            }
        }
        if (!empty($card_info)) {
            foreach ($card_info as $c_id => $card_item) {
                $card_info[$c_id]["suit_number"] = IohSgsgzCardEntity::getSuitNumber($card_item["c_suit"], $card_item["c_number"]);
            }
        }
        $request->setAttribute("card_info", $card_info);
        $request->setAttribute("card_count", count($card_info));
        //Utility::testVariable($card_info);
        return VIEW_DONE;
    }
}
?>