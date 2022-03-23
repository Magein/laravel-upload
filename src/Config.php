<?php

return [
    /**
     * 默认的配置文件
     */
    'default' => [
        // 默认的驱动
        'driver' => 'local',
        // 获取config的类
        'setting' => \Magein\Upload\Lib\UploadSetting::class,
        // 默认的配置文件
        'config' => \Magein\Upload\Lib\UploadConfig::class,
        // 上传的事件
        'event' => \Magein\Upload\Lib\UploadEvent::class,
    ],

    // 本地驱动的设置
    'local' => [
        'use' => \Magein\Upload\Driver\Local::class,
        // 获取config的类
        'setting' => \Magein\Upload\Lib\UploadSetting::class,
    ],

    'aliyun' => [
        'use' => \Magein\Upload\Driver\AliYunOss::class,
    ],

    'qiniu' => [
        'use' => \Magein\Upload\Driver\QiNiuOss::class,
    ]
];
