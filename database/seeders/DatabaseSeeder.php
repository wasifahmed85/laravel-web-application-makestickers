<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Material;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            RoleHasPermissionSeeder::class,
            UserSeeder::class,
            MaterialSeeder::class,
            MaterialAttributeSeeder::class,
            MaterialAttributeValueSeeder::class,
            TemplateCategorySeeder::class,

            StickerCategorySeeder::class,
            StickerTypeSeeder::class,
            StickerShapeSeeder::class,
            StickerTypeShapeSeeder::class,
            QuantityTierSeeder::class
        ]);
    }
}
