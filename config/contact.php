<?php

return [
    /*
     * 聯絡我們-項目
     */
    'id' => [
        'query' => 6, // 商品諮詢
        'refund' => 7, // 退費問題
        'complain' => 8, // 問題申訴
        'others' => 10, // 其他&建議事項
        'cooperation' => 11, // 店家合作
        'media' => 22, // 行銷合作與媒體公關
    ],

    'recaptcha_site_key' => env('RECAPTCHA_SITE_KEY', ''),
    'recaptcha_secret' => env('RECAPTCHA_SECRET', ''),
];
