@extends('commons.fresns')

@section('title', fs_config('channel_me_users_name'))

@section('content')
    <div class="d-flex mx-3">
        @desktop
            <span class="me-2" style="margin-top:11px;">
                <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
            </span>
        @enddesktop
        <h1 class="fs-5 my-3">{{ fs_config('user_name') }}</h1>
        <div>
            @if (fs_user_overview('multiUser.status'))
                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-type="account"
                    data-scene="users"
                    data-post-message-key="fresnsUsers"
                    data-title="{{ fs_config('user_name') }}"
                    data-url="{{ fs_user_overview('multiUser.service') }}">
                    <i class="fa-solid fa-user-gear"></i>
                    {{ fs_lang('setting') }}
                </button>
            @endif
        </div>
    </div>

    <div class="row p-3">
        @foreach(fs_account('detail.users') as $item)
            <div class="col-6 col-md-4 d-flex flex-column align-items-center">
                <img src="{{ $item['avatar'] }}" loading="lazy" class="auth-avatar rounded-circle">
                <div class="auth-nickname mt-2">{{ $item['nickname'] }}</div>
                <div class="text-secondary">{{ '@' . $item['username'] }}</div>

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
                                                data-type="account"
                                                data-scene="resetPin"
                                                data-post-message-key="reload"
                                                data-title="{{ fs_lang('userPinReset') }}"
                                                data-url="{{ fs_config('account_users_service') }}">
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
@endsection
