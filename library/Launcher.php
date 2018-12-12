<?php

/**
 * 启动控制器
 * @author Kinsama
 * @version 2017-02-22
 */
class Launcher
{

    /**
     * 测试检测
     */
    private $_test_box;

    /**
     * 启动主程序
     *
     * @param object $controller Controller对象
     * @param object $user User对象
     * @param object $request Request对象
     */
    public function start(Controller $controller, User $user, Request $request, $remote_flg = false)
    {
        if ($remote_flg &&
            in_array($_SERVER['SERVER_ADDR'], unserialize(LOCAL_ALLOW_ADDRESS)) &&
            !in_array($user->getRemoteAddr(), unserialize(LOCAL_ALLOW_ADDRESS))) {
            phpinfo();
            exit;
        }
        $entity_path = opendir(SRC_PATH . "/library/entity/");
        while ($entity_file = readdir($entity_path)) {
            if (is_readable(SRC_PATH . "/library/entity/" . $entity_file) && substr($entity_file, -10) == "Entity.php") {
                require_once SRC_PATH . "/library/entity/" . $entity_file;
            }
        }
        $dbi_path = opendir(SRC_PATH . "/library/dbi/");
        while ($dbi_file = readdir($dbi_path)) {
            if (is_readable(SRC_PATH . "/library/dbi/" . $dbi_file) && substr($dbi_file, -7) == "DBI.php") {
                require_once SRC_PATH . "/library/dbi/" . $dbi_file;
            }
        }
        if ($request->api_flg) {
            $xml_trans_obj = Translate::getInstance();
            header("Content-Type:text/xml");
            $result_array = array(
                'status' => 200,
                'error' => 0,
                'parameters' => $request->getParameters(),
                'date' => date("Y-m-d H:i:s"),
                'results' => null
            );
            $res = $this->_apiLauncher($controller, $user, $request);
            if ($controller->isError($res)) {
                $res->writeLog();
                $result_array['status'] = $res->err_code;
                $result_array['error'] = 1;
            } else {
                $result_array['results'] = $res;
            }
            $list_xml_text = $xml_trans_obj->transArrayToXML($result_array);
            echo $list_xml_text;
        } else {
            $view = View::getInstance();
            $res = $this->_phpLauncher($controller, $user, $request);
            if ($controller->forward_flg == true) {
                $request->current_menu = $controller->forward_menu;
                $request->current_act = $controller->forward_act;
                $controller->forward_flg = false;
                $res = $this->_phpLauncher($controller, $user, $request);
            }
            $request->setAttribute("test_box_disp_flg", $this->_test_box['disp_flg']);
            $request->setAttribute("test_mode_info", $this->_test_box['info']);
            $mobile_flg = $request->checkMobile();
            if ($controller->isError($res)) {
                $res->writeLog();
                $view->errorDisplay($user, $request, $res, $mobile_flg);
                exit();
            }
            if ($res === VIEW_NONE) {
                exit();
            }
            $view->display($user, $request);
        }
        exit();
    }

    /**
     * 启动PHP主程序
     *
     * @param object $controller Controller对象
     * @param object $user User对象
     * @param object $request Request对象
     * @access private
     * @return int or Error Object
     */
    private function _phpLauncher(Controller $controller, User $user, Request $request)
    {
        // 获取ACTION对象
        $current_menu = SYSTEM_DEFAULT_MENU;
        $current_act = SYSTEM_DEFAULT_ACT;
        $current_auth = $this->_checkMenuAction($request->current_menu, $request->current_act);
        if ($current_auth !== false) {
            $current_menu = $request->current_menu;
            $current_act = $request->current_act;
        }
        // 权限判断
        $auth_lvl_fact = $user->getAuthLevel();
        if ($current_auth > SYSTEM_AUTH_COMMON && $auth_lvl_fact < $current_auth) {
            $redirect_url = sprintf("?menu=%s&act=%s", $request->current_menu, $request->current_act);
            $user->setVariable(REDIRECT_URL, $redirect_url);
            $err_disp_text = "该页面需要登录才能进行访问。";
            if ($current_auth == SYSTEM_AUTH_ADMIN) {
                $err_disp_text = "该页面需要管理员权限才能进行访问。";
            }
            $request->setError("no_login", $err_disp_text);
            $controller->forward("user", "login");
            return VIEW_DONE;
        }
        // 清除全局变量
        $usable_global_keys = Config::getUsableGlobalKeys();
        foreach ($usable_global_keys as $session_key => $usable_menu_act_context) {
            $current_menu_act = $request->current_menu . ":" . $request->current_act;
            if ($user->hasVariable($session_key) && !in_array($current_menu_act, $usable_menu_act_context)) {
                $user->freeVariable($session_key);
            }
        }
        // 获取页面Action
        $action = $this->_getActionObject($current_menu, $current_act);
        if ($controller->isError($action)) {
            return $action;
        }
        // 执行参数检测
        $res_validate = $action->doMainValidate($controller, $user, $request);
        if ($controller->isError($res_validate)) {
            return $res_validate;
        }
        // 执行主程序
        $res_execute = $action->doMainExecute($controller, $user, $request);
        if ($controller->isError($res_execute)) {
            return $res_execute;
        }
        // 测试模式
        $test_box_disp_flg = false;
        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            $test_box_disp_flg = true;
        }
        $test_mode_info = array();
        if ($test_box_disp_flg) {
            $test_mode_info['auth_level'] = $auth_lvl_fact;
            $test_mode_info['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        }
        $this->_test_box['disp_flg'] = $test_box_disp_flg;
        $this->_test_box['info'] = $test_mode_info;
        // 主程序返回VIEW_NONE则终止
        return $res_execute;
    }

    /**
     * 启动API主程序
     *
     * @param object $controller Controller对象
     * @param object $user User对象
     * @param object $request Request对象
     * @access private
     * @return int or Error Object
     */
    private function _apiLauncher(Controller $controller, User $user, Request $request)
    {
        if (!$this->_checkMenuAction($request->current_menu, $request->current_act, true)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_NONE_ACTION_FILE);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        // 获取ACTION对象
        $current_menu = $request->current_menu;
        $current_act = $request->current_act;
        $action = $this->_getApiActionObject($current_menu, $current_act);
        if ($controller->isError($action)) {
            return $action;
        }
        // 执行参数检测
        $res_validate = $action->doMainValidate($controller, $user, $request);
        if ($controller->isError($res_validate)) {
            return $res_validate;
        }
        // 执行主程序
        $res_execute = $action->doMainExecute($controller, $user, $request);
        if ($controller->isError($res_execute)) {
            return $res_execute;
        }
        // 主程序返回VIEW_NONE则终止
        return $res_execute;
    }

    /**
     * 获取Action对象
     *
     * @param string $current_menu menu名
     * @param string $current_act act名
     * @access private
     * @return object or Error Object
     */
    private function _getActionObject($current_menu, $current_act)
    {
        $menu_name = Utility::getFileFormatName($current_menu);
        $action_name = sprintf("Ioh%s_%sAction", $menu_name, Utility::getFileFormatName($current_act));
        $action_path = sprintf("%s/menu/%s/act/%s.php", SRC_PATH, $menu_name, $action_name);
        if (!is_readable($action_path)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_NONE_ACTION_FILE, $action_path);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        require_once $action_path;
        if (!class_exists($action_name)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_NONE_ACTION_CLASS, $action_name);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        return new $action_name();
    }

    /**
     * 获取API Action对象
     *
     * @param string $current_menu menu名
     * @param string $current_act act名
     * @access private
     * @return object or Error Object
     */
    private function _getApiActionObject($current_menu, $current_act)
    {
        $menu_name = Utility::getFileFormatName($current_menu);
        $action_name = sprintf("Ioh%s_%sAction", $menu_name, Utility::getFileFormatName($current_act));
        $action_path = sprintf("%s/api/menu/%s/act/%s.php", SRC_PATH, $menu_name, $action_name);
        if (!is_readable($action_path)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_NONE_ACTION_FILE, $action_path);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        require_once $action_path;
        if (!class_exists($action_name)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_NONE_ACTION_CLASS, $action_name);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        return new $action_name();
    }

    /**
     * 检测目标画面对象是否注册
     *
     * @param string $current_menu menu名
     * @param string $current_act act名
     * @access private
     * @return boolean
     */
    private function _checkMenuAction($menu, $act, $api_flg = false)
    {
        $allowed_current_list = Config::getAllowedCurrent();
        if ($api_flg) {
            $allowed_current_list = $allowed_current_list['api'];
        } else {
            $allowed_current_list = $allowed_current_list['php'];
        }
        if (isset($allowed_current_list[$menu][$act])) {
            return $allowed_current_list[$menu][$act];
        }
        return false;
    }

    /**
     * 获取本类实例化对象
     *
     * @return object
     */
    public static function getInstance()
    {
        return new Launcher();
    }
}
?>