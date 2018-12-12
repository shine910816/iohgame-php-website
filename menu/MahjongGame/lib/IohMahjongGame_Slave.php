<?php

class IohMahjongGame_Slave
{

    public function getNextPlayer($player)
    {
        return $this->_adjustPlayer($player + 1);
    }

    public function getPrevPlayer($player)
    {
        return $this->_adjustPlayer($player - 1);
    }

    public function getOppoPlayer($player)
    {
        return $this->_adjustPlayer($player + 2);
    }

    public function getHandKongAble($m_table_id, $player)
    {
        $dbi = Database::getInstance();
        $card_type_num = IohMahjongGameDBI::getCardNumberGroupByType($m_table_id);
        if ($dbi->isError($card_type_num)) {
            $card_type_num->setPos(__FILE__, __LINE__);
            return $card_type_num;
        }
        $kong_type_list = array();
        foreach ($card_type_num[$player] as $c_type => $type_number) {
            if ($type_number[0] == "4" || ($type_number[0] == "1" && $type_number[1] == "3")) {
                $kaigang_type_list[] = $c_type;
            }
        }
        return $kong_type_list;
    }

    public function getTileAsc($m_table_id)
    {
        $dbi = Database::getInstance();
        $order_id_list = IohMahjongGameDBI::getTileOrderId($m_table_id);
        if ($dbi->isError($order_id_list)) {
            $order_id_list->setPos(__FILE__, __LINE__);
            return $order_id_list;
        }
        if (count($order_id_list) == 0) {
            return "0";
        }
        return $order_id_list[0];
    }

    public function getTileDesc($m_table_id)
    {
        $dbi = Database::getInstance();
        $order_id_list = IohMahjongGameDBI::getTileOrderIdBack($m_table_id);
        if ($dbi->isError($order_id_list)) {
            $order_id_list->setPos(__FILE__, __LINE__);
            return $order_id_list;
        }
        if (count($order_id_list) == 0) {
            return $this->getTileAsc($m_table_id);
        }
        return $order_id_list[0];
    }

    private function _adjustPlayer($player)
    {
        if ($player > 4) {
            return $player - 4;
        } elseif ($player < 1) {
            return $player + 4;
        }
        return $player;
    }

    public static function getInstance()
    {
        return new IohMahjongGame_Slave();
    }
}
?>