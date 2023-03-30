<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class ApiRepository
{
    // error code
    const METHOD_ERROR_CODE = '100';
    const STATUS_ERROR_CODE = '101';
    const EXCEPTION_ERROR_CODE = '102';

    // request
    const REQUEST_CONNECT_TIMEOUT = 60;
    const REQUEST_TIMEOUT = 60;
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    protected $requestMethodAry = [self::REQUEST_METHOD_GET, self::REQUEST_METHOD_POST];

    // status code
    const SUCCESS_STATUS_CODE = 200;

    /**
     * Curl by Guzzle
     * @param string $url     請求網址
     * @param string $method  請求方法
     * @param array  $param   請求參數
     * @param array  $header  請求標頭
     * @return array
     */
    public function curl($url, $method = self::REQUEST_METHOD_GET, $param = [], $header = [])
    {
        // 檢查網址是否有值
        if (empty($url)) {
            return false;
        }

        // 檢查 request method
        if (!in_array($method, $this->requestMethodAry)) {
            return [
                'return_code' => self::METHOD_ERROR_CODE,
                'description' => 'Request Method Error!',
            ];
        }

        if (!isset($header['Accept-Encoding'])) {
            $header['Accept-Encoding'] = 'gzip';
        } // 先從這邊看

        // curl
        try {
            $client = new Client();
            $response = $client->request($method, $url, [
                'connect_timeout' => self::REQUEST_CONNECT_TIMEOUT, // Timeout if the client fails to connect to the server in 60 seconds.
                'timeout' => self::REQUEST_TIMEOUT, // Timeout if a server does not return a response in 60 seconds.
                'headers' => (!empty($header) && is_array($header)) ? $header : [],
                'query' => ($method == self::REQUEST_METHOD_GET && !empty($param) && is_array($param)) ? $param : [],
                'form_params' => ($method == self::REQUEST_METHOD_POST && !empty($param) && is_array($param)) ? $param : [],
            ]);

            // 檢查 http 狀態碼
            if ($response->getStatusCode() !== self::SUCCESS_STATUS_CODE) {
                return [
                    'return_code' => self::STATUS_ERROR_CODE,
                    'description' => sprintf('Status Code Error! (%d)', $response->getStatusCode()),
                ];
            }
            return json_decode($response->getBody(), true) ?? $response->getBody()->__toString();
        } catch (TransferException $e) {
            return [
                'return_code' => self::EXCEPTION_ERROR_CODE,
                'description' => $e->getMessage(),
            ];
        }






        // 過濾參數
        /*$phone = htmlspecialchars(trim($request->input('phone', '')));

        // 檢查參數
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {
            return [
                'return_code' => self::PHONE_ERROR_CODE,
                'description' => '手機號碼格式錯誤！',
            ];
        }

        //==== 發送驗證碼手機簡訊 op ====//
        $params = [
            'msg' => '歡迎來到瑪莉的二手playground小小世界，您的驗證碼是3344，啾咪！',
            'phone' => '0934340927'
        ]
        //$this->sendSMS($params['msg'], $params['phone]);
        //==== 發送驗證碼手機簡訊 end ====//

        // call ccc api
        $curlParam = [
            'mobile_phone' => $phone,
        ];
        $headerParam = [
            'Content-Type' => 'application/json',
        ];
        $result = $this->apiService->curl('login', 'POST', $curlParam, [], $headerParam);

        return $result;*/
    }

    
}
