<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        /*$phone = '0934340927';$msg='歡迎來到瑪莉的二手playground小小世界，您的驗證碼是3344，啾咪！';

        $client = new Client();
        $method = 'POST';
        $params = [
            'id' => '0934340927',
            'pwd' => 'MS9icwmW9gO3',
            'tel' => $phone,
            'msg' => $msg,
            'mtype' => 'G'
        ];

        $apiUrl = 'http://api.message.net.tw/send.php?id=' . $params['id'] . '&password=' . $params['pwd'] . '&tel=' . $params['tel'] . '&msg=' . urlencode($params['msg']) . '&mtype=G&encoding=utf8';
        $response = $client->request($method, $apiUrl);
        var_dump($response->getStatusCode());*/
        return view('main.login.index');
    }
}



