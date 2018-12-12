<?php

/**
 * 数据库操作类-zone_code_cn
 * @author Kinsama
 * @version 2018-09-07
 */
class IohZonecodeDBI
{

    public static function selectProvince($short_name_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT province_id, zone_name, zone_name_short FROM zone_code_cn WHERE del_flg = 0 AND city_id = 0 AND county_id = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($short_name_flg) {
                $data[$row["province_id"]] = $row["zone_name_short"];
            } else {
                $data[$row["province_id"]] = $row["zone_name"];
            }
        }
        $result->free();
        return $data;
    }

    public static function selectCity($short_name_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT province_id, city_id, zone_name, zone_name_short FROM zone_code_cn WHERE del_flg = 0 AND city_id <> 0 AND county_id = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($short_name_flg) {
                $data[$row["province_id"]][$row["city_id"]] = $row["zone_name_short"];
            } else {
                $data[$row["province_id"]][$row["city_id"]] = $row["zone_name"];
            }
        }
        $result->free();
        return $data;
    }

    public static function selectCounty($short_name_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT province_id, city_id, county_id, zone_name, zone_name_short FROM zone_code_cn WHERE del_flg = 0 AND city_id <> 0 AND county_id <> 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($short_name_flg) {
                $data[$row["province_id"]][$row["city_id"]][$row["county_id"]] = $row["zone_name_short"];
            } else {
                $data[$row["province_id"]][$row["city_id"]][$row["county_id"]] = $row["zone_name"];
            }
        }
        $result->free();
        return $data;
    }

    public static function selectZoneNameShort($province_id, $city_id, $county_id)
    {
        $dbi = Database::getInstance();
        $where = "del_flg = 0 AND (";
        $where_arr = array();
        $limit_format = "(province_id = %d AND city_id = %d AND county_id = %d)";
        $where_arr[] = sprintf($limit_format, $province_id, $city_id, $county_id);
        $where_arr[] = sprintf($limit_format, $province_id, $city_id, 0);
        $where_arr[] = sprintf($limit_format, $province_id, 0, 0);
        $where .= implode(" OR ", $where_arr) . ")";
        $sql = "SELECT province_id, city_id, county_id, zone_name_short FROM zone_code_cn WHERE " . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        if (count($data) != 3) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_DATABASE_PARAM);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $short_name = "";
        $city_name = "";
        $county_name = "";
        foreach ($data as $data_info) {
            if ($data_info["province_id"] == $province_id && $data_info["city_id"] == "0" && $data_info["county_id"] == "0") {
                $short_name = $data_info["zone_name_short"];
            }
            if ($data_info["province_id"] == $province_id && $data_info["city_id"] == $city_id && $data_info["county_id"] == "0") {
                $city_name = $data_info["zone_name_short"];
            }
            if ($data_info["province_id"] == $province_id && $data_info["city_id"] == $city_id && $data_info["county_id"] == $county_id) {
                $county_name = $data_info["zone_name_short"];
            }
        }
        if (empty($short_name)) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_DATABASE_PARAM);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!empty($city_name)) {
            $short_name .= " " . $city_name;
        }
        if (!empty($county_name)) {
            $short_name .= " " . $county_name;
        }
        return $short_name;
    }
}
?>