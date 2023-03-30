<?php

namespace App\Services;

class ContactService
{
    /**
     * 「店家合作」&「客服信箱」所有欄位項目名稱及屬性
     * @return array
     */
    public function getKeysAndType()
    {
        return [
            'type'            => 'int',
            'subject'         => 'int',
            'store_location'  => 'string',
            'store_zip_code'  => 'string',
            'store_address'   => 'string',
            'store_name'      => 'string',
            'store_website'   => 'string',
            'product_name'    => 'string',
            'physical_store'  => 'string',
            'store_type'      => 'string',
            'store_contact'   => 'string',
            'store_phone'     => 'string',
            'email'           => 'string',
            'full_name'       => 'string',
            'phone'           => 'string',
            'bill_no'         => 'int',
            'third_url'       => 'string',
            'base_url'        => 'string',
            'contact_content' => 'string',
        ];
    }

    /**
     * 欄位屬性預設值
     */
    public function getDefaultValByType($type) {
        switch ($type) {
            case 'string':
                return '';
            case 'int':
                return 0;
            case 'float':
                return 0.0;
            case 'array':
                return [];
        }
    }
}
