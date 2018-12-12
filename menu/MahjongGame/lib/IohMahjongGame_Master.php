<?php

class IohMahjongGame_Master
{

    public function newTableCard($m_room_id, $banker_player = 1)
    {
        $dbi = Database::getInstance();
        $card_type_info = IohMahjongGameDBI::getCardTypeList();
        if ($dbi->isError($card_type_info)) {
            $card_type_info->setPos(__FILE__, __LINE__);
            return $card_type_info;
        }
        $card_deck = array();
        for ($i = 0; $i < 136; $i++) {
            $index = floor($i / 4) + 1;
            $tmp_result = array(
                "c_type" => $card_type_info[$index]["c_type"],
                "m_card_id" => $i + 1
            );
            $card_deck[] = $tmp_result;
        }
        shuffle($card_deck);
        $dora_index = 137 - (rand(2, 12) * 2);
        $dora_type = $card_deck[$dora_index]["c_type"];
        $dora_next_type = $this->_getNext($dora_type);
        $player_card_number = 1;
        $player_card_getting = $banker_player;
        foreach ($card_deck as $m_order_id => $card_deck_info) {
            $card_deck[$m_order_id]["m_order_id"] = $m_order_id + 1;
            if ($m_order_id < 48) {
                if ($player_card_number > 4) {
                    $player_card_getting = $this->_getNext($player_card_getting);
                    $player_card_number = 1;
                }
                $card_deck[$m_order_id]["m_card_position"] = $player_card_getting;
                $player_card_number++;
                $card_deck[$m_order_id]["m_card_getable_flg"] = 0;
            } elseif ($m_order_id >= 48 && $m_order_id < 53) {
                $player_card_getting = $this->_getNext($player_card_getting);
                $card_deck[$m_order_id]["m_card_position"] = $player_card_getting;
                $card_deck[$m_order_id]["m_card_getable_flg"] = 0;
            } else {
                $card_deck[$m_order_id]["m_card_position"] = 0;
                $card_deck[$m_order_id]["m_card_getable_flg"] = 1;
            }
            if ($m_order_id == $dora_index + 1 || $m_order_id == $dora_index) {
                $card_deck[$m_order_id]["m_card_getable_flg"] = 0;
            }
            $card_deck[$m_order_id]["m_card_target_flg"] = 0;
            if ($m_order_id == 52) {
                $card_deck[$m_order_id]["m_card_target_flg"] = 1;
            }
            if ($card_deck_info["c_type"] == $dora_type || $card_deck_info["c_type"] == $dora_next_type) {
                $card_deck[$m_order_id]["m_card_dora_flg"] = 1;
            } else {
                $card_deck[$m_order_id]["m_card_dora_flg"] = 0;
            }
            if ($m_order_id > $dora_index + 1) {
                $card_deck[$m_order_id]["m_card_desc_order"] = 136 - $m_order_id;
            } else {
                $card_deck[$m_order_id]["m_card_desc_order"] = 0;
            }
            $card_deck[$m_order_id]["m_card_hand_disp_flg"] = 0;
            $card_deck[$m_order_id]["m_drop_from"] = 0;
        }
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $begin_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $begin_res;
        }
        $table_insert_data = array();
        $table_insert_data["m_room_id"] = $m_room_id;
        $table_insert_data["m_banker_player"] = $banker_player;
        $table_insert_data["m_turn_player"] = $banker_player;
        $table_insert_data["m_request_player"] = $banker_player;
        $table_insert_data["m_dora_first"] = $dora_type;
        $table_insert_data["m_dora_second"] = $dora_next_type;
        $table_insert_data["winner_player"] = "0";
        $m_table_id = IohMahjongGameDBI::insertTable($table_insert_data);
        if ($dbi->isError($m_table_id)) {
            $m_table_id->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $m_table_id;
        }
        foreach ($card_deck as $deck_info) {
            $deck_info["m_table_id"] = $m_table_id;
            $insert_res = IohMahjongGameDBI::insertTableCard($deck_info);
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
        return $m_table_id;
    }

    private function _getNext($c_type)
    {
        switch ($c_type) {
            case "4":
                return "1";
            case "7":
                return "5";
            case "16":
                return "8";
            case "25":
                return "17";
            case "34":
                return "26";
            default:
                return $c_type + 1;
        }
    }

    public static function getInstance()
    {
        return new IohMahjongGame_Master();
    }
}
?>