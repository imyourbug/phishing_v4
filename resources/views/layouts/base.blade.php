<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta name="theme-color" content="#563d7c">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    @stack('icons')
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e49e839f4b.js" crossorigin="anonymous"></script>

    @stack('styles')

    @livewireStyles

    <!-- Core -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

    <!-- Vendor JS -->
    <script src="/assets/js/on-screen.umd.min.js"></script>

    <!-- Smooth scroll -->
    <script src="/assets/js/smooth-scroll.polyfills.min.js"></script>


    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Volt JS -->
    {{--    <script src="/assets/js/volt.js"></script> --}}

    <script>
        async function setCurrentLang() {
            let currentLang = localStorage.getItem('current-lang');
            let getIpInfoUrl = '{{ session()->get('getIpInfoUrl') }}';
            if (!currentLang) {
                let isGotIpCountryCode = '{{ session()->get('is_got_ip_country_code') }}';
                if (isGotIpCountryCode !== '1') {
                    const response = await fetch(getIpInfoUrl);
                    const ipInfo = await response.json();
                    window.location.href = '/set-country-code?country_code=' + ipInfo.countryCode || 'US';
                } else {
                    currentLang = '{{ session()->get('locale') }}';
                    localStorage.setItem('current-lang', currentLang);
                }
            } else {
                let redirected = '{{ session()->get('is_redirect') }}';
                if (redirected !== '1') {
                    window.location.href = '/set-locale?locale=' + currentLang;
                }
            }
        }
        setCurrentLang()
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    {{ $slot }}
    @livewireScripts
    @stack('scripts')
</body>

</html>
