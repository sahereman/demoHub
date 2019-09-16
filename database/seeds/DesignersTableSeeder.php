<?php

use App\Models\Designer;
use Illuminate\Database\Seeder;

class DesignersTableSeeder extends Seeder
{
    public function run()
    {
        // 通过 factory 方法生成 x 个数据并保存到数据库中
        factory(Designer::class, 5)->create();

        // 单独处理第一个用户的数据
        $user = Designer::find(1);
        $user->name = 'bbb';
        $user->email = 'bbb@demohub.test';
        $user->save();
    }
}
