@push('icons')
    <link rel="apple-touch-icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}" sizes="180x180">
    <link rel="icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}" sizes="32x32">
    <link rel="icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}" sizes="16x16">
    <link rel="icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}" sizes="16x16">
    <link rel="mask-icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}">
    <link rel="icon" href="{{asset('assets/img/language-svgrepo-com.svg')}}">
@endpush
@push('styles')
    <link type="text/css" href="/css/volt.css" rel="stylesheet">
@endpush
<main>
    <title>Edit Label</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Label</li>
                </ol>
            </nav>
            <h2 class="h4">Edit Label</h2>
            <p class="mb-0">Edit Label per screen</p>
        </div>
    </div>

    <div class="card card-body border-0 shadow mb-4">
        <div>
            @foreach($languages as $language)
                <a href="{{route('edit-label', ['lang' => $language->code])}}"
                   class="mb-2 btn @if($language->id === $currentLanguage->id) btn-secondary @else btn-gray-50 @endif">
                    {{$language->name}}
                </a>
            @endforeach
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="edit" action="#" method="POST">
        @foreach($labels as $key => $label)
            <div wire:key="edit-label-{{ $key }}" class="card card-body border-0 shadow mb-4">
                <h2 class="h4">{{$positions[$key]}}</h2>
                <div class="row mb-4">
                    @foreach($label as $item)
                        <div class="col-lg-4 col-sm-6 col-xs-12">
                            <div class="mb-4">
                                <input type="text" value="{{$item->name}}" class="form-control" wire:model="data.{{$item->position}}_{{$item->code}}"
                                       aria-describedby="emailHelp">
                                <small class="form-text text-muted">{{$item->description}}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="card card-body border-0 shadow mb-4">
            <div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </div>
        </div>
    </form>
</main>
