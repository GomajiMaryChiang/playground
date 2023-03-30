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
        }

        // curl
        try {
            $client = new Client();
            $response = $client->request($method, $url, [
                'connect_timeout' => self::REQUEST_CONNECT_TIMEOUT,
                'timeout' => self::REQUEST_TIMEOUT,
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
    }
}
