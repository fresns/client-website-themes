@extends('commons.fresns')

@section('title', fs_config('channel_me_users_name'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('me.sidebar')
            </div>

            {{-- Users of this account --}}
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        {{ fs_config('user_name') }}
                        @if (fs_user_overview('multiUser.status'))
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-title="{{ fs_config('user_name') }}"
                                data-url="{{ fs_user_overview('multiUser.service') }}"
                                data-post-message-key="fresnsUsers">
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
                                    <form action="{{ route('fresns.api.post', ['path' => '/api/fresns/v1/user/auth-token']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="uidOrUsername" value="{{ $item['uid'] }}">
                                        @if ($item['hasPin'])
                                            <div class="btn-group my-2">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#userPinLogin" data-uid="{{ $item['uid'] }}" data-nickname="{{ $item['nickname'] }}" onclick="$('#userPinLoginLabel').text($(this).data('nickname'));$('#userPinLogin input[name=uidOrUsername]').val($(this).data('uid'))">
                                                    {{ fs_lang('userPinLogin') }}
                                                </button>
                                                @if (fs_config('account_users_service'))
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split btn-sm" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                                                data-title="{{ fs_lang('userPinReset') }}"
                                                                data-url="{{ fs_config('account_users_service') }}"
                                                                data-uid="{{ $item['uid'] }}"
                                                                data-post-message-key="reload">
                                                                {{ fs_lang('userPinReset') }}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
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
