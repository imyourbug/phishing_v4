<?php

namespace Database\Seeders;

use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Languages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('/languages.json');
        $jsonString = file_get_contents($path);
        $languages = json_decode($jsonString, true);
        $now = Carbon::now();
        $insert = [];
        foreach ($languages as $language){
            $insert[] = [
                'code' => $language['code'],
                'name' => $language['name'],
                'native_name' => $language['nativeName'] !== '' ? $language['nativeName'] : $language['name'],
                'status' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        Language::insert($insert);
    }
}
