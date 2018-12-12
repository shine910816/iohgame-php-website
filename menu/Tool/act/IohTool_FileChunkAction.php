<?php

/**
 * 文件分割
 * @author Kinsama
 * @version 2018-01-15
 */
class IohTool_FileChunkAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("download_file_id")) {
            $ret = $this->_doDownloadExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("file_id")) {
            $ret = $this->_doFileChunkExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_upload")) {
            $ret = $this->_doFileUploadExecute($controller, $user, $request);
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
        $file_id = 0;
        $file_name_upload = "";
        $file_tmp_name = "";
        if ($request->hasParameter("download_file_id")) {
            $file_id = $request->getParameter("download_file_id");
        } elseif ($request->hasParameter("file_id")) {
            $file_id = $request->getParameter("file_id");
        } elseif ($request->hasParameter("do_upload")) {
            if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == "0") {
                $file_size = $_FILES['upload_file']['size'];
                if ($file_size > 0 && $file_size <= 5242880) {
                    $file_name_upload = $_FILES['upload_file']['name'];
                    $file_tmp_name = $_FILES['upload_file']['tmp_name'];
                }
            }
        }
        $request->setAttribute("file_id", $file_id);
        $request->setAttribute("file_name_upload", $file_name_upload);
        $request->setAttribute("file_tmp_name", $file_tmp_name);
        $request->setAttribute("file_context_arr", array());
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $file_list = IohCFileDBI::getFileList();
        if ($controller->isError($file_list)) {
            $file_list->setPos(__FILE__, __LINE__);
            return $file_list;
        }
        if (!empty($file_list)) {
            $page_url = "./?";
            if ($request->current_level) {
                $page_url = "./?menu=tool&act=file_chunk&";
            }
            $file_list = Utility::getPaginationData($request, $file_list, $page_url);
            if ($controller->isError($file_list)) {
                $file_list->setPos(__FILE__, __LINE__);
                return $file_list;
            }
            $file_type_list = $this->_getFileTypeList();
            foreach ($file_list as $file_idx => $file_val) {
                $file_list[$file_idx]["file_css_text"] = $file_type_list[$file_val["file_type"]];
            }
        }
        $request->setAttribute("file_list", $file_list);
        return VIEW_DONE;
    }

    /**
     * 执行下载文件程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doDownloadExecute(Controller $controller, User $user, Request $request)
    {
        $file_id = $request->getAttribute("file_id");
        $file_list = IohCFileDBI::getFileList($file_id);
        if ($controller->isError($file_list)) {
            $file_list->setPos(__FILE__, __LINE__);
            return $file_list;
        }
        $file_info = $file_list[$file_id];
        $file_path = sprintf("%s/file/%s/%s", SRC_PATH, $file_info["file_subpath"], $file_info["file_md5"]);
        $content_type = "application/octet-stream";
        $content_type_list = Utility::getContentTypeList();
        if ($file_info["file_extension"] != "") {
            $file_path .= "." . $file_info["file_extension"];
            if (isset($content_type_list[$file_info["file_extension"]])) {
                $content_type = $content_type_list[$file_info["file_extension"]];
            }
        }
        $fo = fopen($file_path, "r");
        header("Content-type: " . $content_type);
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . filesize($file_path));
        header("Content-Disposition: attachment; filename=" . $file_info["file_name_upload"]);
        echo fread($fo, filesize($file_path));
        fclose($fo);
        exit();
    }

    /**
     * 执行分割文件程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doFileChunkExecute(Controller $controller, User $user, Request $request)
    {
        $file_id = $request->getAttribute("file_id");
        $file_info = IohCFileDBI::getFileList($file_id);
        if ($controller->isError($file_info)) {
            $file_info->setPos(__FILE__, __LINE__);
            return $file_info;
        }
        $file_info = $file_info[$file_id];
        $file_path = sprintf("%s/file/%s/%s", SRC_PATH, $file_info["file_subpath"], $file_info["file_md5"]);
        if ($file_info["file_extension"] != "") {
            $file_path .= "." . $file_info["file_extension"];
        }
        $file_context = bin2hex(file_get_contents($file_path));
        $split_num = 1024 * 1024;
        $file_context_arr = str_split($file_context, $split_num);
        $request->setAttribute("file_context_arr", $file_context_arr);
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        return $ret;
    }

    /**
     * 执行上传文件程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doFileUploadExecute(Controller $controller, User $user, Request $request)
    {
        $file_name_upload = $request->getAttribute("file_name_upload");
        $file_tmp_name = $request->getAttribute("file_tmp_name");
        if ($file_name_upload != "" && $file_tmp_name != "") {
            $insert_data = array();
            $file_md5 = md5_file($file_tmp_name);
            $file_name_arr = explode(".", $file_name_upload);
            $file_extension = "";
            $move_upload_filepath = "";
            $subpath = $this->_getSubpath();
            if (count($file_name_arr) > 1) {
                $last_index = count($file_name_arr) - 1;
                $file_extension = strtolower($file_name_arr[$last_index]);
                $move_upload_filepath = sprintf("%s/file/%s/%s.%s", SRC_PATH, $subpath, $file_md5, $file_extension);
            } else {
                $move_upload_filepath = sprintf("%s/file/%s/%s", SRC_PATH, $subpath, $file_md5);
            }
            $file_type = $this->_getFileType($file_extension);
            if (!move_uploaded_file($file_tmp_name, $move_upload_filepath)) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $insert_data["file_name_upload"] = $file_name_upload;
            $insert_data["file_md5"] = $file_md5;
            $insert_data["file_extension"] = $file_extension;
            $insert_data["file_type"] = $file_type;
            $insert_data["file_subpath"] = $subpath;
            $ret = IohCFileDBI::insertCFile($insert_data);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        $page = $request->getParameter("current_page");
        $url = "./tool/file_chunk/?page=" . $page;
        if ($request->current_level) {
            $url = "./?menu=tool&act=file_chunk&page=" . $page;
        }
        $controller->redirect($url);
        return VIEW_DONE;
    }

    private function _getSubpath()
    {
        $timestamp = time();
        $subpath = strtoupper(dechex($timestamp % 256));
        if (strlen($subpath) < 2) {
            $add_count = 2 - strlen($subpath);
            $subpath = str_repeat("0", $add_count) . $subpath;
        }
        $file_path = SRC_PATH . "/file/";
        if (!is_dir($file_path)) {
            mkdir($file_path);
        }
        if (!is_dir($file_path . $subpath)) {
            mkdir($file_path . $subpath);
        }
        return $subpath;
    }

    private function _getFileType($extension)
    {
        switch ($extension) {
            case "aac":
            case "ac3":
            case "amr":
            case "ape":
            case "cda":
            case "dts":
            case "flac":
            case "m1a":
            case "m2a":
            case "m4a":
            case "mid":
            case "mpa":
            case "ogg":
            case "ra":
            case "tak":
            case "tta":
            case "wav":
            case "wma":
            case "wv":
            case "mp3":
            case "m4r":
                return 1;
            case "bat":
            case "cmd":
            case "cs":
            case "cpp":
            case "cxx":
            case "c":
            case "h":
            case "hpp":
            case "inl":
            case "rc":
            case "css":
            case "htm":
            case "html":
            case "asp":
            case "aspx":
            case "shtml":
            case "shtm":
            case "ini":
            case "inf":
            case "reg":
            case "java":
            case "jav":
            case "js":
            case "jsp":
            case "pas":
            case "dpr":
            case "pl":
            case "pm":
            case "cgi":
            case "php":
            case "php3":
            case "py":
            case "rhtml":
            case "reb":
            case "rb":
            case "sql":
            case "tex":
            case "sty":
            case "cls":
            case "dtx":
            case "ins":
            case "ltx":
            case "vbs":
            case "wsf":
            case "wsc":
            case "asm":
            case "xml":
            case "xsl":
            case "manifest":
            case "hhc":
            case "hhk":
            case "eeproj":
            case "eesln":
            case "eesnip":
            case "json":
                return 2;
            case "xls":
            case "xlsx":
            case "csv":
                return 3;
            case "gif":
            case "jpg":
            case "png":
            case "psd":
            case "bmp":
            case "tiff":
            case "jpc":
            case "jp2":
            case "jpx":
            case "jb2":
            case "swc":
            case "iff":
            case "wbmp":
            case "xbm":
                return 4;
            case "asf":
            case "avi":
            case "wm":
            case "wmp":
            case "wmv":
            case "ram":
            case "rm":
            case "rmvb":
            case "rp":
            case "rpm":
            case "rt":
            case "smi":
            case "smil":
            case "dat":
            case "m1v":
            case "m2p":
            case "m2t":
            case "m2ts":
            case "m2v":
            case "mp2v":
            case "mpe":
            case "mpeg":
            case "mpg":
            case "mpv2":
            case "pss":
            case "pva":
            case "tp":
            case "tpr":
            case "ts":
            case "m4b":
            case "m4p":
            case "m4v":
            case "mp4":
            case "mpeg4":
            case "3g2":
            case "3gp":
            case "3gp2":
            case "3gpp":
            case "mov":
            case "qt":
            case "f4v":
            case "flv":
            case "hlv":
            case "swf":
            case "ifo":
            case "vob":
            case "amv":
            case "bik":
            case "csf":
            case "divx":
            case "evo":
            case "ivm":
            case "mkv":
            case "mod":
            case "mts":
            case "ogm":
            case "pmp":
            case "scm":
            case "tod":
            case "vp6":
            case "webm":
            case "xlmv":
                return 5;
            case "pdf":
                return 6;
            case "ppt":
            case "pptx":
                return 7;
            case "txt":
                return 8;
            case "doc":
            case "docx":
                return 9;
            case "rar":
            case "zip":
            case "zipx":
            case "7z":
            case "ace":
            case "arj":
            case "bz2":
            case "cab":
            case "gz":
            case "iso":
            case "jar":
            case "lz":
            case "lzh":
            case "tar":
            case "uue":
            case "xz":
            case "z":
                return 10;
            default:
                return 0;
        }
    }

    private function _getFileTypeList()
    {
        return array(
            "fa-file-o", // 0
            "fa-file-audio-o", // 1
            "fa-file-code-o", // 2
            "fa-file-excel-o", // 3
            "fa-file-image-o", // 4
            "fa-file-movie-o", // 5
            "fa-file-pdf-o", // 6
            "fa-file-powerpoint-o", // 7
            "fa-file-text-o", // 8
            "fa-file-word-o", // 9
            "fa-file-zip-o" // 10
        );
    }
}
?>