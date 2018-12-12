<?php

/**
 * Object ID
 * @author Kinsama
 * @version 2018-07-06
 */
class IohUsrApi_ObjectIdAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $lang = $request->getAttribute("lang");
        $result = array();
        $object_id_list = IohDataObjectIdDBI::getObjectIdListByLanguage($lang);
        if ($controller->isError($object_id_list)) {
            $object_id_list->setPos(__FILE__, __LINE__);
            return $object_id_list;
        }
        $result = $object_id_list;
        Utility::testVariable(json_encode($result));
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
        $language_code = "0";
        if ($request->hasParameter("lang")) {
            $lang = $request->getParameter("lang");
            if (Validate::checkNotEmpty($lang) && Validate::checkAcceptParam($lang, array(
                "1",
                "2"
            ))) {
                $language_code = $lang;
            }
        }
        if ($language_code == "1") {
            $user->setVariable("language_code", "en");
        } elseif ($language_code == "2") {
            $user->setVariable("language_code", "ja");
        } else {
            $user->setVariable("language_code", "cn");
        }
        $request->setAttribute("lang", $language_code);
        return VIEW_DONE;
    }
}
?>