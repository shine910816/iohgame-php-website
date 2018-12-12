<?php

/**
 *
 * @author Kinsama
 * @version 2018-08-27
 */
class IohPubg_ListInputAction extends ActionBase
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
        $weapon_type_list = IohPubgEntity::getWeaponTypeList();
        $part_type_list = IohPubgEntity::getPartTypeList();
        $request->setAttribute("weapon_type_list", $weapon_type_list);
        $request->setAttribute("part_type_list", $part_type_list);
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
        $weapon_list = IohPubgDBI::selectWeapon();
        if ($controller->isError($weapon_list)) {
            $weapon_list->setPos(__FILE__, __LINE__);
            return $weapon_list;
        }
        $part_list = IohPubgDBI::selectPartByType();
        if ($controller->isError($part_list)) {
            $part_list->setPos(__FILE__, __LINE__);
            return $part_list;
        }
        $weapon_part_list = IohPubgDBI::selectWeaponPart();
        if ($controller->isError($weapon_part_list)) {
            $weapon_part_list->setPos(__FILE__, __LINE__);
            return $weapon_part_list;
        }
        $request->setAttribute("weapon_list", $weapon_list);
        $request->setAttribute("part_list", $part_list);
        $request->setAttribute("weapon_part_list", $weapon_part_list);
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $weapon_part = $request->getParameter("weapon_part");
        $ammo = $request->getParameter("ammo");
        if (!empty($weapon_part) && !empty($ammo)) {
            $dbi = Database::getInstance();
            $begin_res = $dbi->begin();
            if ($dbi->isError($begin_res)) {
                $begin_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $begin_res;
            }
            $clean_res = IohPubgDBI::cleanWeaponPart();
            if ($dbi->isError($clean_res)) {
                $clean_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $clean_res;
            }
            foreach ($weapon_part as $w_id => $tmp_w_info) {
                foreach ($tmp_w_info as $p_id => $tmp) {
                    $insert_res = IohPubgDBI::insertWeaponPart($w_id, $p_id);
                    if ($dbi->isError($insert_res)) {
                        $insert_res->setPos(__FILE__, __LINE__);
                        $dbi->rollback();
                        return $insert_res;
                    }
                }
            }
            foreach ($ammo as $w_id => $p_id) {
                $insert_res = IohPubgDBI::insertWeaponPart($w_id, $p_id);
                if ($dbi->isError($insert_res)) {
                    $insert_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $insert_res;
                }
            }
            $commit_res = $dbi->commit();
            if ($dbi->isError($commit_res)) {
                $commit_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $commit_res;
            }
        }
        $controller->redirect("./?menu=pubg&act=list_input");
        return VIEW_DONE;
    }

    private function _doBackExecute(Controller $controller, User $user, Request $request)
    {
        $controller->redirect("./?menu=pubg&act=list");
        return VIEW_DONE;
    }
}
?>