<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'app_name' => 'Stockify',
            'admin_email' => 'admin@stockify.com',
            'logo_url' => null, // Path logo nanti dari upload
            'dark_mode_default' => false,
            'show_logo_sidebar' => true,
        ];

        foreach ($defaults as $key => $value) {
            Settings::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}