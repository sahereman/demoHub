<?php

use App\Models\Category;
use App\Models\Draft;
use Illuminate\Database\Seeder;

class DraftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::all()->each(function (Category $category) {
            $drafts = factory(Draft::class, 3)->make([
                'category_id' => $category->id,
            ]);
            $drafts->map(function (Draft $draft, $key) {
                $draft->sort -= $key;
                $draft->save();
            });
        });
    }
}
