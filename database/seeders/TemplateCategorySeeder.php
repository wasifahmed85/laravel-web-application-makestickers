<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Uri\UriTemplate\Template;

class TemplateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplateCategory::create([
            'name' => 'Test Category1',
            'slug' => 'test-category1',
        ]);
        TemplateCategory::create([
            'name' => 'Test Category2',
            'slug' => 'test-category2',
        ]);
        TemplateCategory::create([
            'name' => 'Test Category3',
            'slug' => 'test-category3',
        ]);
    }
}
