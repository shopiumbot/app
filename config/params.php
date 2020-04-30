<?php

return [
    'adminEmail' => 'dev@pixelion.com.ua',
    'plan_id' => 2,
    'maxUploadImageSize' => [
        'width' => 800,
        'height' => 800
    ],
    'plan' => [
        1 => [
            'product_limit' => 200,
            'product_upload_files' => 1
        ],
        2 => [
            'product_limit' => 5000,
            'product_upload_files' => 3
        ],
        3 => [
            'product_limit' => true,
            'product_upload_files' => true
        ]
    ]
];
