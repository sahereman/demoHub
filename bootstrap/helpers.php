<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * Generate An Image Url.
 * @param $image string image path or url.
 * @param $disk string image filesystem disk (options: local|public|cloud).
 * @return string image url.
 * */
function generate_image_url($image, $disk = 'public')
{
    // 如果 image 字段本身就已经是完整的 url 就直接返回
    if (Str::startsWith($image, ['http://', 'https://'])) {
        return $image;
    }
    return Storage::disk($disk)->url($image);
}

