<?php

/**
 * 数据库应用类-g_wow_*
 * @author Kinsama
 * @version 2019-09-16
 */
class IohWowClassesEntity
{
    const DUTY_TANK_STR = "1";
    const DUTY_TANK_AGI = "2";
    const DUTY_DAMAGE_STR = "3";
    const DUTY_DAMAGE_AGI_CLS = "4";
    const DUTY_DAMAGE_AGI_RMT = "5";
    const DUTY_DAMAGE_SPELL = "6";
    const DUTY_DAMAGE_TREAT = "7";

    const CLASSES_WARRIOR = "1";
    const CLASSES_PALADIN = "2";
    const CLASSES_DEATHKNIGHT = "3";
    const CLASSES_HUNTER = "4";
    const CLASSES_SHAMAN = "5";
    const CLASSES_ROUGUE = "6";
    const CLASSES_DRUID = "7";
    const CLASSES_MONK = "8";
    const CLASSES_DEMONHUNTER = "9";
    const CLASSES_MAGE = "10";
    const CLASSES_PRIEST = "11";
    const CLASSES_WARLOCK = "12";

    const TALENTS_WARRIOR_ARMS = "1";
    const TALENTS_WARRIOR_FURY = "2";
    const TALENTS_WARRIOR_PROTECTION = "3";
    const TALENTS_PALADIN_HOLY = "4";
    const TALENTS_PALADIN_PROTECTION = "5";
    const TALENTS_PALADIN_RETRIBUTION = "6";
    const TALENTS_DEATHKNIGHT_BLOOD = "7";
    const TALENTS_DEATHKNIGHT_FROST = "8";
    const TALENTS_DEATHKNIGHT_UNHOLY = "9";
    const TALENTS_HUNTER_BEASTMASTERY = "10";
    const TALENTS_HUNTER_MARKSMANSHIP = "11";
    const TALENTS_HUNTER_SURVIVAL = "12";
    const TALENTS_SHAMAN_ELEMENTAL = "13";
    const TALENTS_SHAMAN_ENHANCEMENT = "14";
    const TALENTS_SHAMAN_RESTORATION = "15";
    const TALENTS_ROUGUE_ASSASSINATION = "16";
    const TALENTS_ROUGUE_OUTLAW = "17";
    const TALENTS_ROUGUE_SUBTLETY = "18";
    const TALENTS_DRUID_BALANCE = "19";
    const TALENTS_DRUID_FERAL = "20";
    const TALENTS_DRUID_GUARDIAN = "21";
    const TALENTS_DRUID_RESTORATION = "22";
    const TALENTS_MONK_BREWMASTER = "23";
    const TALENTS_MONK_WINDWALKER = "24";
    const TALENTS_MONK_MISTWEAVER = "25";
    const TALENTS_DEMONHUNTER_HAVOC = "26";
    const TALENTS_DEMONHUNTER_VENGEANCE = "27";
    const TALENTS_MAGE_ARCANE = "28";
    const TALENTS_MAGE_FIRE = "29";
    const TALENTS_MAGE_FROST = "30";
    const TALENTS_PRIEST_DISCIPLINE = "31";
    const TALENTS_PRIEST_HOLY = "32";
    const TALENTS_PRIEST_SHADOW = "33";
    const TALENTS_WARLOCK_AFFLICTION = "34";
    const TALENTS_WARLOCK_DEMONOLOGY = "35";
    const TALENTS_WARLOCK_DESTRUCTION = "36";

    public static function getClassesList()
    {
        return array(
            self::CLASSES_WARRIOR => "战士",
            self::CLASSES_PALADIN => "圣骑士",
            self::CLASSES_DEATHKNIGHT => "死亡骑士",
            self::CLASSES_HUNTER => "猎人",
            self::CLASSES_SHAMAN => "萨满祭司",
            self::CLASSES_ROUGUE => "潜行者",
            self::CLASSES_DRUID => "德鲁伊",
            self::CLASSES_MONK => "武僧",
            self::CLASSES_DEMONHUNTER => "恶魔猎手",
            self::CLASSES_MAGE => "法师",
            self::CLASSES_PRIEST => "牧师",
            self::CLASSES_WARLOCK => "术士"
        );
    }

    public static function getTalentsList()
    {
        return array(
            self::CLASSES_WARRIOR => array(
                self::TALENTS_WARRIOR_ARMS => "武器",
                self::TALENTS_WARRIOR_FURY => "狂怒",
                self::TALENTS_WARRIOR_PROTECTION => "防御"
            ),
            self::CLASSES_PALADIN => array(
                self::TALENTS_PALADIN_HOLY => "神圣",
                self::TALENTS_PALADIN_PROTECTION => "防御",
                self::TALENTS_PALADIN_RETRIBUTION => "惩戒"
            ),
            self::CLASSES_DEATHKNIGHT => array(
                self::TALENTS_DEATHKNIGHT_BLOOD => "鲜血",
                self::TALENTS_DEATHKNIGHT_FROST => "冰霜",
                self::TALENTS_DEATHKNIGHT_UNHOLY => "邪恶"
            ),
            self::CLASSES_HUNTER => array(
                self::TALENTS_HUNTER_BEASTMASTERY => "野兽控制",
                self::TALENTS_HUNTER_MARKSMANSHIP => "射击",
                self::TALENTS_HUNTER_SURVIVAL => "生存"
            ),
            self::CLASSES_SHAMAN => array(
                self::TALENTS_SHAMAN_ELEMENTAL => "元素",
                self::TALENTS_SHAMAN_ENHANCEMENT => "增强",
                self::TALENTS_SHAMAN_RESTORATION => "恢复"
            ),
            self::CLASSES_ROUGUE => array(
                self::TALENTS_ROUGUE_ASSASSINATION => "奇袭",
                self::TALENTS_ROUGUE_OUTLAW => "狂徒",
                self::TALENTS_ROUGUE_SUBTLETY => "敏锐"
            ),
            self::CLASSES_DRUID => array(
                self::TALENTS_DRUID_BALANCE => "平衡",
                self::TALENTS_DRUID_FERAL => "野性",
                self::TALENTS_DRUID_GUARDIAN => "守护",
                self::TALENTS_DRUID_RESTORATION => "恢复"
            ),
            self::CLASSES_MONK => array(
                self::TALENTS_MONK_BREWMASTER => "酒仙",
                self::TALENTS_MONK_WINDWALKER => "踏风",
                self::TALENTS_MONK_MISTWEAVER => "织雾"
            ),
            self::CLASSES_DEMONHUNTER => array(
                self::TALENTS_DEMONHUNTER_HAVOC => "浩劫",
                self::TALENTS_DEMONHUNTER_VENGEANCE => "复仇"
            ),
            self::CLASSES_MAGE => array(
                self::TALENTS_MAGE_ARCANE => "奥术",
                self::TALENTS_MAGE_FIRE => "火焰",
                self::TALENTS_MAGE_FROST => "冰霜"
            ),
            self::CLASSES_PRIEST => array(
                self::TALENTS_PRIEST_DISCIPLINE => "戒律",
                self::TALENTS_PRIEST_HOLY => "神圣",
                self::TALENTS_PRIEST_SHADOW => "暗影"
            ),
            self::CLASSES_WARLOCK => array(
                self::TALENTS_WARLOCK_AFFLICTION => "痛苦",
                self::TALENTS_WARLOCK_DEMONOLOGY => "恶魔学识",
                self::TALENTS_WARLOCK_DESTRUCTION => "毁灭"
            )
        );
    }

    public static function getDutyList()
    {
        return array(
            self::DUTY_TANK_STR => "坦克(力量)",
            self::DUTY_TANK_AGI => "坦克(敏捷)",
            self::DUTY_DAMAGE_STR => "输出(力量)",
            self::DUTY_DAMAGE_AGI_CLS => "输出(敏捷近战)",
            self::DUTY_DAMAGE_AGI_RMT => "输出(敏捷远程)",
            self::DUTY_DAMAGE_SPELL => "输出(法术)",
            self::DUTY_DAMAGE_TREAT => "治疗"
        );
    }

    public static function getDutyConfigList()
    {
        return array(
            self::DUTY_TANK_STR => array(
                self::CLASSES_WARRIOR => array(
                    self::TALENTS_WARRIOR_PROTECTION => "防御"
                ),
                self::CLASSES_PALADIN => array(
                    self::TALENTS_PALADIN_PROTECTION => "防御"
                ),
                self::CLASSES_DEATHKNIGHT => array(
                    self::TALENTS_DEATHKNIGHT_BLOOD => "鲜血"
                )
            ),
            self::DUTY_TANK_AGI => array(
                self::CLASSES_DRUID => array(
                    self::TALENTS_DRUID_FERAL => "野性"
                ),
                self::CLASSES_MONK => array(
                    self::TALENTS_MONK_BREWMASTER => "酒仙"
                ),
                self::CLASSES_DEMONHUNTER => array(
                    self::TALENTS_DEMONHUNTER_VENGEANCE => "复仇"
                )
            ),
            self::DUTY_DAMAGE_STR => array(
                self::CLASSES_WARRIOR => array(
                    self::TALENTS_WARRIOR_ARMS => "武器",
                    self::TALENTS_WARRIOR_FURY => "狂怒"
                ),
                self::CLASSES_PALADIN => array(
                    self::TALENTS_PALADIN_RETRIBUTION => "惩戒"
                ),
                self::CLASSES_DEATHKNIGHT => array(
                    self::TALENTS_DEATHKNIGHT_FROST => "冰霜",
                    self::TALENTS_DEATHKNIGHT_UNHOLY => "邪恶"
                )
            ),
            self::DUTY_DAMAGE_AGI_CLS => array(
                self::CLASSES_HUNTER => array(
                    self::TALENTS_HUNTER_SURVIVAL => "生存"
                ),
                self::CLASSES_SHAMAN => array(
                    self::TALENTS_SHAMAN_ENHANCEMENT => "增强"
                ),
                self::CLASSES_ROUGUE => array(
                    self::TALENTS_ROUGUE_ASSASSINATION => "奇袭",
                    self::TALENTS_ROUGUE_OUTLAW => "狂徒",
                    self::TALENTS_ROUGUE_SUBTLETY => "敏锐"
                ),
                self::CLASSES_DRUID => array(
                    self::TALENTS_DRUID_FERAL => "野性"
                ),
                self::CLASSES_MONK => array(
                    self::TALENTS_MONK_WINDWALKER => "踏风"
                ),
                self::CLASSES_DEMONHUNTER => array(
                    self::TALENTS_DEMONHUNTER_HAVOC => "浩劫"
                )
            ),
            self::DUTY_DAMAGE_AGI_RMT => array(
                self::CLASSES_HUNTER => array(
                    self::TALENTS_HUNTER_BEASTMASTERY => "野兽控制",
                    self::TALENTS_HUNTER_MARKSMANSHIP => "射击"
                )
            ),
            self::DUTY_DAMAGE_SPELL => array(
                self::CLASSES_SHAMAN => array(
                    self::TALENTS_SHAMAN_ELEMENTAL => "元素"
                ),
                self::CLASSES_DRUID => array(
                    self::TALENTS_DRUID_BALANCE => "平衡"
                ),
                self::CLASSES_MAGE => array(
                    self::TALENTS_MAGE_ARCANE => "奥术",
                    self::TALENTS_MAGE_FIRE => "火焰",
                    self::TALENTS_MAGE_FROST => "冰霜"
                ),
                self::CLASSES_PRIEST => array(
                    self::TALENTS_PRIEST_SHADOW => "暗影"
                ),
                self::CLASSES_WARLOCK => array(
                    self::TALENTS_WARLOCK_AFFLICTION => "痛苦",
                    self::TALENTS_WARLOCK_DEMONOLOGY => "恶魔学识",
                    self::TALENTS_WARLOCK_DESTRUCTION => "毁灭"
                )
            ),
            self::DUTY_DAMAGE_TREAT => array(
                self::CLASSES_PALADIN => array(
                    self::TALENTS_PALADIN_HOLY => "神圣"
                ),
                self::CLASSES_SHAMAN => array(
                    self::TALENTS_SHAMAN_RESTORATION => "恢复"
                ),
                self::CLASSES_DRUID => array(
                    self::TALENTS_DRUID_RESTORATION => "恢复"
                ),
                self::CLASSES_MONK => array(
                    self::TALENTS_MONK_MISTWEAVER => "织雾"
                ),
                self::CLASSES_PRIEST => array(
                    self::TALENTS_PRIEST_DISCIPLINE => "戒律",
                    self::TALENTS_PRIEST_HOLY => "神圣"
                )
            )
        );
    }
}
?>