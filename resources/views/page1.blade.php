@push('icons')
    <link rel="apple-touch-icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="16x16">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}" sizes="16x16">
    <link rel="mask-icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}">
    <link rel="icon" href="{{ asset('assets/img/language-svgrepo-com.svg') }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date();
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var day = today.getDate();
            var monthIndex = today.getMonth();
            var year = today.getFullYear();
            var formattedDate = monthNames[monthIndex] + ' ' + day + ', ' + year + '.';
            var date = document.getElementById('date');
            date.innerHTML = formattedDate;
        });

        function nextPage() {
            window.location.href = '/business-help-center';
        }

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
    </script>
@endpush
@extends('layouts.main')
@section('content')
    {{-- <header>
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANQAAAA8CAMAAAApF2TFAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAspQTFRFAAAA////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////17LOWQAAAO50Uk5TAAQZNkpDJgsgPUs3GgE/o+z/+sZvA6fjlzoCCUU4QjIPmfVNBZPy95Lv6CJU/rMuMBcr0v0SzckloAffexje+AoUu6+u1b30OXL71ryfDKntcVDYscUegucGeYy/cE+EKPPO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" id="meta-img">
    </header> --}}
    <div id="block">
        <img src="/image/meta-community-standard.png" id="block-img" />
        <h2 id="block-title">@lang('introduce.introduce_welcome')</h2>
        <p>@lang('introduce.introduce_notice')</p>
        <div class=""
            style="background-color:#F7F8FA;border-radius:10px;display:flex;padding:15px;margin:10px 0px;align-items:center">
            <div class="" style="margin-right: 20px">
                <img width="20px" height="20px" src="/image/warning.png" alt="">
            </div>
            <div class="">
                <b>@lang('introduce.introduce_date') <b id="date"></b> </b>
                <p>@lang('introduce.introduce_detail')</p>
            </div>
        </div>
        <p>@lang('introduce.introduce_detail_step_1')</p>
        <button onclick="nextPage()">@lang('introduce.introduce_button_continue')</button>
    </div>
    </div>
    </div>
@endsection
