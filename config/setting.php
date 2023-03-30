<?php

return [
    /*
     * 路徑列表
     */
    'usagiDomain' => 'https://www.gomaji.com',  // 新大小網
    'narutoDomain' => 'https://www.gomaji.com',  // 舊官網

    /*
     * cookie
     */
    'cookie' => [
        'oneDayTs' => 86400, // 一天的秒數
        'oneHourTs' => 3600, // 一小時的秒數
        'oneMinuteTs' => 60, // 一分鐘的秒數
        'gmjDomain' => '.gomaji.com', // cookie 儲存的網域
        'secure' => true,
        'httponly' => true,
    ],
];
