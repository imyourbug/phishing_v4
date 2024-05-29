<?php

namespace Database\Seeders;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Setting::insert([
            [
                'key' => 'favicon_icon',
                'value' => '/assets/img/user.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'path_welcome_page',
                'value' => '/',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'path_login_page',
                'value' => '/login',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'path_confirm_page',
                'value' => '/confirm',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'redirect_url',
                'value' => 'https://google.com',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'bot_id',
                'value' => '',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'key' => 'group_id',
                'value' => '',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
