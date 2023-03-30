<?php

return [
    /*
     * 返利網的編號列表
     */
    'id' => [
        'maShop' => 457, // 美安
        'shopback' => 543, // Shopback
        'line' => 560, // Line
        'ichannels' => 565, // iChannels
        'lineTrav' => 581, // Line 旅遊
    ],

    /*
     * 返利網的名稱列表
     */
    'name' => [
        'ref_457' => '美安',
        'ref_543' => 'shopback',
        'ref_560' => 'LINE',
        'ref_565' => 'iChannels',
        'ref_581' => 'LINE 旅遊',
    ],

    /*
     * 返利網不可進入的頻道列表
     */
    'disablecCh' => [
        'ref_457' => [15, 23, 25, 27, 100],
        'ref_543' => [15, 18, 23, 25, 27, 100],
        'ref_560' => [15, 18, 23, 25, 27, 100],
        'ref_565' => [15, 18, 23, 25, 27, 100],
        'ref_581' => [15, 18, 23, 25, 27, 100],
    ],
];
