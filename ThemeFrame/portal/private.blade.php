@extends('commons.fresns')

@section('title', fs_lang('private'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">{{ fs_db_config('site_name') }}</h3>
                    <p>{{ fs_lang('private') }}</p>

                    {{-- Go to login --}}
                    <p class="mt-4"><a class="btn btn-outline-success" href="{{ fs_route(route('fresns.account.login')) }}" role="button">{{ fs_lang('accountLogin') }}</a></p>

                    {{-- Join --}}
                    @if (fs_api_config('site_private_status') && fs_api_config('site_private_service'))
                        <p class="mt-4">
                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-type="account"
                                data-scene="join"
                                data-post-message-key="fresnsJoin"
                                data-title="{{ fs_lang('accountJoin') }}"
                                data-url="{{ fs_api_config('site_private_service') }}">
                                {{ fs_lang('accountJoin') }}
                            </button>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
