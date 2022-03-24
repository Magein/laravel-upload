### 上传组件

> 扩展laravel的上传组件

### 使用

> 使用阿里云需要安装阿里云的sdk

```
composer require aliyuncs/oss-sdk-php:~2
```

```php

// 保存图片路径,使用默认的驱动，具体查看配置文件
\Magein\Upload\Facades\Upload::store()

// 传递参数第一个是setting，第二个是event
\Magein\Upload\Facades\Upload::store(\Magein\Upload\Lib\UploadSetting::class, \Magein\Upload\Lib\UploadEvent::class)

```

### 配置

```php
return [
    'default' => [
        // 默认的驱动
        'driver' => 'local',
        // 针对每个场景、每个字段进行config设置
        'setting' => \Magein\Upload\Lib\UploadSetting::class,
        'config'=>'',
        'event'=>''
    ],

    // 本地驱动的设置
    'local' => [
        'use'=>\Magein\Upload\Driver\Local::class,
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

### 类

Lib/UploadConfig.php

    用于配置上传文件的验证条件，大小、格式、保存路径

Lib/UploadDriver.php

    一个驱动的接口文件，扩展的驱动需要继承此类

Lib/UploadEvent.php

    上传的事件，比如上传成功后，需要对数据进行入库，等等操作，有before、success、fail、final

     before返回false会终止执行，

     final不管上传成功或者失败都是执行

Lib/UploadScene.php

    上传的场景控制，前段需要传递一个场景值，用于判断是哪个场景，并且使用哪个驱动、且验证的文件类型、大小、扩展信息等等

    比如商品缩略图，一般只保留一个有效路径，文件名称固定，这样就避免产生大量的历史文件

    banner需要高清的，有条件的话就可能需要放到第三方的平台以避免占用大量的系统带宽。

    通过secen就可以针对不同的场景灵活的设置
