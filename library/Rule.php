<?php

/**
 * 规则包
 * @author Kinsama
 * @version 2017-07-31
 */
class Rule
{

    /**
     * 检测用户昵称是否合法
     *
     * @param string $nick 待检测用户昵称
     * @return boolean
     */
    public static function checkCustomNick($nick)
    {
        if (!Validate::checkNotEmpty($nick)) {
            return false;
        }
        if (Validate::checkChinese($nick)) {
            if (!Validate::checkFullLength($nick, array(
                'max_length' => 10
            ))) {
                return false;
            }
            return true;
        } elseif (Validate::checkAlpha($nick)) {
            if (!Validate::checkLength($nick, array(
                'max_length' => 20
            ))) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}
?>