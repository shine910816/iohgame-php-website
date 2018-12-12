<?php

/**
 * 数据库操作类-c_friend
 * @author Kinsama
 * @version 2017-01-20
 */
class IohCFriendDBI
{

    /**
     * 数据添加
     *
     * @param int $cus_id 用户ID
     * @param int $oppo_cus_id 对方用户ID
     * @param int $friend_status 好友状态
     * @return int or errorObject
     */
    public static function addCFriend($cus_id, $oppo_cus_id, $friend_status = IohCFriendEntity::FRIEND_STATUS_WAIT)
    {
        $dbi = Database::getInstance();
        $insert_data = array(
            'cus_id' => $cus_id,
            'oppo_cus_id' => $oppo_cus_id,
            'friend_status' => $friend_status
        );
        $result = $dbi->insert(IohCFriendEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 数据变更
     *
     * @param int $friend_id 索引ID
     * @param mixed $update_data 变更内容
     * @return int or errorObject
     */
    public static function changeCFriend($friend_id, $update_data)
    {
        $dbi = Database::getInstance();
        $where = "`del_flg` = 0 AND `friend_id` = " . $dbi->quote($friend_id);
        $result = $dbi->update(IohCFriendEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 获取好友数据
     *
     * @param int $friend_id 索引ID
     * @return array or errorObject
     */
    public static function getCFriendInfo($friend_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($friend_id)) {
            $friend_id = array(
                $friend_id
            );
        }
        $friend_id_list = implode(", ", $dbi->quote($friend_id));
        $sql = sprintf("SELECT" . " `friend_id`," . " `cus_id`," . " `oppo_cus_id`," . " `friend_status`" . " FROM `c_friend`" . " WHERE `friend_id` IN (%s)" . " AND `del_flg` = 0", $friend_id_list);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['friend_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 获取待确认好友数据
     *
     * @param int $cus_id 用户ID
     * @return array or errorObject
     */
    public static function getWaitFriendList($cus_id)
    {
        $dbi = Database::getInstance();
        $sql = sprintf("SELECT" . " `friend_id`," . " `cus_id`," . " `oppo_cus_id`," . " `friend_status`," . " `notes`" . " FROM `c_friend`" . " WHERE `friend_status` = %s" . " AND `oppo_cus_id` = %s" . " AND `del_flg` = 0" . " ORDER BY `insert_date` DESC", $dbi->quote(IohCFriendEntity::FRIEND_STATUS_WAIT), $dbi->quote($cus_id));
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['friend_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 获取好友列表
     *
     * @param int $cus_id 用户ID
     * @return array or errorObject
     */
    public static function getFriendList($cus_id)
    {
        $dbi = Database::getInstance();
        $friend_status = array(
            IohCFriendEntity::FRIEND_STATUS_CLOSE,
            IohCFriendEntity::FRIEND_STATUS_COMMON
        );
        $sql = sprintf("SELECT" . " `friend_id`," . " `oppo_cus_id`," . " `friend_status`" . " FROM `c_friend`" . " WHERE `friend_status` IN (%s)" . " AND `cus_id` = %s" . " AND `del_flg` = 0" . " ORDER BY `friend_status` ASC," . " `oppo_cus_id` ASC", implode(", ", $dbi->quote($friend_status)), $dbi->quote($cus_id));
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['friend_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 获取黑名单列表
     *
     * @param int $cus_id 用户ID
     * @param boolean $self_flg 自身Flag
     * @return array or errorObject
     */
    public static function getBlackList($cus_id, $self_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT" . " `friend_id`," . " `cus_id`," . " `oppo_cus_id`" . " FROM `c_friend`" . " WHERE ";
        $sql .= "`friend_status` = " . $dbi->quote(IohCFriendEntity::FRIEND_STATUS_BLACK) . " AND `";
        $sql .= $self_flg ? "oppo_cus_id" : "cus_id";
        $sql .= "` = " . $dbi->quote($cus_id);
        $sql .= " AND `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['friend_id']] = $self_flg ? $row["cus_id"] : $row["oppo_cus_id"];
        }
        $result->free();
        return $data;
    }

    /**
     * 根据双方信息获取好友ID
     *
     * @param int $cus_id 用户ID
     * @param int $oppo_cus_id 对方用户ID
     * @return array or errorObject
     */
    public static function getFriendIdByDouble($cus_id, $oppo_cus_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT" . " `friend_id`," . " `cus_id`," . " `oppo_cus_id`" . " FROM `c_friend`" . " WHERE `cus_id` = " . $dbi->quote($cus_id) . " AND `oppo_cus_id` = " . $dbi->quote($oppo_cus_id) . " AND `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        if (count($data) != 1) {
            return false;
        }
        return $data[0]['friend_id'];
    }
}
?>