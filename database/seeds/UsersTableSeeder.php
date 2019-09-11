<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 通过 factory 方法生成 x 个数据并保存到数据库中
        factory(User::class, 5)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'aaa';
        $user->email = 'aaa@demohub.test';
        $user->save();
    }
}
