<?php

/**
 * Object JSON
 * @author Kinsama
 * @version 2019-02-27
 */
class IohTool_JsonAction extends ActionBase
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
        $json_path = "http://data.nba.net/10s/prod/v1/today.json";
        $json_trans_context = "";
        if ($request->hasParameter("do_submit")) {
            $json_path = $request->getParameter("json_path");
        }
        $request->setAttribute("json_path", $json_path);
        $request->setAttribute("json_trans_context", $json_trans_context);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $json_context = file_get_contents($request->getAttribute("json_path"));
        if ($json_context !== false) {
            $json_trans_context = json_decode($json_context, true);
            if (!empty($json_trans_context)) {
                $request->setAttribute("json_trans_context", print_r($json_trans_context, true));
            }
        }
        return VIEW_DONE;
    }
}
?>