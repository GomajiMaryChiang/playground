<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 發送手機認證簡訊
     * @param  string  $msg  簡訊內容
     * @param  string  $phone  手機號碼
     * @return array         已過濾的文字->還在想要怎麼寫~哪種類型
     */
    protected function sendSMS($msg, $phone){

        $params = [
            'id' => '0934340927',
            'pwd' => 'MS9icwmW9gO3',
            'tel' => $phone,
            'msg' => $msg,
            'mtype' => 'G'
        ];

        $apiUrl = 'http://api.message.net.tw/send.php?id=' . $params['id'] . '&password=' . $params['pwd'] . '&tel=' . $params['tel'] . '&msg=' . urlencode($params['msg']) . '&mtype=G&encoding=utf8';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // 將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。 這參數很重要 因為如果有輸出的話你api 解析json時會有錯誤
        $res = curl_exec($ch);

        // 可以新增回傳的訊息是什麼然後未來可以記錄在資料表中
        // if (!$res) {
        //     return false;
        // }

        curl_close($ch);
        // return true;
    }

    /*
     * 隨機產生驗證碼
     */
    /*protected function generateVerificationCode() {
        return sprintf('%04d', mt_rand(0, 9999));
    }*/
}
