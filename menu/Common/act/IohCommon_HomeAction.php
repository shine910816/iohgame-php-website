<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2016-12-01
 */
class IohCommon_HomeAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>