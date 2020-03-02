<?php

return [
    'bankid' => [
        'end_point' => env('BANKID_ENDPOINT', 'https://appapi2.test.bankid.com/rp/v5'),
        'path_cacert' => env('BANKID_PATH_TO_CACERT', '/home/vagrant/proj_execs/certificate/bankId.pem'),
        'path_cert' => env('BANKID_PATH_TO_CERT', '/home/vagrant/proj_execs/certificate/cert.pem'),
    ]
];
