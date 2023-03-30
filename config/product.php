<?php

return [
    /*
     * 票券類型
     */
    'tkType' => [
        'limit' => 1, // 限時
        'long' => 2, // 長銷
        'cycle' => 3, // 週期性
    ],

    /*
     * 促銷活動類型
     */
    'promoteType' => [
        'ae' => 3, // AE 檔次
    ],

    /*
     * 份數的顯示類型
     */
    'displayFlag' => [
        'none' => 0, // 不顯示
        'orderNo' => 1, // 顯示銷售份數
        'remainNo' => 2, // 顯示剩餘份數
    ],

    /*
    * 檔次分類編號
    */
    'kindId' => [
        'rsPid' => 1, // RS 檔次，以 product_id 為主
        'rsGid' => 2, // RS 檔次，以 group_id 為主
        'es' => 3, // ES、OTA 檔次
        'ad' => 4, // Fake Product（廣告檔次）
        'carousel' => 5, // 橫向企劃列表
        'coffee' => 6, // 咖啡檔次
        'dd' => 7, // 大小 DD
        'ob' => 8, // Outbound 檔次
        'buy123' => 9, // 生活市集檔次
        'ean' => 10, // EAN 檔次
        'esMarket' => 11, // EsMarket 海外旅遊
        'shopify' => 12, // Shopify 檔次
    ],

    /*
    * 類別編號
    */
    'categoryId' => [
        'indoorGame' => 2, // 室內娛樂
        'exhibitionPerformance' => 26, // 展覽演出
        'ticket' => 34, // 餐券、票券
        'casual' => 58, // 親子、休閒
        'travelAbroad' => 136, // 國外旅遊、郵輪
        'overseaTicket' => 359, // 海外票券
        'foreignTicket' => 360, // 國外票券
    ]
];
