<?php

/**
 * 社区好友查询
 * @author Kinsama
 * @version 2019-08-06
 */
class IohUsrApi_FriendListAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        header("Content-type:text/plain; charset=utf-8");
        $result = array(
            "error" => 0,
            "err_msg" => ""
        );
        $exec_result = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($exec_result)) {
            $exec_result->setPos(__FILE__, __LINE__);
            $error_message = "";
            if ($exec_result->err_code == ERROR_CODE_DATABASE_RESULT) {
                $error_message = "Database error";
            } else {
                $error_message = $exec_result->getMessage();
            }
            $result["error"] = 1;
            $result["err_msg"] = $error_message;
            $exec_result->writeLog();
        } else {
            $result["data"] = $exec_result;
        }
        echo json_encode($result);
        exit;
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
        $result = array(
            "login" => "1",
            "list" => array(
                0 => array(),
                1 => array(),
                2 => array(),
            )
        );
        if (!$user->isLogin()) {
            $result["login"] = "0";
            return $result;
        }
        $custom_id = $user->getCustomId();
        $follower_list = IohCustomDBI::selectFollower($custom_id);
        if ($controller->isError($follower_list)) {
            $follower_list->setPos(__FILE__, __LINE__);
            return $follower_list;
        }
        $follow_list = array();
        $fan_list = array();
        $friend_list = array();
        foreach ($follower_list as $f_info) {
            if ($f_info["custom_id"] == $custom_id) {
                $follow_list[$f_info["v_custom_id"]] = $f_info["v_custom_id"];
            }
            if ($f_info["v_custom_id"] == $custom_id) {
                $fan_list[$f_info["custom_id"]] = $f_info["custom_id"];
            }
        }
        if (!empty($follow_list) && !empty($fan_list)) {
            foreach ($follow_list as $tmp_id => $tmp_info) {
                if (isset($fan_list[$tmp_id])) {
                    $friend_list[$tmp_id] = $tmp_id;
                }
            }
        }
        if (!empty($friend_list)) {
            $result["list"][0] = array_keys($friend_list);
        }
        if (!empty($follow_list)) {
            $result["list"][1] = array_keys($follow_list);
        }
        if (!empty($fan_list)) {
            $result["list"][2] = array_keys($fan_list);
        }
        return $result;
    }
}
?>