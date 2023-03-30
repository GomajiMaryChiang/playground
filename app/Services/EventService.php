<?php

namespace App\Services;

use Config;
use Illuminate\Support\Facades\App;

class EventService
{
    /**
     * 取得背景主題的class名稱
     * @return string 背景主題的class名稱
     */
    public function getEventTheme($date = '')
    {
        $now = $this->getTime($date);
        $eventsArray = [
            [
                'className' => 'theme FullonHotel',
                'startDt' => '2023-03-07 09:00:00',
                'endDt' => '2023-03-09 23:59:59',
            ],
        ];

        // 判斷是否有在需顯示活動背景主題的期間內
        foreach ($eventsArray as $value) {
            if ($now >= $value['startDt'] && $now <= $value['endDt']) {
                return $value['className'];
            }
        }

        return '';
    }

    /**
     * 取得時間
     * @return string 日期時間
     */
    public function getTime($date = '')
    {
        $isProd = App::environment('prod'); // 是否為 stage & 正式環境
        $now = !$isProd && !empty($date) ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');

        return $now;
    }

    /**
     * 判斷是否要顯示公告跳窗（每天僅跳一次）
     * @param array  $accouncement 公告資訊
     * @param string $date         時間日期
     * @return string
     */
    public function setAnnounce($announcement = [], $date = '')
    {
        $id = $announcement['id'] ?? 0;
        $content = $announcement['content'] ?? '';
        $startDt = $announcement['start_date'] ?? '';
        $endDt = $announcement['end_date'] ?? '';

        // 如果 id or content 為空，或開始/結束時間有異，返回空字串
        if (!$id
            || !$content
            || !$startDt
            || !$endDt
            || !strtotime($startDt)
            || !strtotime($endDt)
        ) {
            return '';
        }

        $now = $this->getTime($date);
        $announceKey = 'announce_' . $id;
        $cookieValue = '1';

        // 今天已經跳過公告跳窗，不再顯示公告跳窗
        if (!empty($_COOKIE[$announceKey]) && $_COOKIE[$announceKey] == $cookieValue) {
            return '';
        }

        // 判斷是否有在需顯示公告的期間內
        if ($now >= $startDt && $now <= $endDt) {
            $_COOKIE[$announceKey] = $cookieValue;
            setcookie($announceKey, $cookieValue, strtotime('tomorrow'), '/', Config('setting.cookie.gmjDomain'), Config('setting.cookie.secure'), Config('setting.cookie.httponly'));

            return $content;
        }

        return '';
    }

    /**
     * 取得過年公告資訊
     * @param string $dateTime 日期時間
     * @return array
     */
    public function getNewYearNotice($datetime = '')
    {
        $now = $this->getTime($datetime);
        $startDt = '2023-01-19 00:00:00';
        $endDt = '2023-01-25 23:59:59';
        $noticeData = [
            'year' => '2023',
            'period' => '初二01/23(一)～初三01/24(二)',
            'imgUrl' => url('/img/newyear-notice-2023.jpg'),
        ];

        if ($now >= $startDt && $now <= $endDt) {
            return $noticeData;
        }

        return [];
    }

    /**
     * 取得首頁icon內容
     * @param string $date 日期時間
     * @return array
     */
    public function getChannelList($date = '')
    {
        $isProd = App::environment('prod');
        $now = $this->getTime($date);
        $channelList = Config::get('channel.homeList');

        // 非正式環境下，變更旅遊行程＆宅配嚴選頻道網址
        if (!$isProd) {
            $channelList[Config::get('channel.id.esMarket')]['url'] = 'https://stage.trippacker.com.tw/';
            $channelList[Config::get('channel.id.shopify')]['url'] = 'https://shop-dev.gomaji.com/';
        }

        // 於2023-03-31 16:00:00後關閉生活市集入口
        if ($now >= '2023-03-31 16:00:00') {
            unset($channelList[Config::get('channel.id.buy123')]);
        }

        return $channelList;
    }
}
