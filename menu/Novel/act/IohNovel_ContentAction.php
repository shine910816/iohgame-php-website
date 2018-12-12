<?php

/**
 * 小说正文阅读画面
 * @author Kinsama
 * @version 2017-08-23
 */
class IohNovel_ContentAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $n_id = $request->getAttribute("n_id");
        $n_article_id = $request->getAttribute("n_article_id");
        $novel_article = IohCNovelArticleDBI::getNovelArticle($n_id);
        if ($controller->isError($novel_article)) {
            $novel_article->setPos(__FILE__, __LINE__);
            return $novel_article;
        }
        if (empty($novel_article)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $n_article_info = $novel_article[$n_article_id];
        $novel_info = IohCNovelDBI::getNovelInfoByNId($n_id);
        if ($controller->isError($novel_info)) {
            $novel_info->setPos(__FILE__, __LINE__);
            return $novel_info;
        }
        if (!isset($novel_info[$n_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $prev_flg = 1;
        $next_flg = 1;
        if ($n_article_id <= 1) {
            $prev_flg = 0;
        }
        if ($n_article_id >= count($novel_article)) {
            $next_flg = 0;
        }
        $n_article = $n_article_info["n_article"];
        $n_article_title = sprintf($novel_info[$n_id]["n_order_format"], $n_article_id);
        if (!empty($n_article)) {
            $n_article_title .= " " . $n_article;
        }
        $paragraph_start_list = array(
            "",
            str_repeat("&nbsp;", 4),
            str_repeat("　", 2)
        );
        $paragraph_start = $paragraph_start_list[$novel_info[$n_id]["alphabet_flg"]];
        $novel_content = file_get_contents(SRC_PATH . "/data/novel/" . $n_id . "/" . $n_article_info["n_article_filename"] . ".novel");
        $novel_content = explode("\n", $novel_content);
        foreach ($novel_content as $idx_cont => $itm_cont) {
            $novel_content[$idx_cont] = $paragraph_start . $itm_cont;
        }
        $request->setAttribute("n_name", $novel_info[$n_id]['n_name']);
        $request->setAttribute("n_author", $novel_info[$n_id]['n_author']);
        $request->setAttribute("n_article", $n_article_title);
        $request->setAttribute("prev_flg", $prev_flg);
        $request->setAttribute("next_flg", $next_flg);
        $request->setAttribute("novel_content", $novel_content);
        $request->setAttribute("page_titles", array(
            '<a href="./?menu=novel&act=list&novel_id=' . $n_id . '">' . $novel_info[$n_id]['n_name'] . '</a>',
            $n_article
        ));
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
        if (!$request->hasParameter("novel_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("article_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $n_id = $request->getParameter("novel_id");
        $n_article_id = $request->getParameter("article_id");
        if (!Validate::checkDecimalNumber($n_id) || !Validate::checkNotEmpty($n_id)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!Validate::checkDecimalNumber($n_article_id) || !Validate::checkNotEmpty($n_article_id)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("n_id", $n_id);
        $request->setAttribute("n_article_id", $n_article_id);
        return VIEW_DONE;
    }
}
?>