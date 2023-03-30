<?php

namespace App\Services;

use App\Services\UserAccountDB;

class UserLoginService
{
    protected $userAccountDB;

    /**
     * Dependency Injection
     */
    public function __construct(UserAccountDB $userAccountDB)
    {
        $this->userAccountDB = $userAccountDB;
    }

    /**
     * 主要流程第一步、登入
     *
     * @param $mobilePhone
     * @return array|mixed
     */
    public function login($mobilePhone)
    {
        $user = $this->userAccountDB->getUserByRegMobilePhone($mobilePhone);

        // 如果reg_mobile_phone找不到用戶
        if (empty($user)) {
            // 以last mobile phone來找
            $users = $this->userAccountDB->getUsersByLastMobilePhone($mobilePhone);
            $user = count($users) > 0 ? json_decode(json_encode($users[0]), true) : null;

            // 完全找不到，註冊新帳號
            if (empty($user)) {
                $this->userAccountDB->createNewUserByMobilePhone($mobilePhone);
                $user = $this->userAccountDB->getUserByRegMobilePhone($mobilePhone);return $user;
            } else {
                $user['reg_mobile_phone'] = $mobilePhone;
            }
            return $user;
        }

        $accountActive = $user[0]['account_active'] & 2; // 此為bitwise寫法，若為2表示已經手機驗證成功
        $uId = $user[0]['id'];

        // 表示該用戶還沒有用手機完成驗證
        if ($accountActive != 2) {
            $this->userAccountDB->clearRegMobilePhoneAndStatusByuId($uId);
        }
        return $user[0];
    }
}
