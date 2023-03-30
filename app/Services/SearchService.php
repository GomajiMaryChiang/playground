<?php

namespace App\Services;
use Config;

class SearchService
{
    /**
     * 紀錄搜尋關鍵字於cookie內
     * @return boolean
     */
    public function searchKeywords($keyword = '', $limit = 10)
    {
        // 如果關鍵字消失，直接回傳錯誤
        if (empty($keyword)) {
            return false;
        }

        $key = 'search-keywords';
        $expireTs = time() + (86400 * 7);

        $cookieKeywords = [];
        if (!empty($_COOKIE[$key])) {
            $tmpAry = json_decode($_COOKIE[$key], true);
            if (JSON_ERROR_NONE == json_last_error()) {
                $cookieKeywords = $tmpAry;
            }
        }

        // 新的搜尋關鍵字加入陣列
        $cookieKeywords[] = $keyword;
        // 移除重複出現關鍵字
        $cookieKeywords = array_unique($cookieKeywords);

        if (count($cookieKeywords) > $limit) {
            // 關鍵字超過設定數量，剔除最先前的搜尋關鍵字
            $cookieKeywords = array_slice($cookieKeywords, $limit * -1);
        }

        setcookie($key, json_encode($cookieKeywords), $expireTs, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));
        $_COOKIE[$key] = json_encode($cookieKeywords);

        return true;
    }
}
