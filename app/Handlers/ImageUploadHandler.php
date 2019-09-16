<?php

namespace App\Handlers;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    private $avatar_width = 400;
    private $avatar_height = 400;

    private $preview_width = 300;
    private $preview_height = 300;

    private $thumb_width = 240;/*缩略图宽度*/
    private $thumb_height = 240;/*缩略图高度*/

    private $clear_temp_odds = 1000;/*清空temp目录的几率 1000分之1*/

    /**
     * 解码完整资源路径,返回录入数据库路径
     * @param $internet_url
     * @return mixed
     */
    public static function decodeUrl($internet_url)
    {
        $slice_url = config('filesystems.disks.public.url') . '/';

        return str_replace($slice_url, '', $internet_url);
    }

    /**
     * 上传一个原始文件到original目录 （如有可选参数 指定目录及文件名）
     * @param File|UploadedFile $file & 表单的file对象
     * @param bool $save_path
     * @param bool $name
     * @return mixed & 返回需要入数据库的文件路径
     */
    public function uploadOriginal(UploadedFile $file, $save_path = false, $name = false)
    {
        $date = Carbon::now();
        $child_path = 'original/' . date('Ym', $date->timestamp);/*存储文件格式为 201706 文件夹内*/

        if ($save_path && $name) {
            $path = Storage::disk('public')->putFileAs($save_path, $file, $name . strrchr($file->getClientOriginalName(), '.'));/*自己拼接保持原本上传的后缀名*/
        } else {
            $path = Storage::disk('public')->putFile($child_path, $file);
        }

        return $path;
    }

    /**
     * 上传一张缩略图到thumb目录 （缩略图尺寸根据类属性设定）（如有可选参数 指定目录及文件名）
     * @param File|UploadedFile $file & 表单的file对象
     * @param bool $save_path
     * @param bool $name
     * @return mixed 返回需要入数据库的文件路径
     */
    public function uploadThumb(UploadedFile $file, $save_path = false, $name = false)
    {
        $date = Carbon::now();
        $prefix_path = Storage::disk('public')->getAdapter()->getPathPrefix();
        $child_path = 'thumb/' . date('Ym', $date->timestamp);/*存储文件格式为 201706 文件夹内*/

        if ($save_path && $name) {
            $path = Storage::disk('public')->putFileAs($save_path, $file, $name . strrchr($file->getClientOriginalName(), '.'));/*自己拼接保持原本上传的后缀名*/
        } else {
            $path = Storage::disk('public')->putFile($child_path, $file);
        }

        Image::make($prefix_path . $path)->orientate()->resize($this->thumb_width, $this->thumb_height)->save();

        return $path;
    }

    /**
     * 上传一个缩略图临时文件到temp目录
     * @param File|UploadedFile $file & 表单的file对象
     * @return false|string
     */
    public function uploadAvatarPreview(UploadedFile $file)
    {
        if (mt_rand(0, $this->clear_temp_odds) == 0) {
            $prefix_path = Storage::disk('public')->getAdapter()->getPathPrefix();
            self::truncateFolder($prefix_path . 'temp');
        }

        $path = Storage::disk('public')->putFile('temp', $file);

        $prefix_path = $prefix_path ?? Storage::disk('public')->getAdapter()->getPathPrefix();
        // Image::make($prefix_path . $path)->orientate()->resize($this->preview_width, $this->preview_height)->save();
        $image = Image::make($prefix_path . $path)->orientate();
        $width = $image->width();
        $height = $image->height();
        $image->fit(min($width, $height))->resize($this->avatar_width, $this->avatar_height, function ($constraint) {
            // $constraint->aspectRatio();
            $constraint->upsize();
        })->save();

        return $path;
    }

    /**
     * 上传一张缩略图到avatar目录 （头像图尺寸根据类属性设定）（如有可选参数 指定目录及文件名）
     * @param File|UploadedFile $file & 表单的file对象
     * @param bool $save_path
     * @param bool $name
     * @return mixed 返回需要入数据库的文件路径
     */
    public function uploadAvatar(UploadedFile $file, $save_path = false, $name = false)
    {
        // $date = Carbon::now();
        $prefix_path = Storage::disk('public')->getAdapter()->getPathPrefix();
        $child_path = 'avatar'; /*存储文件格式为 avatar 文件夹内*/

        if ($save_path && $name) {
            $path = Storage::disk('public')->putFileAs($save_path, $file, $name . strrchr($file->getClientOriginalName(), '.'));/*自己拼接保持原本上传的后缀名*/
        } else {
            $path = Storage::disk('public')->putFile($child_path, $file);
        }

        // Image::make($prefix_path . $path)->orientate()->resize($this->avatar_width, $this->avatar_height)->save();
        $image = Image::make($prefix_path . $path)->orientate();
        $width = $image->width();
        $height = $image->height();
        $image->fit(min($width, $height))->resize($this->avatar_width, $this->avatar_height, function ($constraint) {
            // $constraint->aspectRatio();
            $constraint->upsize();
        })->save();

        return $path;
    }

    /**
     * 上传一个临时文件到temp目录
     * @param File|UploadedFile $file & 表单的file对象
     * @return false|string
     */
    public function uploadTemp(UploadedFile $file)
    {
        if (mt_rand(0, $this->clear_temp_odds) == 0) {
            $prefix_path = Storage::disk('public')->getAdapter()->getPathPrefix();
            self::truncateFolder($prefix_path . 'temp');
        }

        $path = Storage::disk('public')->putFile('temp', $file);

        $prefix_path = $prefix_path ?? Storage::disk('public')->getAdapter()->getPathPrefix();
        // Image::make($prefix_path . $path)->orientate()->resize($this->preview_width, $this->preview_height)->save();
        Image::make($prefix_path . $path)->orientate()->resize($this->preview_width, $this->preview_height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save();

        return $path;
    }

    /**
     * 上传一个原始文件到 comment_image 目录 （如有可选参数 指定目录及文件名）
     * @param File|UploadedFile $file & 表单的file对象
     * @param bool $save_path
     * @param bool $name
     * @return mixed & 返回需要入数据库的文件路径
     */
    public function uploadCommentImage(UploadedFile $file, $save_path = false, $name = false, $width = 240, $height = 240)
    {
        $date = Carbon::now();
        $prefix_path = Storage::disk('public')->getAdapter()->getPathPrefix();
        $child_path = 'comment/' . date('Ym', $date->timestamp);/*存储文件格式为 201706 文件夹内*/

        if ($save_path && $name) {
            $path = Storage::disk('public')->putFileAs($save_path, $file, $name . strrchr($file->getClientOriginalName(), '.'));/*自己拼接保持原本上传的后缀名*/
        } else {
            $path = Storage::disk('public')->putFile($child_path, $file);
        }

        Image::make($prefix_path . $path)->orientate()->resize($width, $height)->save();

        return $path;
    }

    /**
     * 给定一个数据库中存储的文件路径,删除文件,返回 true 删除成功
     * @param $path
     * @return mixed
     */
    public function deleteFile($path)
    {
        return Storage::delete($path);/*返回 true 删除成功*/
    }

    /**
     * 删除所有子目录及目录中的文件(保留目录)
     * @param $path (物理地址的绝对路径文件夹)
     */
    public function truncateFolder($path)
    {
        $op = dir($path);
        while (false != ($item = $op->read())) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (is_dir($op->path . '/' . $item)) {
                self::truncateFolder($op->path . '/' . $item);
                rmdir($op->path . '/' . $item);
            } else {
                unlink($op->path . '/' . $item);
            }
        }
    }
}
