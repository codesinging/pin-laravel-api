<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

return [
    'mini' => [
        'app_id' => env('WECHAT_MINI_APP_ID', ''),
        'secret' => env('WECHAT_MINI_SECRET', ''),
        'token' => env('WECHAT_MINI_TOKEN', ''),
        'aes_key' => env('WECHAT_MINI_AES_KEY', ''),
    ],

    'pay' => [
        'mch_id' => env('WECHAT_PAY_MCH_ID', ''),
        'secret_key' => env('WECHAT_PAY_SECRET_KEY', ''), // v3 api 密钥
        'v2_secret_key' => env('WECHAT_PAY_V2_SECRET_KEY', ''), // v3 api 密钥
        'private_key' => env('WECHAT_PAY_PRIVATE_KEY', ''),
        'certificate' => env('WECHAT_PAY_CERTIFICATE', ''),
    ]
];
