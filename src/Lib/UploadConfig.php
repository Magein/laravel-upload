<?php

namespace Magein\Upload\Lib;

class UploadConfig
{
    const IMAGE = ['jpg', 'png', 'gif', 'jpeg'];

    const AUDIO = ['mp3', 'wav'];

    const VIDEO = ['mp3', 'mp4', 'avi', 'wmv', 'mpg', 'mpeg', 'mov', 'rm'];

    const FILE = ['doc', 'docx', 'txt', 'xls', 'xlsx', 'pdf', 'ppt', 'md'];

    const MIME_IMAGE = 1;
    const MIME_VIDEO = 2;
    const MIME_AUDIO = 3;
    const MIME_FILE = 4;

    /**
     * 单位 K
     * @var int
     */
    protected int $size = 0;

    /**
     * 文件的扩展名称
     * @var array
     */
    protected array $extend = [];

    /**
     * 保存路径
     * @var string
     */
    protected string $save_path = '';

    /**
     * 上传事件
     * @var UploadEvent|null
     */
    protected ?UploadEvent $event = null;

    /**
     * @param string $save_path
     * @param string|array $extend
     * @param int $size
     */
    public function __construct(string $save_path = '', $extend = ['png', 'jpg', 'gif'], int $size = 512)
    {
        $this->setSavePath($save_path);
        $this->setExtend($extend);
        $this->setSize($size);
    }

    /**
     * 获取mime的常量值
     * @param string $mime
     * @param bool $setting 传递则根据mime类型自动设置参数
     * @return int
     */
    public function getMimeType(string $mime, bool $setting = true): int
    {
        if (preg_match('/image/', $mime)) {
            $type = self::MIME_IMAGE;
            $filepath = 'image';
            $extend = self::IMAGE;
            $size = 512;
        } elseif (preg_match('/video/', $mime)) {
            $type = self::MIME_VIDEO;
            $filepath = 'video';
            $extend = self::VIDEO;
            $size = 1024 * 6;
        } elseif (preg_match('/audio/', $mime)) {
            $type = self::MIME_AUDIO;
            $filepath = 'audio';
            $extend = self::AUDIO;
            $size = 1024 * 6;
        } else {
            $type = self::MIME_FILE;
            $filepath = 'file';
            $extend = self::FILE;
            $size = 1024 * 100;
        }


        if ($setting) {
            $filepath = $filepath . '/' . date('Y/m/d');
            $this->setSavePath($filepath);
            $this->setExtend($extend);
            $this->setSize($size);
        }

        return $type;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * @return string[]
     */
    public function getExtend(): array
    {
        return $this->extend;
    }

    /**
     * @param array|string $extend
     */
    public function setExtend(array $extend)
    {
        if (is_string($extend) && preg_match('/,/', $extend)) {
            $extend = explode(',', $extend);
        }
        $this->extend = $extend;
    }

    /**
     * @return string
     */
    public function getSavePath(): string
    {
        return $this->save_path;
    }

    /**
     * @param string $save_path
     * @param bool $is_public
     */
    public function setSavePath(string $save_path, bool $is_public = true)
    {
        if ($save_path) {
            $save_path = trim($save_path, '/');
            if ($is_public) {
                $save_path = 'public/' . $save_path;
            }
            $this->save_path = $save_path;
        }
    }
}
