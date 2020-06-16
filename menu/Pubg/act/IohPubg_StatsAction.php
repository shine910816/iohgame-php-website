<?php

/**
 *
 * @author Kinsama
 * @version 2020-06-16
 */
class IohPubg_StatsAction extends ActionBase
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
        $custom_id = $user->getCustomId();
        $account_list = IohPubgRequestDBI::getAccountId($custom_id);
        if ($controller->isError($account_list)) {
            $account_list->setPos(__FILE__, __LINE__);
            return $account_list;
        }
        if (!isset($account_list[$custom_id])) {
            $controller->redirect("./?menu=pubg&act=bind_account");
            return VIEW_DONE;
        }
        $account_id = $account_list[$custom_id]["account_id"];
        $request->setAttribute("account_id", $account_id);
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
        $account_id = $request->getAttribute("account_id");
        $pubg = Utility::getPubgRequest();
        $ranked_info = $pubg->getPlayerRankedStats($account_id);
        if ($controller->isError($ranked_info)) {
            $ranked_info->setPos(__FILE__, __LINE__);
            return $ranked_info;
        }
        $season_info = $pubg->getPlayerSeasonStats($account_id);
        if ($controller->isError($season_info)) {
            $season_info->setPos(__FILE__, __LINE__);
            return $season_info;
        }
Utility::testVariable($ranked_info);
        return VIEW_DONE;
    }
}
?>