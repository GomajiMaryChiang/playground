<?php

namespace App\Services;

use Config;
use Illuminate\Http\Request;

class MetaService
{
    /**
     * 依據參數名稱轉換字串
     * @param string $bindString 轉換的字串
     * @param array  $bindAry    轉換的參數
     * @return string
     */
    public function bindValue($bindString = '', $bindAry = [])
    {
        // 檢查參數
        if (empty($bindString) || empty($bindAry) || !is_array($bindAry)) {
            return '';
        }

        // 如沒有第一個店家名稱，不顯示第一個店家名稱及後面全部的字串
        $storeName1Key = ':storeName1';
        if (empty($bindAry[$storeName1Key]) && mb_strpos($bindString, $storeName1Key) !== false) {
            $bindString = explode($storeName1Key, $bindString)[0];
        }

        // 如沒有第二個店家名稱，不顯示第二個店家名稱及前面一個頓號
        $storeName2Key = ':storeName2';
        $storeName2SearchKey = '、:storeName2';
        if (empty($bindAry[$storeName2Key]) && mb_strpos($bindString, $storeName2SearchKey) !== false) {
            $bindString = str_replace($storeName2SearchKey, '', $bindString);
        }

        // 如沒有第三個店家名稱，不顯示第三個店家名稱及前面一個頓號
        $storeName3Key = ':storeName3';
        $storeName3SearchKey = '、:storeName3';
        if (empty($bindAry[$storeName3Key]) && mb_strpos($bindString, $storeName3SearchKey) !== false) {
            $bindString = str_replace($storeName3SearchKey, '', $bindString);
        }

        // 如有公益名稱，僅顯示 】符號後的公益名稱
        $publicWelfareNameKey = ':publicWelfareName';
        $publicWelfareNameSearchKey = '】';
        if (
            !empty($bindAry[$publicWelfareNameKey])
            && mb_strpos($bindString, $publicWelfareNameKey) !== false
            && mb_strpos($bindAry[$publicWelfareNameKey], $publicWelfareNameSearchKey) !== false
        ) {
            $bindAry[$publicWelfareNameKey] = explode($publicWelfareNameSearchKey, $bindAry[$publicWelfareNameKey])[1] ?? '';
        }

        return strtr($bindString, $bindAry);
    }
}
