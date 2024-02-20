@extends('commons.fresns')

@section('title', fs_config('menu_account_users'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Users of this account --}}
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        {{ fs_config('user_name') }}
                        @if (fs_user_panel('multiUser.status'))
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-type="account"
                                data-scene="users"
                                data-post-message-key="fresnsUsers"
                                data-title="{{ fs_config('user_name') }}"
                                data-url="{{ fs_user_panel('multiUser.service') }}">
                                <i class="bi bi-people-fill"></i>
                                {{ fs_lang('setting') }}
                            </button>
                        @endif
                    </div>
                    <div class="row p-3">
                        @foreach(fs_account('detail.users') as $item)
                            <div class="col-sm-3 d-flex flex-column align-items-center">
                                <img src="{{ $item['avatar'] }}" loading="lazy" class="auth-avatar rounded-circle">
                                <div class="auth-nickname mt-2">{{ $item['nickname'] }}</div>
                                <div class="text-secondary">{{ '@'.$item['fsid'] }}</div>

                                @if (fs_user('detail.uid') == $item['uid'])
                                    <button type="submit" class="btn btn-outline-secondary btn-sm my-2" disabled>{{ fs_lang('userCurrent') }}</button>
                                @else
                                    <form action="{{ route('fresns.api.user.auth') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="uidOrUsername" value="{{ $item['uid'] }}">
                                        @if ($item['hasPassword'])
                                            <a data-bs-target="#userPwdLogin" data-uid="{{ $item['uid'] }}" data-nickname="{{ $item['nickname'] }}" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-outline-secondary btn-sm my-2" onclick="$('#userPwdLoginLabel').text($(this).data('nickname'));$('#userPwdLogin input[name=uidOrUsername]').val($(this).data('uid'))">{{ fs_lang('userPassword') }}</a>
                                        @else
                                            <button type="submit" class="btn btn-outline-secondary btn-sm my-2">{{ fs_lang('select') }}</button>
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
