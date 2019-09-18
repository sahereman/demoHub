<?php

use App\Models\Demo;
use App\Models\DemoDesigner;
use Illuminate\Database\Seeder;

class DemoDesignersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 通过 factory 方法生成 x 个数据并保存到数据库中
        /*$demo_designers = factory(DemoDesigner::class, 5)->make();
        $demo_designers->map(function (DemoDesigner $demoDesigner, $key) {
            $demoDesigner->demo_id = $key + 1;
            $demoDesigner->save();
        });*/
        Demo::first()->designers()->sync([2, 3]);
        Demo::find(2)->designers()->sync([2, 3, 4]);
        Demo::find(3)->designers()->sync([2, 4]);
        Demo::find(4)->designers()->sync([3, 4]);
        Demo::find(5)->designers()->sync([2, 3, 4]);
    }
}
