### 上传组件

> 扩展laravel的上传组件

### 使用

```php

// 保存图片路径,使用默认的驱动，具体查看配置文件
\Magein\Upload\Facades\Upload::store()

// 使用本地驱动进行保存
\Magein\Upload\Facades\Upload::local(new \Magein\Upload\Lib\UploadConfig(),new \Magein\Upload\Lib\UploadEvent());
\Magein\Upload\Facades\Upload::aliYunOss(new \Magein\Upload\Lib\UploadConfig(),new \Magein\Upload\Lib\UploadEvent());
\Magein\Upload\Facades\Upload::qiNiuOss(new \Magein\Upload\Lib\UploadConfig(),new \Magein\Upload\Lib\UploadEvent());

```

### 配置

```php
return [
    'default' => [
        // 默认的驱动
        'driver' => 'local',
        // 针对每个场景、每个字段进行config设置
        'setting' => \Magein\Upload\Lib\UploadSetting::class
    ],

    // 本地驱动的设置
    'local' => [
        // 默认的配置文件
        'config' => \Magein\Upload\Lib\UploadConfig::class,
        // 上传的事件
        'event' => \Magein\Upload\Lib\UploadEvent::class
    ],
    
    // 阿里云的配置
    'aliyun' => [

    ],
    
    // 七牛云的配置
    'qiniu' => [

    ]
]
```