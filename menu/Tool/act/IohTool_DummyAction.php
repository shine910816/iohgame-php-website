<?php
require_once SRC_PATH . "/menu/Tool/lib/IohTool_Common.php";
require_once SRC_PATH . "/menu/Tool/lib/IohTool_DBI.php";

/**
 * 数据模拟
 * @author Kinsama
 * @version 2017-11-16
 */
class IohTool_DummyAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("creat_data")) {
            $ret = $this->_doCreatDataExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("delete")) {
            $ret = $this->_doDeleteDataExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("download")) {
            $ret = $this->_doDownloadExecute($controller, $user, $request);
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
     * 执行默认命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $disp_list = IohTool_DBI::selectMaster();
        if ($controller->isError($disp_list)) {
            $disp_list->setPos(__FILE__, __LINE__);
            return $disp_list;
        }
        $request->setAttribute("disp_list", $disp_list);
        $request->setAttribute("disp_num", count($disp_list));
        return VIEW_DONE;
    }

    /**
     * 执行删除数据命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDeleteDataExecute(Controller $controller, User $user, Request $request)
    {
        $data_id = $request->getAttribute("data_id");
        $del_res = IohTool_DBI::deleteData($data_id);
        if ($controller->isError($del_res)) {
            $del_res->setPos(__FILE__, __LINE__);
            return $del_res;
        }
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        return $ret;
    }

    /**
     * 执行下载数据命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDownloadExecute(Controller $controller, User $user, Request $request)
    {
        $data_id = $request->getAttribute("data_id");
        $code_list = $this->_getCodeList();
        $gender_code_list = $code_list['gender_code'];
        $generation_e_code_list = $code_list['generation_e_code'];
        $exist_code_list = $code_list['exist_code'];
        $file_name = "aggregate_" . date("Y-m-d") . "_" . date("H-i-s") . ".csv";
        $word_code = $request->getAttribute("word_code");
        $result_item = IohTool_DBI::selectMaster($data_id);
        if ($controller->isError($result_item)) {
            $result_item->setPos(__FILE__, __LINE__);
            return $result_item;
        }
        $monthly_data = IohTool_DBI::selectMonthsAggregate($data_id);
        if ($controller->isError($monthly_data)) {
            $monthly_data->setPos(__FILE__, __LINE__);
            return $monthly_data;
        }
        $daily_data = IohTool_DBI::selectDailyAggregate($data_id);
        if ($controller->isError($daily_data)) {
            $daily_data->setPos(__FILE__, __LINE__);
            return $daily_data;
        }
        $user_data = IohTool_DBI::selectUserAggregate($data_id);
        if ($controller->isError($user_data)) {
            $user_data->setPos(__FILE__, __LINE__);
            return $user_data;
        }
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "monthly_store_aggregate\n";
        echo "months,group_id,store_code,store_division1,store_division2," . "gender_code,generation_e_code,exist_code," . "group_name,group_short_name,store_name," . "gender_name,generation_e_name,exist_name," . "invest_uu_num,invest_card_num,purchase_amount,invest_num,invest_point," . "last_m_invest_uu_num,last_m_invest_card_num,last_m_purchase_amount,last_m_invest_num,last_m_invest_point," . "last_y_invest_uu_num,last_y_invest_card_num,last_y_purchase_amount,last_y_invest_num,last_y_invest_point," . "use_uu_num,use_num,use_point,use_term_point," . "last_m_use_uu_num,last_m_use_num,last_m_use_point,last_m_use_term_point," . "last_y_use_uu_num,last_y_use_num,last_y_use_point,last_y_use_term_point\n";
        foreach ($monthly_data as $monthly_item) {
            $output_item = array();
            $output_item['months'] = $result_item[$monthly_item['data_id']]['months'];
            $output_item['group_id'] = $result_item[$monthly_item['data_id']]['group_id'];
            $output_item['store_code'] = $result_item[$monthly_item['data_id']]['store_code'];
            $output_item['store_division1'] = "";
            $output_item['store_division2'] = "";
            $output_item['gender_code'] = $monthly_item['gender_code'];
            $output_item['generation_e_code'] = $monthly_item['generation_e_code'];
            $output_item['exist_code'] = $monthly_item['exist_code'];
            $output_item['group_name'] = iconv("utf-8", $word_code, $result_item[$monthly_item['data_id']]['group_name']);
            $output_item['group_short_name'] = iconv("utf-8", $word_code, $result_item[$monthly_item['data_id']]['group_name']);
            $output_item['store_name'] = iconv("utf-8", $word_code, $result_item[$monthly_item['data_id']]['store_name']);
            $output_item['gender_name'] = iconv("utf-8", $word_code, $gender_code_list[$monthly_item['gender_code']]);
            $output_item['generation_name'] = iconv("utf-8", $word_code, $generation_e_code_list[$monthly_item['generation_e_code']]);
            $output_item['exist_name'] = iconv("utf-8", $word_code, $exist_code_list[$monthly_item['exist_code']]);
            $output_item['invest_uu_num'] = $monthly_item['invest_uu_num'];
            $output_item['invest_card_num'] = $monthly_item['invest_card_num'];
            $output_item['purchase_amount'] = $monthly_item['purchase_amount'];
            $output_item['invest_num'] = $monthly_item['invest_num'];
            $output_item['invest_point'] = $monthly_item['invest_point'];
            $output_item['last_m_invest_uu_num'] = IohTool_Common::getPercent($monthly_item['invest_uu_num']);
            $output_item['last_m_invest_card_num'] = IohTool_Common::getPercent($monthly_item['invest_card_num']);
            $output_item['last_m_purchase_amount'] = IohTool_Common::getPercent($monthly_item['purchase_amount']);
            $output_item['last_m_invest_num'] = IohTool_Common::getPercent($monthly_item['invest_num']);
            $output_item['last_m_invest_point'] = IohTool_Common::getPercent($monthly_item['invest_point']);
            $output_item['last_y_invest_uu_num'] = IohTool_Common::getPercent($monthly_item['invest_uu_num']);
            $output_item['last_y_invest_card_num'] = IohTool_Common::getPercent($monthly_item['invest_card_num']);
            $output_item['last_y_purchase_amount'] = IohTool_Common::getPercent($monthly_item['purchase_amount']);
            $output_item['last_y_invest_num'] = IohTool_Common::getPercent($monthly_item['invest_num']);
            $output_item['last_y_invest_point'] = IohTool_Common::getPercent($monthly_item['invest_point']);
            $output_item['use_uu_num'] = $monthly_item['use_uu_num'];
            $output_item['use_num'] = $monthly_item['use_num'];
            $output_item['use_point'] = $monthly_item['use_point'];
            $output_item['use_term_point'] = $monthly_item['use_term_point'];
            $output_item['last_m_use_uu_num'] = IohTool_Common::getPercent($monthly_item['use_uu_num']);
            $output_item['last_m_use_num'] = IohTool_Common::getPercent($monthly_item['use_num']);
            $output_item['last_m_use_point'] = IohTool_Common::getPercent($monthly_item['use_point']);
            $output_item['last_m_use_term_point'] = IohTool_Common::getPercent($monthly_item['use_term_point']);
            $output_item['last_y_use_uu_num'] = IohTool_Common::getPercent($monthly_item['use_uu_num']);
            $output_item['last_y_use_num'] = IohTool_Common::getPercent($monthly_item['use_num']);
            $output_item['last_y_use_point'] = IohTool_Common::getPercent($monthly_item['use_point']);
            $output_item['last_y_use_term_point'] = IohTool_Common::getPercent($monthly_item['use_term_point']);
            echo implode(",", $output_item) . "\n";
        }
        echo "\ndaily_store_aggregate\n";
        echo "days,group_id,store_code,store_division1,store_division2," . "group_name,group_short_name,store_name," . "invest_uu_num,invest_card_num,purchase_amount,invest_num,invest_point\n";
        foreach ($daily_data as $daily_item) {
            $output_item = array();
            $output_item['days'] = $daily_item['days'];
            $output_item['group_id'] = $result_item[$daily_item['data_id']]['group_id'];
            $output_item['store_code'] = $result_item[$daily_item['data_id']]['store_code'];
            $output_item['store_division1'] = "";
            $output_item['store_division2'] = "";
            $output_item['group_name'] = iconv("utf-8", $word_code, $result_item[$daily_item['data_id']]['group_name']);
            $output_item['group_short_name'] = iconv("utf-8", $word_code, $result_item[$daily_item['data_id']]['group_name']);
            $output_item['store_name'] = iconv("utf-8", $word_code, $result_item[$daily_item['data_id']]['store_name']);
            $output_item['invest_uu_num'] = $daily_item['invest_uu_num'];
            $output_item['invest_card_num'] = $daily_item['invest_card_num'];
            $output_item['purchase_amount'] = $daily_item['purchase_amount'];
            $output_item['invest_num'] = $daily_item['invest_num'];
            $output_item['invest_point'] = $daily_item['invest_point'];
            echo implode(",", $output_item) . "\n";
        }
        echo "\nstore_user_aggregate\n";
        echo "months,group_id,store_code,store_division1,store_division2," . "gender_code,generation_e_code," . "group_name,group_short_name,store_name," . "gender,age_e_name," . "invest_uu_num,invest_card_num,purchase_amount,invest_num\n";
        foreach ($user_data as $user_item) {
            $output_item = array();
            $output_item['months'] = $result_item[$user_item['data_id']]['months'];
            $output_item['group_id'] = $result_item[$user_item['data_id']]['group_id'];
            $output_item['store_code'] = $result_item[$user_item['data_id']]['store_code'];
            $output_item['store_division1'] = "";
            $output_item['store_division2'] = "";
            $output_item['gender_code'] = $user_item['gender_code'];
            $output_item['generation_e_code'] = $user_item['generation_e_code'];
            $output_item['group_name'] = iconv("utf-8", $word_code, $result_item[$user_item['data_id']]['group_name']);
            $output_item['group_short_name'] = iconv("utf-8", $word_code, $result_item[$user_item['data_id']]['group_name']);
            $output_item['store_name'] = iconv("utf-8", $word_code, $result_item[$user_item['data_id']]['store_name']);
            $output_item['gender_name'] = iconv("utf-8", $word_code, $gender_code_list[$user_item['gender_code']]);
            $output_item['generation_name'] = iconv("utf-8", $word_code, $generation_e_code_list[$user_item['generation_e_code']]);
            $output_item['invest_uu_num'] = $user_item['invest_uu_num'];
            $output_item['invest_card_num'] = $user_item['invest_card_num'];
            $output_item['purchase_amount'] = $user_item['purchase_amount'];
            $output_item['invest_num'] = $user_item['invest_num'];
            echo implode(",", $output_item) . "\n";
        }
        exit();
    }

    /**
     * 执行创建数据
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doCreatDataExecute(Controller $controller, User $user, Request $request)
    {
        $start_date = $request->getAttribute("start_date");
        $group_id = $request->getAttribute("group_id");
        $group_name = $request->getAttribute("group_name");
        $store_code = $request->getAttribute("store_code");
        $store_name = $request->getAttribute("store_name");
        $data_id = IohTool_DBI::getNewDataId();
        if ($controller->isError($data_id)) {
            $data_id->setPos(__FILE__, __LINE__);
            return $data_id;
        }
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $begin_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $begin_res;
        }
        $index_insert_data = array(
            "data_id" => $data_id,
            "months" => $start_date,
            "group_id" => $group_id,
            "group_name" => $group_name,
            "store_code" => $store_code,
            "store_name" => $store_name
        );
        $index_insert_res = IohTool_DBI::insertIndex($index_insert_data);
        if ($controller->isError($index_insert_res)) {
            $index_insert_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $index_insert_res;
        }
        $content_data = IohTool_Common::getDaysData($start_date);
        foreach ($content_data as $days => $days_item) {
            foreach ($days_item as $exist_code => $exist_code_item) {
                foreach ($exist_code_item as $gender_code => $gender_code_item) {
                    foreach ($gender_code_item as $generation_e_code => $item) {
                        $content_insert_data = $item;
                        $content_insert_data['data_id'] = $data_id;
                        $content_insert_data['days'] = $days;
                        $content_insert_data['gender_code'] = $gender_code;
                        $content_insert_data['generation_e_code'] = $generation_e_code;
                        $content_insert_data['exist_code'] = $exist_code;
                        $content_insert_res = IohTool_DBI::insertContent($content_insert_data);
                        if ($controller->isError($content_insert_res)) {
                            $content_insert_res->setPos(__FILE__, __LINE__);
                            $dbi->rollback();
                            return $content_insert_res;
                        }
                    }
                }
            }
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $commit_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $commit_res;
        }
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
        $data_id = 1;
        $start_date = "201709";
        $group_id = "901";
        $group_name = "企業1";
        $store_code = "90101";
        $store_name = "店舗1_01";
        $word_code = "1";
        $code_list = $this->_getCodeList();
        if ($request->hasParameter("data_id")) {
            $data_id = $request->getParameter("data_id");
        }
        if ($request->hasParameter("start_date")) {
            $start_date = $request->getParameter("start_date");
        }
        if ($request->hasParameter("group_id")) {
            $group_id = $request->getParameter("group_id");
        }
        if ($request->hasParameter("group_name")) {
            $group_name = $request->getParameter("group_name");
        }
        if ($request->hasParameter("store_code")) {
            $store_code = $request->getParameter("store_code");
        }
        if ($request->hasParameter("store_name")) {
            $store_name = $request->getParameter("store_name");
        }
        if ($request->hasParameter("word_code")) {
            $word_code = $request->getParameter("word_code");
        }
        $request->setAttribute("page_title", "店舗別ダミーデータCSV出力");
        $request->setAttribute("data_id", $data_id);
        $request->setAttribute("start_date", $start_date);
        $request->setAttribute("group_id", $group_id);
        $request->setAttribute("group_name", $group_name);
        $request->setAttribute("store_code", $store_code);
        $request->setAttribute("store_name", $store_name);
        $request->setAttribute("word_code_list", $code_list['word_code_disp']);
        $request->setAttribute("word_code", $code_list['word_code_value'][$word_code]);
        return VIEW_DONE;
    }

    /**
     * 获取代码列表
     * @return array
     */
    private function _getCodeList()
    {
        return array(
            "gender_code" => array(
                "1" => "男性",
                "2" => "女性",
                "10" => "その他",
                "99" => "未登録"
            ),
            "generation_e_code" => array(
                "15" => "20代以下",
                "30" => "30代",
                "40" => "40代",
                "50" => "50代",
                "60" => "60代以上",
                "100" => "その他",
                "999" => "未登録"
            ),
            "exist_code" => array(
                "1" => "新規",
                "2" => "既存"
            ),
            "word_code_disp" => array(
                "1" => "Shift-JIS",
                "2" => "GBK",
                "0" => "Unicode"
            ),
            "word_code_value" => array(
                "1" => "SJIS",
                "2" => "GBK//IGNORE",
                "0" => "utf-8"
            )
        );
    }
}
?>