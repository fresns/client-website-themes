@extends('commons.fresns')

@section('title', fs_db_config('menu_account'))

@section('content')
    <div class="bg-body d-flex flex-row">
        <div class="avatar">
            @if (fs_user('detail.decorate'))
                <img src="{{ fs_user('detail.decorate') }}" alt="Avatar Decorate" loading="lazy" class="profile-decorate">
            @endif
            <img src="{{ fs_user('detail.avatar') }}" alt="{{ fs_user('detail.nickname') }}" loading="lazy" class="profile-avatar rounded-circle">
        </div>
        <div class="d-flex align-items-center">
            <div class="ms-3">
                <div class="fs-4 fw-semibold mt-3">
                    {{ fs_user('detail.nickname') }}
                    @if (fs_user('detail.verifiedStatus'))
                        @if (fs_user('detail.verifiedIcon'))
                            <img src="{{ fs_user('detail.verifiedIcon') }}" alt="Verified" loading="lazy" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_user('detail.verifiedDesc') }}" height="20">
                        @else
                            <img src="/assets/themes/Moments/images/icon-verified.png" alt="Verified" loading="lazy" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_user('detail.verifiedDesc') }}" height="20">
                        @endif
                    @endif
                </div>
                <div class="fs-6 text-secondary">{{ '@'.fs_user('detail.fsid') }}</div>
                <div class="user-role d-flex mt-2">
                    @if (fs_user('detail.roleIconDisplay'))
                        <div class="user-role-icon"><img src="{{ fs_user('detail.roleIcon') }}" alt="{{ fs_user('detail.roleName') }}" loading="lazy" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_user('detail.roleName') }}"></div>
                    @endif
                    @if (fs_user('detail.roleNameDisplay'))
                        <div class="user-role-name"><span class="badge rounded-pill">{{ fs_user('detail.roleName') }}</span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- features --}}
    <div class="clearfix">
        @foreach(fs_user_panel('features') as $feature)
            <div class="position-relative mx-3 mt-3" style="width:52px">
                <a class="text-decoration-none" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="account"
                    data-scene="featureExtension"
                    data-post-message-key="fresnsFeatureExtension"
                    data-title="{{ fs_lang('accountLogin') }}"
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

    @if (fs_api_config('conversation_status'))
        <div class="list-group rounded-0 my-3">
            {{-- Conversation --}}
            <a href="{{ fs_route(route('fresns.messages.index')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <span class="py-2"><i class="fa-regular fa-envelope me-2"></i> {{ fs_db_config('menu_conversations') }}</span>
                <span class="py-2 text-black-50">
                    @if (fs_user_panel('conversations.unreadMessages') > 0)
                        <span class="badge bg-danger rounded-pill">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                    @endif
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </a>
        </div>
    @endif

    <div class="list-group rounded-0 my-3">
        {{-- Wallet --}}
        @if (fs_api_config('wallet_status'))
            <a href="{{ fs_route(route('fresns.account.wallet')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <span class="py-2"><i class="fa-solid fa-wallet me-2"></i> {{ fs_db_config('menu_account_wallet') }}</span>
                <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
        @endif
        {{-- Draft Box --}}
        <a href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <span class="py-2"><i class="fa-solid fa-envelope-open-text me-2"></i> {{ fs_db_config('menu_editor_drafts') }}</span>
            <span class="py-2 text-black-50">
                @if (array_sum(fs_user_panel('draftCount')) > 0)
                    <span class="badge bg-success rounded-pill">{{ array_sum(fs_user_panel('draftCount')) }}</span>
                @endif
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        </a>
        {{-- Favorites --}}
        <a href="{{ fs_route(route('fresns.post.following')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <span class="py-2"><i class="fa-solid fa-box-archive me-2"></i> {{ fs_db_config('menu_follow_posts') }}</span>
            <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
        </a>
        {{-- Blacklist --}}
        <a href="{{ fs_route(route('fresns.user.blocking')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <span class="py-2"><i class="fa-solid fa-user-shield me-2"></i> {{ fs_db_config('menu_block_users') }}</span>
            <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
        </a>
    </div>

    <div class="list-group rounded-0 my-3">
        {{-- Settings --}}
        <a href="{{ fs_route(route('fresns.account.settings')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <span class="py-2"><i class="fa-solid fa-gear me-2"></i> {{ fs_db_config('menu_account_settings') }}</span>
            <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
        </a>
        {{-- Manage Users --}}
        @if (fs_user_panel('multiUser.status') || count(fs_account('detail.users')) > 1)
            {{-- User Page --}}
            <a href="{{ fs_route(route('fresns.account.users')) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <span class="py-2"><i class="fa-solid fa-user-gear me-2"></i> {{ fs_db_config('menu_account_users') }}</span>
                <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
            {{-- Switch Users --}}
            <a href="#userAuth" id="switch-user" data-bs-toggle="modal" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <span class="py-2"><i class="fa-solid fa-users me-2"></i> {{ fs_lang('optionUser') }}</span>
                <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
            </a>
        @endif
        {{-- Switch Languages --}}
        <a href="#translate" data-bs-toggle="modal" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <span class="py-2"><i class="fa-solid fa-language me-2"></i> {{ fs_lang('optionLanguage') }}</span>
            <span class="py-2 text-black-50"><i class="fa-solid fa-chevron-right"></i></span>
        </a>
    </div>

    <div class="d-grid gap-2 pt-4 pb-5 px-4">
        <a class="btn btn-danger" href="{{ fs_route(route('fresns.account.logout')) }}" role="button">{{ fs_lang('accountLogout') }}</a>
    </div>
@endsection

@push('style')
    <style>
        body {
            background: #f0f2f5;
        }
    </style>
@endpush
