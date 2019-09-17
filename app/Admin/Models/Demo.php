<?php

namespace App\Admin\Models;

use App\Models\Demo as ProtoDemo;

class Demo extends ProtoDemo
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'thumb_url',
        'photo_urls',
        'designer_name',
        'client_name',
    ];
}
