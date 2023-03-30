<?php

return [
    /*
     * 頻道編號（英文名稱 => id）
     */
    'id' => [
        'es' => 2, // 旅遊
        'sh' => 4, // 宅配
        'tk' => 6, // 票券
        'rs' => 7, // 餐廳
        'bt' => 8, // 美容舒壓
        'lf' => 9, // 生活娛樂
        'coffee' => 15, // 咖啡
        'lfn' => 17, // 休閒娛樂
        'buy123' => 18, // 生活市集
        'qk' => 20, // 休息
        'mass' => 22, // 按摩
        'aff' => 23, // 聰明賺點
        'ta' => 24, // 訂餐外帶
        'esMarket' => 25, // 海外旅遊
        'shopify' => 27, // 宅配嚴選
    ],

    /*
     * 頻道中文名稱（id => 中文名稱）
     */
    'chName' => [
        2 => '旅遊住宿',
        4 => '宅配美食',
        6 => '票券',
        7 => '美食餐廳',
        8 => '美容舒壓',
        9 => '生活娛樂',
        15 => '麻吉咖啡館',
        17 => '休閒娛樂',
        18 => '宅配購物+',
        20 => '泡湯休息',
        22 => '按摩',
        23 => '聰明賺點',
        24 => '訂餐外帶',
        25 => '旅遊行程',
        27 => '宅配嚴選',
    ],

    /*
     * 首頁頻道列表
     */
    'homeList' => [
        7 => [
            'title' => '美食餐廳',
            'icon' => '/images/channel/new_index_rs_icon.png?1638236309',
            'badge' => '',
            'url' => '/ch/7',
        ],
        24 => [
            'title' => '訂餐外帶',
            'icon' => '/images/channel/new_index_togo_icon.png?1654496346',
            'badge' => '',
            'url' => '/ch/24',
        ],
        8 => [
            'title' => '美容舒壓',
            'icon' => 'images/channel/new_index_bt_icon.png?1638236309',
            'badge' => '',
            'url' => '/ch/8',
        ],
        22 => [
            'title' => '按摩',
            'icon' => '/images/channel/new_index_massage_icon.png?1638236309',
            'badge' => '',
            'url' => '/ch/22',
        ],
        2 => [
            'title' => '旅遊住宿',
            'icon' => '/images/channel/new_index_es_icon.png?1638236309',
            'badge' => '',
            'url' => '/ch/2',
        ],
        20 => [
            'title' => '泡湯休息',
            'icon' => '/images/channel/new_index_hotelrest_icon.png?1638236309',
            'badge' => '',
            'url' => '/ch/20',
        ],
        4 => [
            'title' => '宅配美食',
            'icon' => '/images/channel/new_index_sh_icon_1.png?1658807998',
            'badge' => '',
            'url' => '/ch/4',
        ],
        27 => [
            'title' => '宅配嚴選',
            'icon' => '/images/channel/new_index_sh_selected_icon.png?1667895526',
            'badge' => '',
            'url' => 'https://shop.gomaji.com',
        ],
        25 => [
            'title' => '旅遊行程',
            'icon' => '/images/channel/new_index_travel_icon.png',
            'badge' => '',
            'url' => 'https://www.trippacker.com.tw/',
        ],
        18 => [
            'title' => '宅配購物+',
            'icon' => '/images/channel/new_index_buy_icon.png?1638236309',
            'badge' => '',
            'url' => 'https://buy123.gomaji.com',
        ],
        100 => [
            'title' => '澳洲直送',
            'icon' => '/images/channel/new_index_australia_icon.png?1672043665',
            'badge' => '',
            'url' => 'https://ozways.com/zh-tw',
        ],
        17 => [
            'title' => '休閒娛樂',
            'icon' => '/images/channel/new_index_lfn_icon.png?1669781582',
            'badge' => '',
            'url' => '/ch/17',
        ],
        101 => [
            'title' => '免開票費',
            'icon' => '/images/channel/new_index_flashsale_free_icon.png?1672043665',
            'badge' => '',
            'url' => 'https://event.gomaji.com/event/pcode/flashsale_free/',
        ],
        102 => [
            'title' => '銀行優惠',
            'icon' => '/images/channel/new_index_bank_icon.png?1672043665',
            'badge' => '',
            'url' => 'https://event.gomaji.com/event/201510/MAJIBANK/',
        ],
    ],

    /*
     * 頻道頁列表
     */
    'channelList' => [
        2, 4, 7, 8, 9, 15, 17, 20, 22, 24
    ],
];
