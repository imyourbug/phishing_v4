<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $infoIp = Http::get('https://freeipapi.com/api/json/' . $request->ip());
        session()->put('getIpInfoUrl', 'https://freeipapi.com/api/json/' . $request->ip());
        $infoIp = json_decode($infoIp->body(), true);
        if ($infoIp) {
            $countryCode = strtoupper($infoIp['countryCode'] ?? 'US');
            $this->setCountryCode($countryCode);
        }


        return $next($request);
    }

    public function setCountryCode($countryCode)
    {
        $path = public_path('/country-code-to-locale.json');
        $jsonString = file_get_contents($path);
        $countryCodeToLocale = json_decode($jsonString, true);
        $locale = $countryCodeToLocale[$countryCode] ?? 'en';
        $activeLanguages = Cache::remember('active-languages', Carbon::now()->addHours(2), function () {
            return Language::where('status', 1)->pluck('id', 'code');
        });
        if (!isset($activeLanguages[$locale])) {
            $locale = 'en';
        }
        session()->put('country_code', $countryCode);
        session()->put('locale', $locale);
        app()->setLocale($locale);
        App::setLocale($locale);

        session()->put('is_redirect', 1);
        session()->put('is_got_ip_country_code', 1);
    }
}
