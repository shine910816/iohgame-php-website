<?php

/**
 * 数独
 * @author Kinsama
 * @version 2019-06-04
 */
class IohSudoku_DetailAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
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
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $cols_index_str = "ABCDEFGHI";
        $rows_index_str = "123456789";
        $table_cols_rows = array();
        $table_numbers = array();
        for ($i = 0; $i < strlen($cols_index_str); $i++) {
            for ($j = 0; $j < strlen($cols_index_str); $j++) {
                $cols = substr($cols_index_str, $i, 1);
                $rows = substr($rows_index_str, $j, 1);
                $table_cols_rows[$cols][$rows] = 0;
                $table_numbers[$rows][$cols] = 0;
            }
        }
Utility::testVariable($table_numbers);
        return VIEW_NONE;
    }
}
?>