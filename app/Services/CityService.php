<?php

namespace App\Services;

use Config;
use Illuminate\Http\Request;

class CityService
{
    /**
     * 取得城市列表
     *   - 目前 pc 有城市資訊的頁面：首頁、搜尋頁、各頻道頁、各頻道分流頁
     *   - 目前 mm 有城市資訊的頁面：首頁、各頻道頁
     * @param int $chId        頻道編號
     * @param int $cityId      城市ID
     * @param int $distGroupId 行政區ID（非 ES 用）
     * @param int $regionId    地區ID（ ES 用）
     * @param int $spotId      景點ID（ ES 用）
     * @return array
     */
    public function getCityData($chId = 0, $cityId = 0, $distGroupId = 0, $regionId = 0, $spotId = 0)
    {
        $cityList = [];
        $activeCity = [];
        $isShowThirdLayer = false;

        // 處理頻道編號裡包含類別編號的情況
        $chId = ($chId > 100000 ? floor($chId / 100000) : $chId);

        switch ($chId) {
            case 0: // 首頁＆搜尋頁
                $cityList = Config::get('city.cityList');
                unset($cityList[0]); // 刪掉“全國地區”
                $cityList[1]['subCity'] = []; // 刪掉行政區“大台北”
                $cityList[4]['subCity'] = []; // 刪掉行政區”台中”
                $cityList[6]['subCity'] = []; // 刪掉行政區”高雄”
                $activeCity = $cityList[$cityId] ?? $cityList[1];
                break;
            case Config::get('channel.id.es'):
                $cityList = Config::get('city.regionList');
                $activeCity = $cityList[$regionId]['subCity'][$cityId]['subCity'][$spotId] ?? $cityList[$regionId]['subCity'][$cityId] ?? $cityList[$regionId] ?? $cityList[0];
                $isShowThirdLayer = true;
                break;
            case Config::get('channel.id.lfn'):
                $cityList = Config::get('city.cityList');
                $activeCity = $cityList[$cityId]['subCity'][$distGroupId] ?? $cityList[$cityId] ?? $cityList[0];
                break;
            default: // 其他頻道
                $cityList = Config::get('city.cityList');
                unset($cityList[0]); // 刪掉“全國地區”
                $activeCity = $cityList[$cityId]['subCity'][$distGroupId] ?? $cityList[$cityId] ?? $cityList[1];
                break;
        }

        $url = 'https://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'])['path'] . '?';
        $activeName = $activeCity['name'];

        return [
            'url' => $url,
            'activeName' => $activeName,
            'cityList' => $cityList,
            'isShowThirdLayer' => $isShowThirdLayer,
        ];
    }

    /**
     * 從網址列get參數或cookie取得城市的值
     * @param request $request
     * @param string  $cookieName   cookie名稱
     * @param int     $paramValue   網址列get參數名稱
     * @param int     $defaultValue cookie預設值
     * @return int
     */
    public function getCityValue(Request $request, $cookieName = '', $paramValue = '', $defaultValue = 0)
    {
        $paramValue = $request->input($paramValue, null);
        $cookieName = 'gc_' . $cookieName;
        $value = $defaultValue;

        // 如果 get 參數並無指定內容值，取 cookie 的值
        if (isset($paramValue)) {
            $value = htmlspecialchars(strip_tags($paramValue), ENT_QUOTES);
        } elseif (isset($_COOKIE[$cookieName])) {
            $value = $_COOKIE[$cookieName];
        }

        $value = intval($value);
        if (empty($value) || $value < $defaultValue) {
            $value = $defaultValue;
        }

        setcookie($cookieName, $value, time() + 86400 * 7, '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));

        return $value;
    }

    /**
     * 檢查城市相關參數的內容值（Passing by Reference）
     * @param int   $chId        頻道編號
     * @param array $cityList    城市列表
     * @param int   $cityId      城市ID
     * @param int   $distGroupId 行政區ID（非 ES 用）
     * @param int   $regionId    地區ID（ ES 用）
     * @param int   $spotId      景點ID（ ES 用）
     */
    public function checkCityValue($chId = 0, $cityList = [], &$cityId = 0, &$distGroupId = 0, &$regionId = 0, &$spotId = 0)
    {
        // 處理頻道編號裡包含類別編號的情況
        $chId = ($chId > 100000 ? floor($chId / 100000) : $chId);

        // 旅遊頻道的城市列表組成方式不同
        if ($chId == Config::get('channel.id.es')) {
            // 判斷地區ID、城市ID、景點ID的值是否正確
            if (!empty($regionId) && !isset($cityList[$regionId])) {
                $regionId = array_key_first($cityList) ?? 0;
            }

            if (!empty($cityId) && !isset($cityList[$regionId]['subCity'][$cityId])) {
                $cityId = 0;
            }

            if (!empty($spotId) && !isset($cityList[$regionId]['subCity'][$cityId]['subCity'][$spotId])) {
                $spotId = 0;
            }
        } else {
            // 判斷城市ID、行政區ID的值是否正確
            if (!empty($cityId) && !isset($cityList[$cityId])) {
                $cityId = array_key_first($cityList) ?? 0;
            }

            if (!empty($distGroupId) && !isset($cityList[$cityId]['subCity'][$distGroupId])) {
                $distGroupId = 0;
            }
        }
    }
}
