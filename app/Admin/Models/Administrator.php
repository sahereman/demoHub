<?php

namespace App\Admin\Models;

use App\Models\Demo;
use Encore\Admin\Auth\Database\Administrator as ProtoAdministrator;
use Encore\Admin\Auth\Database\Role;

class Administrator extends ProtoAdministrator
{
    const ROLE_DESIGNER = 'designer';

    public static $roleMap = [
        self::ROLE_DESIGNER => 'Designer',
    ];

    public static function designers()
    {
        return Role::where('slug', self::ROLE_DESIGNER)->first()->administrators;
    }

    /* Eloquent Relationships */
    public function demos()
    {
        return $this->belongsToMany(Demo::class, 'demo_designers', 'admin_user_id', 'demo_id', 'id', 'id', 'demos');
    }
}
