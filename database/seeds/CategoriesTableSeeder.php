<?php

use App\Models\Category;
use App\Models\Demo;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Demo::all()->each(function (Demo $demo) {
            $categories = factory(Category::class, 5)->make([
                'demo_id' => $demo->id,
            ]);
            $categories->map(function (Category $category, $key) {
                $category->sort -= $key;
                $category->save();
            });
        });
    }
}
