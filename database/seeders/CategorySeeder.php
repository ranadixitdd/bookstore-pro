<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
