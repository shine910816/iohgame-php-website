<?php

/**
 * 管理员用站内活动详细画面
 * @author Kinsama
 * @version 2019-01-02
 */
class IohEvent_AdminDetailAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("check")) {
            $ret = $this->_doCheckExecute($controller, $user, $request);
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
        $new_event_flg = true;
        if ($request->hasParameter("edit_event_id")) {
            $event_info = IohEventDBI::selectEventById($request->getParameter("edit_event_id"));
            if ($controller->isError($event_info)) {
                $event_info->setPos(__FILE__, __LINE__);
                return $event_info;
            }
            if (!isset($event_info[$request->getParameter("edit_event_id")])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $event_info = $event_info[$request->getParameter("edit_event_id")];
            $event_start_date_arr = explode(" ", $event_info["event_start_date"]);
            $event_expiry_date_arr = explode(" ", $event_info["event_expiry_date"]);
            $event_info["event_start_date"] = $event_start_date_arr[0];
            $event_info["event_expiry_date"] = $event_expiry_date_arr[0];
            $new_event_flg = false;
        } else {
            $event_info = array(
                "event_id" => "0",
                "event_key" => "",
                "event_number" => "",
                "event_name" => "",
                "event_descript" => "",
                "event_start_date" => date("Y-m-d"),
                "event_expiry_date" => date("Y-m-d"),
                "event_open_flg" => "0",
                "event_active_url" => "",
                "event_active_name" => "前往参与活动"
            );
        }
        $request->setAttribute("event_info", $event_info);
        $request->setAttribute("new_event_flg", $new_event_flg);
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

    private function _doCheckExecute(Controller $controller, User $user, Request $request)
    {
        header("Content-type:text/plain; charset=utf-8");
        $result = array(
            "error" => 0,
            "err_msg" => "",
            "event_number" => ""
        );
        if (strlen($request->getParameter("check")) == 0) {
            $result["error"] = 1;
            $result["err_msg"] = "活动关键字不能为空";
            echo json_encode($result);
            exit;
        }
        $event_number = $this->_getTransWord($request->getParameter("check"));
        $event_info = IohEventDBI::selectEventByNumber($event_number);
        if ($controller->isError($event_info)) {
            $event_info->setPos(__FILE__, __LINE__);
            $event_info->writeLog();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            echo json_encode($result);
            exit;
        }
        if (count($event_info) > 0) {
            $result["error"] = 1;
            $result["err_msg"] = "活动关键字已占用";
            echo json_encode($result);
            exit;
        }
        $result["event_number"] = $event_number;
        echo json_encode($result);
        exit;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        if (!$request->hasParameter("new_event_flg")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $new_event_flg = false;
        if ($request->getParameter("new_event_flg") == "1") {
            $new_event_flg = true;
        }
        $event_id = "0";
        if (!$new_event_flg) {
            if (!$request->hasParameter("event_id")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $event_id = $request->getParameter("event_id");
        }
        if (!$request->hasParameter("event_info")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $event_info = $request->getParameter("event_info");
        $event_info["event_start_date"] = $event_info["event_start_date"] . " 00:00:00";
        $event_info["event_expiry_date"] = $event_info["event_expiry_date"] . " 23:59:59";
        if ($new_event_flg) {
            $insert_res = IohEventDBI::insertEvent($event_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
        } else {
            $where = "event_id = " . $event_id;
            $update_res = IohEventDBI::updateEvent($event_info, $where);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        }
        $controller->redirect("./?menu=event&act=admin_list");
        return VIEW_NONE;
    }

    private function _getTransWord($context)
    {
        return file_get_contents(SYSTEM_APP_HOST . "systool/trans/?k=" . urlencode($context));
    }
}
?>