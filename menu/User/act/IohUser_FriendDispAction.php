<?php

/**
 * 用户好友一览画面
 * @author Kinsama
 * @version 2017-01-20
 */
class IohUser_FriendDispAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("friend_confirm")) {
            $ret = $this->_doFriendConfirmExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("friend_refuse")) {
            $ret = $this->_doFriendRefuseExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("close_remove")) {
            $ret = $this->_doCloseRemoveExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("close_add")) {
            $ret = $this->_doCloseAddExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("black_add")) {
            $ret = $this->_doBlackAddExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("friend_remove")) {
            $ret = $this->_doFriendRemoveExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("black_remove")) {
            $ret = $this->_doBlackRemoveExecute($controller, $user, $request);
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
        $cus_id = $user->getVariable("cus_id");
        $disp_mode = $request->getAttribute("disp_mode");
        $wait_friend_list = array();
        $disp_friend_list = array();
        $disp_cus_id_list = array();
        $custom_info = array();
        if ($disp_mode == "2") {
            $disp_cus_id_list = IohCFriendDBI::getBlackList($cus_id);
            if ($controller->isError($disp_cus_id_list)) {
                $disp_cus_id_list->setPos(__FILE__, __LINE__);
                return $disp_cus_id_list;
            }
        } else {
            $wait_friend_list = IohCFriendDBI::getWaitFriendList($cus_id);
            if ($controller->isError($wait_friend_list)) {
                $wait_friend_list->setPos(__FILE__, __LINE__);
                return $wait_friend_list;
            }
            if (!empty($wait_friend_list)) {
                foreach ($wait_friend_list as $wait_friend_list_item) {
                    $disp_cus_id_list[$wait_friend_list_item['friend_id']] = $wait_friend_list_item['cus_id'];
                }
            }
            $disp_friend_list = IohCFriendDBI::getFriendList($cus_id);
            if ($controller->isError($disp_friend_list)) {
                $disp_friend_list->setPos(__FILE__, __LINE__);
                return $disp_friend_list;
            }
            if (!empty($disp_friend_list)) {
                foreach ($disp_friend_list as $disp_friend_list_item) {
                    $disp_cus_id_list[$disp_friend_list_item['friend_id']] = $disp_friend_list_item['oppo_cus_id'];
                }
            }
        }
        if (!empty($disp_cus_id_list)) {
            $custom_info = IohCustomerDBI::getCustomLoginInfoByCusId($disp_cus_id_list);
            if ($controller->isError($custom_info)) {
                $custom_info->setPos(__FILE__, __LINE__);
                return $custom_info;
            }
        }
        $request->setAttribute("wait_friend_list", $wait_friend_list);
        $request->setAttribute("wait_friend_num", count($wait_friend_list));
        $request->setAttribute("disp_friend_list", $disp_friend_list);
        $request->setAttribute("disp_cus_id_list", $disp_cus_id_list);
        $request->setAttribute("custom_info", $custom_info);
        return VIEW_DONE;
    }

    /**
     * 执行好友确认操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doFriendConfirmExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $friend_info = $request->getAttribute("friend_info");
        $cus_id = $user->getVariable("cus_id");
        $oppo_cus_id = $friend_info['cus_id'];
        $dbi = Database::getInstance();
        // 开始事件
        $begin_res = $dbi->begin();
        if ($controller->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 更改对方的好友状态为一般好友
        $upd_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "friend_status" => IohCFriendEntity::FRIEND_STATUS_COMMON
        ));
        if ($controller->isError($upd_res)) {
            $dbi->rollback();
            $upd_res->setPos(__FILE__, __LINE__);
            return $upd_res;
        }
        // 添加对方为一般好友
        $add_res = IohCFriendDBI::addCFriend($cus_id, $oppo_cus_id, IohCFriendEntity::FRIEND_STATUS_COMMON);
        if ($controller->isError($add_res)) {
            $dbi->rollback();
            $add_res->setPos(__FILE__, __LINE__);
            return $add_res;
        }
        // 提交事件
        $commit_res = $dbi->commit();
        if ($controller->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行好友拒绝操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doFriendRefuseExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $upd_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "del_flg" => 1
        ));
        if ($controller->isError($upd_res)) {
            $upd_res->setPos(__FILE__, __LINE__);
            return $upd_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行移除亲密好友操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doCloseRemoveExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $upd_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "friend_status" => IohCFriendEntity::FRIEND_STATUS_COMMON
        ));
        if ($controller->isError($upd_res)) {
            $upd_res->setPos(__FILE__, __LINE__);
            return $upd_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行添加亲密好友操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doCloseAddExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $upd_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "friend_status" => IohCFriendEntity::FRIEND_STATUS_CLOSE
        ));
        if ($controller->isError($upd_res)) {
            $upd_res->setPos(__FILE__, __LINE__);
            return $upd_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行添加黑名单操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doBlackAddExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $friend_info = $request->getAttribute("friend_info");
        $cus_id = $user->getVariable("cus_id");
        $oppo_cus_id = $friend_info['oppo_cus_id'];
        $dbi = Database::getInstance();
        // 开始事件
        $begin_res = $dbi->begin();
        if ($controller->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 更改对方的好友状态
        $friend_oppo_id = IohCFriendDBI::getFriendIdByDouble($oppo_cus_id, $cus_id);
        if ($controller->isError($friend_oppo_id)) {
            $dbi->rollback();
            $friend_oppo_id->setPos(__FILE__, __LINE__);
            return $friend_oppo_id;
        }
        if ($friend_oppo_id === false) {
            $dbi->rollback();
            $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $upd_oppo_res = IohCFriendDBI::changeCFriend($friend_oppo_id, array(
            "del_flg" => 1
        ));
        if ($controller->isError($upd_oppo_res)) {
            $dbi->rollback();
            $upd_oppo_res->setPos(__FILE__, __LINE__);
            return $upd_oppo_res;
        }
        // 添加对方为黑名单
        $upd_self_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "friend_status" => IohCFriendEntity::FRIEND_STATUS_BLACK
        ));
        if ($controller->isError($upd_self_res)) {
            $dbi->rollback();
            $upd_self_res->setPos(__FILE__, __LINE__);
            return $upd_self_res;
        }
        // 提交事件
        $commit_res = $dbi->commit();
        if ($controller->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行移除好友操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doFriendRemoveExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $friend_info = $request->getAttribute("friend_info");
        $cus_id = $user->getVariable("cus_id");
        $oppo_cus_id = $friend_info['oppo_cus_id'];
        $dbi = Database::getInstance();
        // 开始事件
        $begin_res = $dbi->begin();
        if ($controller->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 更改对方的好友状态
        $friend_oppo_id = IohCFriendDBI::getFriendIdByDouble($oppo_cus_id, $cus_id);
        if ($controller->isError($friend_oppo_id)) {
            $dbi->rollback();
            $friend_oppo_id->setPos(__FILE__, __LINE__);
            return $friend_oppo_id;
        }
        if ($friend_oppo_id === false) {
            $dbi->rollback();
            $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $upd_oppo_res = IohCFriendDBI::changeCFriend($friend_oppo_id, array(
            "del_flg" => 1
        ));
        if ($controller->isError($upd_oppo_res)) {
            $dbi->rollback();
            $upd_oppo_res->setPos(__FILE__, __LINE__);
            return $upd_oppo_res;
        }
        // 移除对方
        $upd_self_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "del_flg" => 1
        ));
        if ($controller->isError($upd_self_res)) {
            $dbi->rollback();
            $upd_self_res->setPos(__FILE__, __LINE__);
            return $upd_self_res;
        }
        // 提交事件
        $commit_res = $dbi->commit();
        if ($controller->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行移除黑名单操作主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doBlackRemoveExecute(Controller $controller, User $user, Request $request)
    {
        $friend_id = $request->getAttribute("friend_id");
        $upd_res = IohCFriendDBI::changeCFriend($friend_id, array(
            "del_flg" => 1
        ));
        if ($controller->isError($upd_res)) {
            $upd_res->setPos(__FILE__, __LINE__);
            return $upd_res;
        }
        $controller->redirect($request->getAttribute("a_href_url"));
        return VIEW_NONE;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $disp_switch_list = array(
            "1" => "好友",
            "2" => "黑名单"
        );
        $disp_mode = "1";
        if ($request->hasParameter("disp_mode")) {
            $disp_mode = $request->getParameter("disp_mode");
        }
        if (!Validate::checkAcceptParam($disp_mode, array_keys($disp_switch_list))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数disp_mode值被窜改为" . $disp_mode);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("disp_switch_list", $disp_switch_list);
        $request->setAttribute("disp_mode", $disp_mode);
        $request->setAttribute("a_href_url", "./?menu=user&act=friend_disp&disp_mode=" . $disp_mode);
        $friend_id = "";
        $friend_status = "0";
        $friend_info = array();
        if ($request->hasParameter("friend_id")) {
            $friend_id = $request->getParameter("friend_id");
            if (!Validate::checkNotNull($friend_id)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数friend_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (!Validate::checkNumber($friend_id)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数friend_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $friend_info = IohCFriendDBI::getCFriendInfo($friend_id);
            if ($controller->isError($friend_info)) {
                $friend_info->setPos(__FILE__, __LINE__);
                return $friend_info;
            }
            if (!isset($friend_info[$friend_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数friend_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $friend_info = $friend_info[$friend_id];
            $friend_status = $friend_info["friend_status"];
            if (($request->hasParameter("friend_confirm") && $friend_status != IohCFriendEntity::FRIEND_STATUS_WAIT) || ($request->hasParameter("friend_refuse") && $friend_status != IohCFriendEntity::FRIEND_STATUS_WAIT) || ($request->hasParameter("close_remove") && $friend_status != IohCFriendEntity::FRIEND_STATUS_CLOSE) || ($request->hasParameter("close_add") && $friend_status != IohCFriendEntity::FRIEND_STATUS_COMMON) || ($request->hasParameter("black_add") && $friend_status != IohCFriendEntity::FRIEND_STATUS_COMMON) || ($request->hasParameter("friend_remove") && $friend_status != IohCFriendEntity::FRIEND_STATUS_COMMON) || ($request->hasParameter("black_remove") && $friend_status != IohCFriendEntity::FRIEND_STATUS_BLACK)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数friend_id值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $request->setAttribute("friend_id", $friend_id);
        $request->setAttribute("friend_info", $friend_info);
        return VIEW_DONE;
    }
}
?>