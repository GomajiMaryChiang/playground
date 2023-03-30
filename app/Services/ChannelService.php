<?php

namespace App\Services;

use Config;

class ChannelService
{
    /**
     * 頻道頁的Canonical URL重構
     * @param  int   $ch       頻道ID
     * @param  int   $category 熱門類別
     * @param  array $locationInfo 位置資料，包含 $city, $distGroup, $region, $spot
     * @param  int   $type     0 = 僅處理參數，網址列不做處理；1 = /ch/7?category=15 轉換成 /ch/700015?
     * @return string
    */
    public function cannonicalUrlRefactor($ch = 0, $categoryId = 0, $locationInfo = [], $type = 0)
    {
        switch ($ch) {
            case Config::get('channel.id.es'):
                $paramCheck = ['region' => $locationInfo['region'], 'city' => $locationInfo['city'], 'spot' => $locationInfo['spot']];
                break;
            case Config::get('channel.id.sh'):
                $paramCheck = []; // 宅配頻道根據 SEO 檔案，不帶任何地區參數
                break;
            default:
                $paramCheck = ['city' => $locationInfo['city'], 'dist_group' => $locationInfo['distGroup']];
                break;
        }
        $urlParsed = parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        if (!empty($urlParsed['query'])) {
            parse_str($urlParsed['query'], $queryParsed); // $urlParsed['query'] 陣列化
        }
        $urlRefactor = explode('/', $urlParsed['path']); // $urlParsed['path'] 陣列化 ex:['usagi.gomaji.com', 'ch', '7']
        if (in_array('channel', $urlRefactor) || is_string(end($urlRefactor))) {
            // 如果網址列有 channel 字樣、或最後值為字串，代表為 /channel/restaurant、/channel/beauty 等頻道舊別名
            $valueConvert = array_map(function ($value) {
                switch ($value) {
                    case 'channel':
                        return 'ch';
                    case 'restaurant':
                        return Config::get('channel.id.rs');
                    case 'beauty':
                        return Config::get('channel.id.bt');
                    case 'travel':
                        return Config::get('channel.id.es');
                    case 'shipping':
                        return Config::get('channel.id.sh');
                    case 'qk':
                        return Config::get('channel.id.qk');
                    case 'massage':
                        return Config::get('channel.id.mass');
                    case 'life':
                        return Config::get('channel.id.lfn');
                }
                return $value;
            }, $urlRefactor);
            $urlRefactor = $valueConvert;
        }

        $canonicalParams = []; // 最終要塞入 CanonicalURL 的參數

        if ($type == 1) {
            if ($categoryId < 100000) {
                array_pop($urlRefactor); // channel 值去除掉
                array_push($urlRefactor, ($ch * 100000) + $categoryId); // channel 跟 category 值合併塞回
            } else {
                // 若 $categoryId > 100000，代表為 100002「今天上架」、100003「倒數」等類別，不轉換 Canonical URL
                $canonicalParams['category'] = $categoryId; // 直接把 category 塞入最終 Canonical 呈現的參數陣列
            }
        }

        foreach ($paramCheck as $key => $value) {
            // $queryParsed[] 內有必須參數的帶入 $canonicalParams[]；沒有的話則使用預設值
            $canonicalParams[$key] = (!empty($queryParsed[$key])) ? $queryParsed[$key] : $value;
        }

        return 'https://' . implode('/', $urlRefactor) . '?' . http_build_query($canonicalParams);
    }

    /**
     * 取得Category頁面的Breadcrumb
     * @param  int    $id    類別ID
     * @param  array  $data  類別資料
     * @return string
     */
    public function getSubChTitle($id = 0, $data = [])
    {
        // 如類別是「全部」直接返回，沒有 subChTitle
        if (empty($id) || empty($data) || !is_array($data)) {
            return '';
        }

        $subChTitle = '';
        foreach ($data as $key => $value) {
            $catId = $value['cat_id'] ?? 0;
            if ($id == $catId) {
                $subChTitle = $value['cat_name'] ?? '';
                break;
            }
        }

        return $subChTitle;
    }

    /**
     * 設定Category按鈕的網址參數
     * @param  array  $data  類別資料
     * @return string
     */
    public function getCategoryLink($data = [], $city = 0, $distGroup = 0, $region = 0, $spot = 0)
    {
        $cat_id = (!empty($data['cat_id']) ? $data['cat_id'] : 0);
        $ch_id = (!empty($data['ch_id']) ? $data['ch_id'] : 0);
        $action = (!empty($data['action']) ? $data['action'] : '');

        // 宅配頻道、熱門類別區塊，使用特定連結的目標
        if ($action == 'url') {
            return $data['link_url'];
        }

        if ($cat_id > 100000) {
            $link = sprintf('/ch/%s?category=%s', $ch_id, $cat_id);
        } else {
            $link = sprintf('/ch/%s?', ($ch_id * 100000 + $cat_id));
        }

        // 宅配頻道固定 city = 7 故類別標籤也不進行城市&地區的參數處理
        if ($ch_id != Config::get('channel.id.sh')) {
            $sign = (substr($link, -1) == '?') ? '' : '&';
            $link .= sprintf('%scity=%s', $sign, $city);
            // 如果是ES頻道額外處理
            if (Config::get('channel.id.es') == $ch_id) {
                $link = sprintf('%s&region=%s&spot=%s', $link, $region, $spot);
            } else {
                $link = sprintf('%s&dist_group=%s', $link, $distGroup);
            }
        }

        // 「全部按鈕」-> 回到Channel首頁，僅保留$city變數
        if (0 == $cat_id) {
            $link = (Config::get('channel.id.sh') != $ch_id) ? sprintf('/ch/%s?city=%s', $ch_id, $city) : sprintf('/ch/%s?', $ch_id);
        }

        return $link;
    }

    /**
     * ES Channel網址列模式陣列
     * @return array
     */
    public function getRegionPattern()
    {
        return array(
            0 => 'region=0',
            1 => 'region=1',
            2 => 'region=1&city=1',
            3 => 'region=1&city=1&spot=45',
            4 => 'region=1&city=1&spot=67',
            5 => 'region=1&city=1&spot=46',
            6 => 'region=1&city=1&spot=47',
            7 => 'region=1&city=1&spot=48',
            8 => 'region=1&city=1&spot=49',
            9 => 'region=1&city=1&spot=50',
            10 => 'region=1&city=17',
            11 => 'region=1&city=2',
            12 => 'region=1&city=3',
            13 => 'region=1&city=8',
            14 => 'region=1&city=8&spot=51',
            15 => 'region=2',
            16 => 'region=2&city=4',
            17 => 'region=2&city=4&spot=52',
            18 => 'region=2&city=4&spot=53',
            19 => 'region=2&city=9',
            20 => 'region=2&city=10',
            21 => 'region=2&city=10&spot=54',
            22 => 'region=2&city=10&spot=55',
            23 => 'region=2&city=10&spot=56',
            24 => 'region=2&city=10&spot=57',
            25 => 'region=3',
            26 => 'region=3&city=11',
            27 => 'region=3&city=12',
            28 => 'region=3&city=12&spot=65',
            29 => 'region=3&city=5',
            30 => 'region=3&city=6',
            31 => 'region=3&city=13',
            32 => 'region=3&city=13&spot=58',
            33 => 'region=3&city=13&spot=59',
            34 => 'region=3&city=13&spot=60',
            35 => 'region=4',
            36 => 'region=4&city=16',
            37 => 'region=4&city=16&spot=61',
            38 => 'region=4&city=16&spot=62',
            39 => 'region=4&city=15',
            40 => 'region=4&city=14',
            41 => 'region=4&city=14&spot=63',
            42 => 'region=4&city=14&spot=66',
            43 => 'region=4&city=18',
            44 => 'region=4&city=18&spot=64',
        );
    }

    /**
     * 檢測主打星內容與顯示與否的設定
     * @param  int     $ch    頻道
     * @param  int     $city  城市
     * @param  array   $data  主打星資料
     * @return int
     */
    public function popupAd($ch, $city, $data)
    {
        if ($ch == 2) {
            // (旅遊尚未有城市區分)
            $popupAdDisplay = 'popupAdDisplay_' . $ch; // 顯示的主打星頁面
            $popupAdKey = 'popupAd_' . $ch; // 主打星key
        } else {
            $popupAdDisplay = 'popupAdDisplay_' . $ch . '_' . $city; // 顯示的主打星頁面
            $popupAdKey = 'popupAd_' . $ch . '_' . $city; // 主打星key
        }

        $showOriCount = (empty($_COOKIE[$popupAdKey])) ? 0 : explode('_', $_COOKIE[$popupAdKey])[1]; // 撈取已顯示主打星跳窗次數

        if ((empty($_COOKIE[$popupAdDisplay]) || ($_COOKIE[$popupAdDisplay] != $data['popup_event_id'])) && $data['enable'] == 1 || (($_COOKIE[$popupAdDisplay] == $data['popup_event_id']) && $data['enable'] == 1 && ($data['show_count'] > $showOriCount))) {
            // 主打星顯示次數累加
            if (empty($_COOKIE[$popupAdKey])) {
                $showCount = 1;
            } else {
                // 比對同頻道但是否為不同event_id的主打星
                if (explode('_', $_COOKIE[$popupAdKey])[0] != $data['popup_event_id']) {
                    $showCount = 1;
                } else {
                    $showOriCount = explode('_', $_COOKIE[$popupAdKey])[1];
                    $showCount = (int) $showOriCount + 1;
                }
            }

            // 尚未超過可顯示畫面次數
            if ($data['show_count'] >= $showCount) {
                // 主打星value
                $popupAdVal = $data['popup_event_id'] . '_' . $showCount;

                // 設定cookie的值
                setcookie($popupAdKey, $popupAdVal, 0, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
                $_COOKIE[$popupAdKey] = $popupAdVal;

                // 設定cookie的值時效15分鐘
                setcookie($popupAdDisplay, $data['popup_event_id'], time() + (60 * 15), '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
                $_COOKIE[$popupAdDisplay] = $data['popup_event_id'];

                // 設定於html頁面為顯示狀態
                return true;
            } else {
                // 設定於html頁面為不顯示狀態
                return false;
            }
        } else {
            //若沒有設定主打星的頻道
            if ($data['enable'] == 0) {
                // 設定cookie已經過期一小時
                setcookie($popupAdDisplay, 0, time() - 3600, '/', '.gomaji.com', true);
                // 設定顯示為空
                $_COOKIE[$popupAdDisplay] = '';
            }
            // 設定於html頁面為不顯示狀態
            return false;
        }
        // 紀錄主打星ID 和 已查看次數 -- end --
    }
}
