<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Panggil SettingSeeder untuk mengisi data pengaturan awal
        $this->call([
            SettingSeeder::class,
        ]);
    }
}
