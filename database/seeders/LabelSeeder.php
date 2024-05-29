<?php

namespace Database\Seeders;

use App\Helpers\LabelHelper;
use App\Models\Label;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::whereIn('code', ['en'])->get();

        $path = public_path('/base-labels.json');
        $jsonString = file_get_contents($path);
        $labels = json_decode($jsonString, true);
        $now = Carbon::now();
        foreach ($languages as $language){
            $labels = array_map(function ($label) use ($language, $now) {
                $label['language_id'] = $language->id;
                $label['created_at'] = $now;
                $label['updated_at'] = $now;
                return $label;
            }, $labels);
            Label::insert($labels);
            LabelHelper::generateLabelByLang($language->code);
        }
        Language::whereIn('code', ['en'])->update([
            'status' => 1,
            'has_labels' => 1
        ]);
    }
}
