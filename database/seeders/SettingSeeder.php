<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['name' => 'app_name', 'value' => 'Test_Name'],
            ['name' => 'logo', 'value' => 'logo.png'],
            ['name' => 'favicon', 'value' => 'favicon.png'],
            ['name' => 'app_description', 'value' => 'Test_Description'],
            ['name' => 'smtp_host', 'value' => 'Test_host'],
            ['name' => 'smtp_port', 'value' => 'Test_Port'],
            ['name' => 'smtp_user', 'value' => 'Test_User'],
            ['name' => 'smtp_password', 'value' => 'Test_password'],
            ['name' => 'login_page_title', 'value' => 'Welcome to Password Management'],
            ['name' => 'background_type', 'value' => '0'],
            ['name' => 'background_color', 'value' => '#ffffff'],
            ['name' => 'login_background_image', 'value' => null],
            ['name' => 'login_cover_image', 'value' => null],
            ['name' => 'email_notification', 'value' => '1'],
          ];
          foreach ($settings as $key => $val) {
            if (!Setting::where('name', $val['name'])->exists()) {
                Setting::create($val);
            }
          }
    }
}
