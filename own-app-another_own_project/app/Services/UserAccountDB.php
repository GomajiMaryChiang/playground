<?php

namespace App\Services;

//use App\Repositories\ApiRepository;
// use App\Services\ApiService;
use DB;
use App\Models\User;
// use App\Models\NeoSMSInfo;
// use Illuminate\Support\Facades\Redis;

class UserAccountDB
{
    // protected $apiService;
    protected $user;
    // protected $neoSMSInfo;
    // protected $redis;

    /**
     * Dependency Injection
     */
    public function __construct(User $user)
    {
        // $this->apiService = $apiService;
        $this->user = $user;
        // $this->neoSMSInfo = $neoSMSInfo;
        // $this->redis = $redis;
    }

    /**
     * 使用reg_mobile_phone找尋用戶資料，且只有第一筆
     *
     * @param $mobilePhone
     * @return array|null
     */
    public function getUserByRegMobilePhone($mobilePhone)
    {
        $condition = [ 
            ['reg_mobile_phone', '=', $mobilePhone],
            ['flag', '>=', 0]
        ];
        return $this->user::select('id', 'reg_email', 'reg_mobile_phone', 'last_mobile_phone', 'account_active', 'flag')->where($condition)->get();
    }

    /**
     * 使用last_mobile_phone找尋用戶資料，符合的都回傳
     *
     * @param $mobilePhone
     * @return array|null
     */
    public static function getUsersByLastMobilePhone($mobilePhone)
    {
        $sql = sprintf("
            SELECT 
                id,
                reg_email,
                reg_mobile_phone,
                last_mobile_phone,
                account_active,
                flag,
                full_name
            FROM
                users
            WHERE 
                last_mobile_phone = %d
                AND flag >= 0
            ;", 
            $mobilePhone
        );
        $result = DB::select($sql);
        DB::disconnect('users');
        return $result;
    }


    /**
     * 清除特定uId帳戶的reg_mobile_phone以及account_active - 2 (表示該帳戶門號沒有驗證過)
     *
     * @param $uId
     * @return bool
     */
    public static function clearRegMobilePhoneAndStatusByuId($uId)
    {
        $sql = sprintf("
            UPDATE 
                users 
            SET 
                reg_mobile_phone = '',
                account_active = account_active & ~2
            WHERE id = %d
                AND flag >= 0
            LIMIT 1
            ;", 
            $uId
        );
        $result = DB::update($sql);
        DB::disconnect('users');
        return $result;
    }

    /**
     * 使用門號產生新的用戶資料
     * 請確定該門號沒有其他帳戶使用才呼叫這個函式
     *
     * @param $mobilePhone
     * @return bool
     */
    public static function createNewUserByMobilePhone($mobilePhone)
    {
        $remoteAddr = "'" . $_SERVER['REMOTE_ADDR'] . "'"; // 客戶端IP位置
        $sql = sprintf("
            INSERT INTO
                users (
                    reg_mobile_phone, 
                    last_mobile_phone,
                    last_ip,
                    register_ts
                    )
                VALUES
                    (%d, %d, %s, %d)
            ;", 
            $mobilePhone,
            $mobilePhone,
            $remoteAddr ?? '',
            time()
        );
        $result = DB::insert($sql);
        DB::disconnect('users');
        return $result;
    }
}
