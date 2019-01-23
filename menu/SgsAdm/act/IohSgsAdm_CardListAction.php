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
        Utility::testVariable($card_info);
        return VIEW_DONE;
    }
}
?>