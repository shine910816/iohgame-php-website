<?php

/**
 *
 * @author Kinsama
 * @version 2018-08-26
 */
class IohPubg_PartInputAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("back")) {
            $ret = $this->_doBackExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("confirm")) {
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
        $p_id = "0";
        if ($request->hasParameter("p_id")) {
            $p_id = $request->getParameter("p_id");
        }
        $part_info = array(
            "p_type" => "0",
            "p_name" => "",
            "p_image" => "",
            "p_descript" => "",
            "p_note" => ""
        );
        $request->setAttribute("p_id", $p_id);
        $request->setAttribute("part_info", $part_info);
        $request->setAttribute("part_type_list", IohPubgEntity::getPartTypeList());
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
        $p_id = $request->getAttribute("p_id");
        if ($p_id != "0") {
            $part_info_list = IohPubgDBI::selectPart($p_id);
            if ($controller->isError($part_info_list)) {
                $part_info_list->setPos(__FILE__, __LINE__);
                return $part_info_list;
            }
            if (isset($part_info_list[$p_id])) {
                $request->setAttribute("part_info", $part_info_list[$p_id]);
            } else {
                $request->setAttribute("p_id", "0");
            }
        }
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $p_id = $request->getAttribute("p_id");
        $part_info = $request->getParameter("part_info");
        $redirect_url = "./?menu=pubg&act=part_input&p_id=";
        if ($part_info["p_name"] == "") {
            $controller->redirect("./?menu=pubg&act=part_input");
            return VIEW_DONE;
        }
        if ($p_id) {
            $update_res = IohPubgDBI::updatePart($part_info, $p_id);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
            $redirect_url .= $w_id;
        } else {
            $insert_res = IohPubgDBI::insertPart($part_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
            $redirect_url .= $insert_res;
        }
        $controller->redirect($redirect_url);
        return VIEW_DONE;
    }

    private function _doBackExecute(Controller $controller, User $user, Request $request)
    {
        $controller->redirect("./?menu=pubg&act=part_list");
    }
}
?>