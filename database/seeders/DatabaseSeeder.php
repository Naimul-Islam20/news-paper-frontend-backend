<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolePermissionSeeder::class,
            CategorySeeder::class,
            ReporterSeeder::class,
            PageSeeder::class,
            GallerySeeder::class,
            VideoSeeder::class,
            PostSeeder::class,
            AdvertisementSeeder::class,
            ContactMessageSeeder::class,
        ]);
    }
}
