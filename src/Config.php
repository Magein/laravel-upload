<?php

return [
    /**
     * 默认的配置文件
     */
    'default' => [
        // 默认的驱动
        'driver' => 'local',
        /**
         * 这里是默认的设置信息，用于对每个上传的实例进行验证判断，
         * 如上传logo、avatar、banner、thumb等等
         * logo需要验证大小，不宜太大
         * 商品的thumb只需要保留一个，不然越存越多
         * 上传的内容也可以入库，当成附件管理，用户后续清理
         * 就是用于针对每个场景进行设置
         */
        'setting' => \Magein\Upload\Lib\UploadSetting::class
    ],

    // 本地驱动的设置
    'local' => [
        // 默认的配置文件
        'config' => \Magein\Upload\Lib\UploadConfig::class,
        // 上传的事件
        'event' => \Magein\Upload\Lib\UploadEvent::class
    ],

    'aliyun' => [

    ],

    'qiniu' => [

    ]
];