<?php

/**
 * 数据库应用类-hearth_stone_card
 * @author Kinsama
 * @version 2017-03-05
 */
class IohHearthStoneCardEntity
{
    // 职业代码
    const CLASS_DRUID = 1;
    const CLASS_HUNTER = 2;
    const CLASS_MAGE = 3;
    const CLASS_PALADIN = 4;
    const CLASS_PRIEST = 5;
    const CLASS_ROGUE = 6;
    const CLASS_SHAMAN = 7;
    const CLASS_WARLOCK = 8;
    const CLASS_WARRIOR = 9;
    const CLASS_NEUTRAL = 10;
    // 类型
    const TYPE_MINION = 1;
    const TYPE_WEAPON = 2;
    const TYPE_SPELL = 3;
    const TYPE_HERO = 4;
    // 品质代码
    const QUALITY_COMMON = 1;
    const QUALITY_RARE = 2;
    const QUALITY_EPIC = 3;
    const QUALITY_LEGEND = 4;
    // 随从类型代码
    const MINION_BEAST = 1;
    const MINION_TOTEM = 2;
    const MINION_DEMON = 3;
    const MINION_MURLOC = 4;
    const MINION_PIRATE = 5;
    const MINION_DRAGON = 6;
    const MINION_MECH = 7;
    const MINION_ELEMENTAL = 8;
    const MINION_ALL = 9;
    // 来源代码
    const FROM_BSC = 1;
    const FROM_CLS = 2;
    const FROM_RWD = 3;
    const FROM_NAX = 4;
    const FROM_GVG = 5;
    const FROM_BRM = 6;
    const FROM_TGT = 7;
    const FROM_LOE = 8;
    const FROM_WOD = 9;
    const FROM_KLZ = 10;
    const FROM_MSG = 11;
    const FROM_JTU = 12;
    const FROM_KFT = 13;
    const FROM_KAC = 14;
    const FROM_TWW = 15;
    // 帮派代码
    const GROUP_GRIMYGOONS = 1;
    const GROUP_JADELOTUS = 2;
    const GROUP_KABAL = 3;
    // 全部选取代码
    const SELECT_ALL = "a";

    public static function getEntityName()
    {
        return "hearth_stone_card";
    }

    public static function getVolumnName()
    {
        return array(
            'c_id' => '卡牌ID',
            'c_mode' => '模式',
            'c_class' => '职业',
            'c_type' => '类型',
            'c_cost' => '消耗',
            'c_name' => '名称',
            'c_quality' => '品质',
            'c_attack' => '攻击',
            'c_health' => '生命',
            'c_minion' => '随从类型',
            'c_group' => '帮派',
            'c_descript' => '描述',
            'c_funny' => '趣文',
            'c_from' => '来源',
            'c_beast_flg' => '野兽',
            'c_totem_flg' => '图腾',
            'c_demon_flg' => '恶魔',
            'c_murloc_flg' => '鱼人',
            'c_pirate_flg' => '海盗',
            'c_dragon_flg' => '龙',
            'c_mech_flg' => '机械',
            'c_elemental_flg' => '元素',
            'c_battlecry_flg' => '战吼',
            'c_deathrattle_flg' => '亡语',
            'c_charge_flg' => '冲锋',
            'c_taunt_flg' => '嘲讽',
            'c_stealth_flg' => '潜行',
            'c_divineshield_flg' => '圣盾',
            'c_windfury_flg' => '风怒',
            'c_spelldamage_flg' => '法术伤害',
            'c_choose_flg' => '抉择',
            'c_secret_flg' => '奥秘',
            'c_combo_flg' => '连击',
            'c_overload_flg' => '过载',
            // 'c_enrage_flg' => '激怒',
            'c_counter_flg' => '反制',
            'c_freeze_flg' => '冻结',
            'c_silence_flg' => '沉默',
            'c_immune_flg' => '免疫',
            'c_sparepart_flg' => '零件',
            'c_inspire_flg' => '激励',
            'c_discover_flg' => '发现',
            'c_jadegolem_flg' => '青玉魔像',
            'c_poisonous_flg' => '剧毒',
            'c_adapt_flg' => '进化',
            'c_quest_flg' => '任务',
            'c_lifesteal_flg' => '吸血',
            'c_recruit_flg' => '招募',
            'c_rush_flg' => '突袭',
            'c_echo_flg' => '回响'
        );
    }

    public static function getCodeList()
    {
        return array(
            'c_class' => array(
                self::CLASS_DRUID => '德鲁伊',
                self::CLASS_HUNTER => '猎人',
                self::CLASS_MAGE => '法师',
                self::CLASS_PALADIN => '圣骑士',
                self::CLASS_PRIEST => '牧师',
                self::CLASS_ROGUE => '潜行者',
                self::CLASS_SHAMAN => '萨满祭司',
                self::CLASS_WARLOCK => '术士',
                self::CLASS_WARRIOR => '战士',
                self::CLASS_NEUTRAL => '中立'
            ),
            'c_type' => array(
                self::TYPE_MINION => '随从',
                self::TYPE_WEAPON => '武器',
                self::TYPE_SPELL => '法术',
                self::TYPE_HERO => '英雄'
            ),
            'c_quality' => array(
                self::QUALITY_COMMON => '普通',
                self::QUALITY_RARE => '稀有',
                self::QUALITY_EPIC => '史诗',
                self::QUALITY_LEGEND => '传说'
            ),
            'c_minion' => array(
                self::MINION_BEAST => '野兽',
                self::MINION_TOTEM => '图腾',
                self::MINION_DEMON => '恶魔',
                self::MINION_MURLOC => '鱼人',
                self::MINION_PIRATE => '海盗',
                self::MINION_DRAGON => '龙',
                self::MINION_MECH => '机械',
                self::MINION_ELEMENTAL => '元素',
                self::MINION_ALL => '全部'
            ),
            'c_from' => array(
                self::FROM_BSC => '基本',
                self::FROM_CLS => '经典',
                self::FROM_RWD => '荣誉室',
                self::FROM_NAX => '纳克萨玛斯的诅咒',
                self::FROM_GVG => '地精大战侏儒',
                self::FROM_BRM => '黑石山的火焰',
                self::FROM_TGT => '冠军的试炼',
                self::FROM_LOE => '探险者协会',
                self::FROM_WOD => '上古之神的低语',
                self::FROM_KLZ => '卡拉赞之夜',
                self::FROM_MSG => '龙争虎斗加基森',
                self::FROM_JTU => '勇闯安戈洛',
                self::FROM_KFT => '冰封王座的骑士',
                self::FROM_KAC => '狗头人与地下世界',
                self::FROM_TWW => '女巫森林'
            ),
            'c_group' => array(
                self::GROUP_GRIMYGOONS => '污手党',
                self::GROUP_JADELOTUS => '青莲帮',
                self::GROUP_KABAL => '暗金教'
            )
        );
    }

    public static function getColorList()
    {
        return array(
            'c_class' => array(
                self::CLASS_DRUID => 'FF7C0A',
                self::CLASS_HUNTER => 'AAD372',
                self::CLASS_MAGE => '68CCEF',
                self::CLASS_PALADIN => 'F48CBA',
                self::CLASS_PRIEST => 'F0EBE0',
                self::CLASS_ROGUE => 'FFF468',
                self::CLASS_SHAMAN => '2359FF',
                self::CLASS_WARLOCK => '9382C9',
                self::CLASS_WARRIOR => 'C69B6D',
                self::CLASS_NEUTRAL => 'AAAAAA'
            ),
            'c_quality' => array(
                self::QUALITY_COMMON => 'FFFFFF',
                self::QUALITY_RARE => '0081FF',
                self::QUALITY_EPIC => 'C600FF',
                self::QUALITY_LEGEND => 'FF8000'
            )
        );
    }

    public static function getNotNullVolumnName()
    {
        return array(
            'info' => array(
                'c_id',
                'c_mode',
                'c_class',
                'c_type',
                'c_cost',
                'c_name',
                'c_quality',
                'c_attack',
                'c_health',
                'c_minion',
                'c_group',
                'c_descript',
                'c_funny',
                'c_from'
            ),
            'keyword' => array(
                'c_beast_flg',
                'c_totem_flg',
                'c_demon_flg',
                'c_murloc_flg',
                'c_pirate_flg',
                'c_dragon_flg',
                'c_mech_flg',
                'c_elemental_flg',
                'c_battlecry_flg',
                'c_deathrattle_flg',
                'c_charge_flg',
                'c_taunt_flg',
                'c_stealth_flg',
                'c_divineshield_flg',
                'c_windfury_flg',
                'c_spelldamage_flg',
                'c_choose_flg',
                'c_secret_flg',
                'c_combo_flg',
                'c_overload_flg',
                // 'c_enrage_flg',
                'c_counter_flg',
                'c_freeze_flg',
                'c_silence_flg',
                'c_immune_flg',
                'c_sparepart_flg',
                'c_inspire_flg',
                'c_discover_flg',
                'c_jadegolem_flg',
                'c_poisonous_flg',
                'c_adapt_flg',
                'c_quest_flg',
                'c_lifesteal_flg',
                'c_recruit_flg',
                'c_rush_flg',
                'c_echo_flg'
            )
        );
    }
}
?>