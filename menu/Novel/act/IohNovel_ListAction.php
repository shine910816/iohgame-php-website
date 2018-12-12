<?php

/**
 * 小说章节目录画面
 * @author Kinsama
 * @version 2017-08-23
 */
class IohNovel_ListAction
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
        $novel_info = $novel_info[$n_id];
        $result = array();
        $last_article = array(
            "article_id" => "",
            "title" => ""
        );
        foreach ($novel_article as $art_info) {
            $n_article = $art_info["n_article"];
            $n_article_title = sprintf($novel_info["n_order_format"], $art_info["n_article_id"]);
            if (!empty($n_article)) {
                $n_article_title .= " " . $n_article;
            }
            $result[$art_info["n_article_id"]] = $n_article_title;
            $last_article["article_id"] = $art_info["n_article_id"];
            $last_article["title"] = $n_article_title;
        }
        $request->setAttribute("article_list", $result);
        $request->setAttribute("page_titles", array(
            $novel_info["n_name"]
        ));
        $request->setAttribute("novel_info", $novel_info);
        $request->setAttribute("last_article", $last_article);
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
        $n_id = $request->getParameter("novel_id");
        $request->setAttribute("n_id", $n_id);
        return VIEW_DONE;
    }
}
?>