<?php

namespace App\Helpers;

class LabelHelper
{
    public static function generateLabelByLang($langCode = '')
    {
        if ($langCode === '') {
            return false;
        }
        $languagePath = lang_path($langCode);
        if (is_dir($languagePath)) {
            return false;
        }
        $path = public_path('/base-labels.json');
        $jsonString = file_get_contents($path);
        $labels = json_decode($jsonString, true);
        $generateLabel = [];
        foreach ($labels as $label) {
            $generateLabel[$label['position']][$label['code']] = $label['name'];
        }

        //Create Folder
        mkdir($languagePath);

        foreach ($generateLabel as $file => $content) {

            //Create file
            $stringContent = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $stringContent = str_replace('{', '[', $stringContent);
            $stringContent = str_replace('}', ']', $stringContent);
            $stringContent = str_replace('":', '" =>', $stringContent);
            $stringFiles = '<?php' . "\n" . 'return ' . $stringContent . ';';


            $createFile = fopen($languagePath . '/' . $file . '.php', "w") or die("Unable to open file!");
            fwrite($createFile, $stringFiles);
            fclose($createFile);
        }
    }

    public static function updateLabelByLang($langCode, $languages = [])
    {
        if (empty($languages)) {
            return false;
        }
        $languagePath = lang_path($langCode);
        if (!is_dir($languagePath)) {
            return false;
        }
        foreach ($languages as $file => $content) {

            //Create file
            $stringContent = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $stringContent = str_replace('{', '[', $stringContent);
            $stringContent = str_replace('}', ']', $stringContent);
            $stringContent = str_replace('":', '" =>', $stringContent);
            $stringFiles = '<?php' . "\n" . 'return ' . $stringContent . ';';
            $file = $languagePath . '/' . $file . '.php';

            file_put_contents($file, '');
            file_put_contents($file, $stringFiles);
        }
    }
}
