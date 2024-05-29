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
    <title>Settings</title>
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
            <h2 class="h4">Settings</h2>
            <p class="mb-0">Setting the website</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="edit" action="#" method="POST">
        @foreach($settings as $key => $value)
            @if(in_array($key, ['query_login_page', 'query_welcome_page', 'query_confirm_page'])) @continue @endif
            <div wire:key="setting-{{ $key }}" class="card card-body border-0 shadow mb-4">
                <h2 class="h4">{{$keyToLabels[$key]}}</h2>
                <div class="row mb-4">
                    <div class="col-lg-6 col-sm-6 col-xs-12 box-input-image">
                        @if(in_array($key, ['banner_welcome', 'welcome_lock', 'favicon_icon']))
                            <div class="preview-image my-3">
                                @if($key === 'banner_welcome' && $banner_welcome)
                                    <img src="{{ $banner_welcome->temporaryUrl() }}" alt="Image"
                                         id="image-setting-{{ $key }}">
                                @elseif($key === 'welcome_lock' && $welcome_lock)
                                    <img src="{{ $welcome_lock->temporaryUrl() }}" alt="Image"
                                         id="image-setting-{{ $key }}">
                                @elseif($key === 'favicon_icon' && $favicon_icon)
                                    <img src="{{ $favicon_icon->temporaryUrl() }}" alt="Image"
                                         id="image-setting-{{ $key }}">
                                @else
                                    <img src="{{ $value }}" alt="Image"
                                         id="image-setting-{{ $key }}">
                                @endif
                            </div>
                            <div class="upload_a_photo">
                                <input accept=".png, .jpg, .jpeg, .svg, .ico" wire:model="{{$key}}" type="file"
                                       class="form-control form-upload-image" data-key="setting-{{ $key }}">
                                @error($key) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        @else
                            @if($key === 'group_id')
                                <input type="text" class="form-control" wire:model="{{$key}}">
                                <button class="mt-3 mb-3 btn btn-outline-danger" type="button" wire:click="getGroupId">
                                    Get Group Id
                                </button>
                                @error('error_bot_group_id')
                                <div class="w-100 mb-3">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                @error('empty_result_group_id')
                                <div class="w-100 mb-3">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                <p class="text-warning">Warning: When clicking here. The system will search and retrieve
                                    the bot Group most recently added</p>
                            @else
                                <input type="text" class="form-control" wire:model="{{$key}}">
                            @endif
                            @error($key) <span class="text-danger">{{ $message }}</span> @enderror
                        @endif
                    </div>
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

@push('scripts')
    <script type="text/javascript">
        function uploadImagePreview() {
            const file = this.files[0];
            const settingKey = $(this).data('key')
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-' + settingKey)
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).on('change', '.form-upload-image', uploadImagePreview)
    </script>
@endpush
