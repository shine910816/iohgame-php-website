<?php

/**
 *
 * @author Kinsama
 * @version 2020-06-16
 */
class IohPubg_BindAccountAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_submit")) {
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
        $custom_id = $user->getCustomId();
        $account_list = IohPubgRequestDBI::getAccountId($custom_id);
        if ($controller->isError($account_list)) {
            $account_list->setPos(__FILE__, __LINE__);
            return $account_list;
        }
        $player_name = "";
        $account_id = "";
        $update_flg = false;
        if (isset($account_list[$custom_id])) {
            $player_name = $account_list[$custom_id]["player_name"];
            $account_id = $account_list[$custom_id]["account_id"];
            $update_flg = true;
        }
        if ($request->hasParameter("do_submit")) {
            $update_flg = $request->getParameter("mode") == "1" ? true : false;
            $player_name = $request->getParameter("player_name");
            $pubg_request = Utility::getPubgRequest();
            $pubg_res = $pubg_request->getPlayersByNames($player_name);
            if ($controller->isError($pubg_res)) {
                $pubg_res->setPos(__FILE__, __LINE__);
                return $pubg_res;
            }
            if (!isset($pubg_res["data"])) {
                $request->setError("player_name", "找不到当前游戏角色");
            } else {
                foreach ($pubg_res["data"] as $player_info) {
                    if ($player_info["attributes"]["name"] == $player_name) {
                        $account_id = $player_info["id"];
                        break;
                    } else {
                        continue;
                    }
                }
            }
            if ($account_id == "") {
                $request->setError("player_name", "找不到当前游戏角色");
            }
        }
        $request->setAttribute("update_flg", $update_flg);
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("player_name", $player_name);
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
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $update_flg = $request->getAttribute("update_flg");
        $custom_id = $request->getAttribute("custom_id");
        $player_name = $request->getAttribute("player_name");
        $account_id = $request->getAttribute("account_id");
        $data_array = array(
            "player_name" => $player_name,
            "account_id" => $account_id
        );
        if ($update_flg) {
            $update_res = IohPubgRequestDBI::updatePlayerAccount($data_array, "custom_id = " . $custom_id);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        } else {
            $data_array["custom_id"] = $custom_id;
            $insert_res = IohPubgRequestDBI::insertPlayerAccount($data_array);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
        }
        $controller->redirect("./?menu=pubg&act=stats");
        return VIEW_DONE;
    }
}
?>