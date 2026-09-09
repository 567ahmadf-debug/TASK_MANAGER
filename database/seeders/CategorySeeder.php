<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories = 
            [
                'git' ,'php', 'c++','java','python'
            ]
         ;
        
        foreach($categories as $category)
            Category::create(['type' => $category]) ; 
    }

}
