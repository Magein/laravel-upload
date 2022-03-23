<?php

return [
    /**
     * 默认的配置文件
     */
    'default' => [
        // 上传的场景使用的驱动
        'scene' => \Magein\Upload\Lib\UploadScene::class,
        // 默认的驱动,优先使用场景之匹配的
        'driver' => 'local',
        // 默认的配置文件
        'config' => \Magein\Upload\Lib\UploadConfig::class,
        // 上传的事件
        'event' => \Magein\Upload\Lib\UploadEvent::class,
    ],

    'driver' => [
        'local' => \Magein\Upload\Driver\Local::class,
        'aliyun' => \Magein\Upload\Driver\AliYunOss::class,
        'qiniu' => \Magein\Upload\Driver\QiNiuOss::class,
    ],

    // 本地驱动的设置
    'local' => [
        'scene' => '',
        'config' => '',
        'event' => ''
    ],

    'aliyun' => [
        'access_key_id' => '',
        'access_key_secret' => '',
        'endpoint' => '',
        'bucket' => ''
    ],

    'qiniu' => [
        'scene' => '',
        'config' => '',
        'event' => ''
    ]
];
