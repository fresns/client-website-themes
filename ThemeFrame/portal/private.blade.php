@extends('commons.fresns')

@section('title', fs_lang('private'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">{{ fs_config('site_name') }}</h3>
                    <p>{{ fs_lang('private') }}</p>

                    {{-- Go to login --}}
                    <p class="mt-4">
                        <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                            data-type="account"
                            data-scene="sign"
                            data-post-message-key="fresnsAccountSign"
                            data-title="{{ fs_lang('accountLogin') }}"
                            data-url="{{ fs_config('account_login_service') }}">
                            {{ fs_lang('accountLogin') }}
                        </button>
                    </p>

                    {{-- Join --}}
                    @if (fs_config('site_private_status') && fs_config('site_private_service'))
                        <p class="mt-4">
                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-type="account"
                                data-scene="sign"
                                data-post-message-key="fresnsAccountSign"
                                data-title="{{ fs_lang('accountJoin') }}"
                                data-url="{{ fs_config('site_private_service') }}">
                                {{ fs_lang('accountJoin') }}
                            </button>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
