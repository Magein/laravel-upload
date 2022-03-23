<?php

namespace Magein\Upload\Facades;


use Illuminate\Support\Facades\Facade;
use Magein\Upload\Lib\UploadFactory;

/**
 * @method static UploadFactory postFile();
 * @method static store();
 * @method static local();
 * @method static aliYunOss();
 * @method static qiNiuOss();
 */
class Upload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'upload';
    }
}
