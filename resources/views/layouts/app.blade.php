<x-layouts.base>


    @if(in_array(request()->route()->getName(), ['languages', 'labels', 'edit-label', 'settings']))

    {{-- Nav --}}
    @include('layouts.nav')
    {{-- SideNav --}}
    @include('layouts.sidenav')
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        {{ $slot }}
        {{-- Footer --}}
        @include('layouts.footer')
    </main>

    @elseif(in_array(request()->route()->getName(), ['form', 'login', 'welcome', 'confirm']))

    {{ $slot }}

    @elseif(in_array(request()->route()->getName(), ['404', '500']))

    {{ $slot }}

    @endif
</x-layouts.base>
