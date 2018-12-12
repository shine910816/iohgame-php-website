<?php

/**
 * 数据库操作类-onmyouji_*
 * @author Kinsama
 * @version 2017-12-09
 */
class IohOnmyoujiDBI
{

    /**
     * 获取可抽卡得到的式神列表
     *
     * @return array or boolean
     */
    public static function selectDrawCardInfo()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT `s_id`" . ", `s_name`" . ", `s_level`" . ", `img_name`" . " FROM `" . IohOnmyoujiShikigamiEntity::getEntityName() . "` WHERE `draw_flg` = 1" . " AND `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['s_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 获取式神信息
     *
     * @return array or boolean
     */
    public static function selectShikigamiInfo($s_id = null)
    {
        $dbi = Database::getInstance();
        $where = "";
        if (!is_null($s_id)) {
            if (!is_array($s_id)) {
                $s_id = array(
                    $s_id
                );
            }
            $where = " AND `s_id` IN (" . implode(", ", $s_id) . ")";
        }
        $sql = "SELECT * FROM `" . IohOnmyoujiShikigamiEntity::getEntityName() . "` WHERE `del_flg` = 0" . $where . " ORDER BY `s_level` DESC, `img_name` ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            // 获取方式整理
            $get_list = array();
            if ($row['s_id'] == "70") {
                $get_list[] = "商店兑换";
            }
            if ($row['draw_flg'] == "1") {
                $get_list[] = "召唤";
            }
            if ($row['hyak_flg'] == "1") {
                $get_list[] = "百鬼夜行";
            }
            if ($row['ksho_flg'] == "1") {
                $get_list[] = "悬赏封印";
            }
            if ($row['yoki_flg'] == "1") {
                $get_list[] = "妖气封印";
            }
            if ($row['requ_flg'] == "1") {
                $get_list[] = "式神委派";
            }
            if ($row['shik_flg'] == "1") {
                $get_list[] = "神龛";
            }
            if ($row['s_id'] == "93") {
                $get_list[] = "重聚京都";
            }
            if ($row['s_id'] == "100") {
                $get_list[] = "同心之兰活动";
            }
            $row['get'] = implode("，", $get_list);
            // 面板数据整理
            $awake_before_arr = array();
            $awake_before_arr[] = $row['attack_before'];
            $awake_before_arr[] = $row['health_before'];
            $awake_before_arr[] = $row['defence_before'];
            $awake_before_arr[] = $row['speed_before'];
            $awake_before_arr[] = $row['critical_rate_before'];
            $awake_before_arr[] = $row['critical_damage_before'];
            $awake_before_arr[] = $row['hit_rate_before'];
            $awake_before_arr[] = $row['oppose_rate_before'];
            $awake_before_arr[] = $row['attack_level_before'];
            $awake_before_arr[] = $row['health_level_before'];
            $awake_before_arr[] = $row['defence_level_before'];
            $awake_before_arr[] = $row['speed_level_before'];
            $awake_before_arr[] = $row['critical_rate_level_before'];
            $row['awake_before'] = implode(",", $awake_before_arr);
            $awake_after_arr = array();
            $awake_after_arr[] = $row['attack_after'];
            $awake_after_arr[] = $row['health_after'];
            $awake_after_arr[] = $row['defence_after'];
            $awake_after_arr[] = $row['speed_after'];
            $awake_after_arr[] = $row['critical_rate_after'];
            $awake_after_arr[] = $row['critical_damage_after'];
            $awake_after_arr[] = $row['hit_rate_after'];
            $awake_after_arr[] = $row['oppose_rate_after'];
            $awake_after_arr[] = $row['attack_level_after'];
            $awake_after_arr[] = $row['health_level_after'];
            $awake_after_arr[] = $row['defence_level_after'];
            $awake_after_arr[] = $row['speed_level_after'];
            $awake_after_arr[] = $row['critical_rate_level_after'];
            $row['awake_after'] = implode(",", $awake_after_arr);
            $data[$row['s_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 获取式神皮肤
     *
     * @return array or boolean
     */
    public static function selectShikigamiSkin()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM `" . IohOnmyoujiSkinEntity::getEntityName() . "` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['s_id']][$row['skin_id']]['img_name'] = $row['img_name'];
            $data[$row['s_id']][$row['skin_id']]['skin_name'] = $row['skin_name'];
        }
        $result->free();
        return $data;
    }

    /**
     * 获取式神技能
     *
     * @return array or boolean
     */
    public static function selectShikigamiSkill()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM `" . IohOnmyoujiSkillEntity::getEntityName() . "` WHERE `del_flg` = 0 ORDER BY `s_id` ASC, `skill_id` ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['s_id']][$row['skill_id']] = $row;
        }
        $result->free();
        return $data;
    }
}
?>