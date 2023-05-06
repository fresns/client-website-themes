@extends('commons.fresns')

@section('title', fs_db_config('menu_account'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Account Main --}}
            <div class="col-sm-9">
                {{-- features --}}
                <div class="clearfix">
                    @foreach(fs_user_panel('features') as $feature)
                        <div class="position-relative mx-3 mt-3" style="width:52px">
                            <a class="text-decoration-none" data-bs-toggle="modal" href="#fresnsModal"
                                data-type="account"
                                data-scene="featureExtension"
                                data-post-message-key="fresnsFeatureExtension"
                                data-title="{{ $feature['name'] }}"
                                data-url="{{ $feature['url'] }}">
                                <img src="{{ $feature['icon'] }}" loading="lazy" class="rounded" height="52">
                                <p class="mb-0 text-center">{{ $feature['name'] }}</p>
                            </a>
                            @if ($feature['badgeType'])
                                <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-1">
                                    {{ $feature['badgeType'] == 1 ? '' : $feature['badgeValue'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
