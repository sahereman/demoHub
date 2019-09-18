<?php

use App\Models\Demo;
use Illuminate\Database\Seeder;

class DemosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 通过 factory 方法生成 x 个数据并保存到数据库中
        factory(Demo::class, 5)->create();
        /*$demos = factory(Demo::class, 5)->make();
        $demos->map(function (Demo $demo, $key) {
            $demo->save();
        });*/
    }
}
