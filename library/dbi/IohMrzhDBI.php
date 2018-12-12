<?php

/**
 * 数据库操作类-mrzh_item*
 * @author Kinsama
 * @version 2018-11-14
 */
class IohMrzhDBI
{

    public static function selectLastId($base_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT MAX(item_id) FROM mrzh_item WHERE item_id ";
        if ($base_flg) {
            $sql .= "> 200";
        } else {
            $sql .= "< 200";
        }
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["MAX(item_id)"];
        }
        $result->free();
        return $data[0];
    }

    public static function selectBaseItem()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM mrzh_item WHERE item_base_flg = 1 AND del_flg = 0 ORDER BY item_class ASC, item_type ASC, item_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectTotalItem($cons_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM mrzh_item WHERE del_flg = 0 ORDER BY item_class ASC, item_type ASC, item_food_type ASC, item_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($cons_flg) {
                $data[$row["item_id"]] = $row;
            } else {
                $data[$row["item_class"]][$row["item_type"]][$row["item_id"]] = $row;
            }
        }
        $result->free();
        return $data;
    }

    public static function selectItem($item_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($item_id)) {
            $item_id = array(
                $item_id
            );
        }
        $item_id_str = implode(", ", $item_id);
        $sql = "SELECT * FROM mrzh_item WHERE item_id IN (" . $item_id_str . ")";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectItemMaterial($item_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($item_id)) {
            $item_id = array(
                $item_id
            );
        }
        $item_id_str = implode(", ", $item_id);
        $sql = "SELECT * FROM mrzh_item_formula WHERE item_id IN (" . $item_id_str . ")";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]][$row["material_item_id"]] = $row["material_quantity"];
        }
        $result->free();
        return $data;
    }

    public static function selectItemMaterialMadeByItem($item_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM mrzh_item_formula WHERE item_id IN (SELECT item_id FROM mrzh_item_formula WHERE material_item_id = " . $item_id . ")";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]][$row["material_item_id"]] = $row["material_quantity"];
        }
        $result->free();
        return $data;
    }

    public static function selectDisplayItem($item_class, $item_type)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM mrzh_item WHERE item_class = " . $item_class . " AND item_type = " . $item_type . " AND del_flg = 0 ORDER BY item_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertItem($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("mrzh_item", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertItemFormula($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("mrzh_item_formula", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateItem($item_id, $update_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("mrzh_item", $update_data, "item_id = " . $item_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function unsetItemFormula($item_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->delete("mrzh_item_formula", "item_id = " . $item_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>