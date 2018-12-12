<?php

/**
 * 小说一览画面
 * @author Kinsama
 * @version 2018-04-04
 */
class IohNovel_DispAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $novel_info = IohCNovelDBI::getNovelByType();
        if ($controller->isError($novel_info)) {
            $novel_info->setPos(__FILE__, __LINE__);
            return $novel_info;
        }
        $request->setAttribute("novel_info", $novel_info);
        return VIEW_DONE;
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
}
?>