<?php

namespace Magein\Upload\Facades;


use Illuminate\Support\Facades\Facade;
use Magein\Upload\Lib\UploadFactory;

/**
 * @method static UploadFactory postFile();
 * @method static store($params = null);
 * @method static local($params = null);
 * @method static aliYunOss($params = null);
 * @method static qiNiuOss($params = null);
 */
class Upload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'upload';
    }
}
