<?php

/**
 * Object ID生成
 * @author Kinsama
 * @version 2018-07-04
 */
class IohTool_TransObjectIdAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("trans_object_id")) {
            $ret = $this->_doTransExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_update")) {
            $ret = $this->_doUpdateExecute($controller, $user, $request);
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
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $object_id_list = IohDataObjectIdDBI::getObjectIdList();
        if ($controller->isError($object_id_list)) {
            $object_id_list->setPos(__FILE__, __LINE__);
            return $object_id_list;
        }
        $request->setAttribute("object_id_list", $object_id_list);
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $new_object_id_data = $request->getParameter("new");
        if (strlen($new_object_id_data['object_id']) == 36) {
            $insert_res = IohDataObjectIdDBI::insertObjectId($new_object_id_data);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
        }
        $controller->redirect("./?menu=tool&act=trans_object_id");
        return VIEW_NONE;
    }

    private function _doTransExecute(Controller $controller, User $user, Request $request)
    {
        $trans_object_id = $request->getParameter("trans_object_id");
        $object_id = "";
        if (strlen($trans_object_id) > 0) {
            $object_id_str = strtoupper(md5(urldecode($trans_object_id)));
            $object_id_arr = array();
            $object_id_arr[] = substr($object_id_str, 0, 8);
            $object_id_arr[] = substr($object_id_str, 8, 4);
            $object_id_arr[] = substr($object_id_str, 12, 4);
            $object_id_arr[] = substr($object_id_str, 16, 4);
            $object_id_arr[] = substr($object_id_str, 20);
            $object_id = implode("-", $object_id_arr);
        }
        if (strlen($object_id) > 0) {
            $object_id_count_arr = IohDataObjectIdDBI::selectObjectId($object_id);
            if ($controller->isError($object_id_count_arr)) {
                $object_id_count_arr->setPos(__FILE__, __LINE__);
                $object_id = "";
            }
            if (count($object_id_count_arr) > 0) {
                $object_id = "";
            }
        }
        Utility::testVariable($object_id);
        return VIEW_NONE;
    }

    private function _doUpdateExecute(Controller $controller, User $user, Request $request)
    {
        $o_id = $request->getParameter("do_update");
        $update_data = $request->getParameter("update");
        $update_data = $update_data[$o_id];
        $where = "`o_id` = " . $o_id;
        $update_res = IohDataObjectIdDBI::updateObjectId($update_data, $where);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("./?menu=tool&act=trans_object_id");
        return VIEW_NONE;
    }
}
?>