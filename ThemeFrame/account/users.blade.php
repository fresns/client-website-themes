@extends('commons.fresns')

@section('title', fs_api_config('menu_account_users'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- List of users belonging to the current account --}}
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        {{ fs_api_config('user_name') }}
                        @if ($multiUserStatus)
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-lang-tag="{{ current_lang_tag() }}"
                                data-type="account"
                                data-scene=""
                                data-post-message-key="fresnsConnect"
                                data-aid="{{ fs_account('detail.aid') }}"
                                data-uid="{{ fs_user('detail.uid') }}"
                                data-title="{{ fs_api_config('user_name') }}"
                                data-url="{{ fs_api_config('multi_user_service') }}">
                                <i class="bi bi-people-fill"></i>
                                {{ fs_lang('setting') }}
                            </button>
                        @endif
                    </div>
                    <div class="row p-3">
                        @foreach(fs_account('detail.users') as $item)
                            <div class="col-sm-3 d-flex flex-column align-items-center">
                                <img src="{{ $item['avatar'] }}" class="auth-avatar rounded-circle">
                                <div class="auth-nickname mt-2">{{ $item['nickname'] }}</div>
                                <div class="text-secondary">{{ '@' . $item['username'] }}</div>

                                @if(fs_user('detail.uid') == $item['uid'])
                                    <button type="submit" class="btn btn-outline-secondary btn-sm my-2" disabled>{{ fs_lang('userCurrent') }}</button>
                                @else
                                    <form action="{{ route('fresns.api.user.auth') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="uidOrUsername" value="{{ $item['uid'] }}">
                                        @if ($item['hasPassword'])
                                            <a data-bs-target="#userPwdLogin" data-uid="{{ $item['uid'] }}" data-nickname="{{ $item['nickname'] }}" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-outline-secondary btn-sm my-2" onclick="$('#userPwdLoginLabel').text($(this).data('nickname'));$('#userPwdLogin input[name=uidOrUsername]').val($(this).data('uid'))">{{ fs_lang('userPassword') }}</a>
                                        @else
                                            <button type="submit" class="btn btn-outline-secondary btn-sm my-2">{{ fs_lang('choose') }}</button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
