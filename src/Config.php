<?php

return [
    /**
     * 默认的配置文件
     */
    'default' => [
        // 默认的驱动
        'driver' => 'local',
        // 上传使用的配置
        'setting' => \Magein\Upload\Lib\UploadSetting::class
    ],

    // 本地驱动的设置
    'local' => [
        'use' => \Magein\Upload\Driver\Local::class,
        // 默认的配置文件
        'config' => \Magein\Upload\Lib\UploadConfig::class,
        // 上传的事件
        'event' => \Magein\Upload\Lib\UploadEvent::class,
    ],

    'aliyun' => [
        'use' => \Magein\Upload\Driver\AliYunOss::class,
    ],

    'qiniu' => [
        'use' => \Magein\Upload\Driver\QiNiuOss::class,
    ]
];
