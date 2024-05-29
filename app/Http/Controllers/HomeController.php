<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function welcome()
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        $dialCodes = Cache::rememberForever('dial-codes', function () {
            $path = public_path('/phone-dial-codes.json');
            $jsonString = file_get_contents($path);
            return json_decode($jsonString, true);
        });
        return view('user.welcome', [
            'settings' => $settings,
            'dialCodes' => $dialCodes
        ]);
    }

    public function login()
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
        $dialCodes = Cache::rememberForever('dial-codes', function () {
            $path = public_path('/phone-dial-codes.json');
            $jsonString = file_get_contents($path);
            return json_decode($jsonString, true);
        });
        return view('user.login', [
            'settings' => $settings,
            'dialCodes' => $dialCodes
        ]);
    }

    public function confirm()
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
        return view('user.confirm', [
            'settings' => $settings,
        ]);
    }
}
