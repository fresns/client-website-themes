<nav class="navbar navbar-expand-lg fixed-top border-end fs-navbar">
    <div class="container-fluid d-lg-flex flex-lg-column align-items-center">
        @if (! Route::is([
            'fresns.home',
            'fresns.*.index',
            'fresns.notifications.index',
            'fresns.account.login',
            'fresns.account.register',
            'fresns.account.reset.password',
        ]) || Route::is('fresns.messages.index'))
            <a class="btn btn-outline-secondary border-0 rounded-circle d-block d-sm-none" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
        @endif
        <a class="navbar-brand rounded-circle" href="{{ fs_route(route('fresns.home')) }}">
            <img src="{{ fs_db_config('site_icon') }}" alt="{{ fs_db_config('site_name') }}" class="d-none d-sm-block" width="50" height="50">
            <img src="{{ fs_db_config('site_logo') }}" alt="{{ fs_db_config('site_name') }}" class="d-block d-sm-none" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav fs-menus d-flex flex-column">
                {{-- Home --}}
                <li class="nav-item mt-1">
                    <a class="nav-link rounded-pill d-inline-flex {{ Route::is('fresns.home') ? 'active' : '' }}" href="{{ fs_route(route('fresns.home')) }}">
                        {!! Route::is('fresns.home') ? '<i class="fa-solid fa-house-user mx-2 mt-1"></i>' : '<i class="fa-solid fa-house mx-2 mt-1"></i>' !!}
                        <span class="me-2">{{ fs_lang('home') }}</span>
                    </a>
                </li>
                {{-- Explore --}}
                <li class="nav-item mt-1">
                    <a class="nav-link rounded-pill d-inline-flex {{ Route::is([
                        'fresns.hashtag.list',
                        'fresns.post.list',
                        'fresns.comment.list',
                        'fresns.user.list',
                    ]) ? 'active' : '' }}" href="{{ fs_route(route('fresns.hashtag.list')) }}">{!! Route::is([
                            'fresns.hashtag.list',
                            'fresns.post.list',
                            'fresns.comment.list',
                            'fresns.user.list',
                        ]) ? '<i class="fa-solid fa-compass mx-2 mt-1"></i>' : '<i class="fa-regular fa-compass mx-2 mt-1"></i>' !!}
                        <span class="me-2">{{ fs_lang('discover') }}</span>
                    </a>
                </li>
                {{-- Communities --}}
                <li class="nav-item mt-1">
                    <a class="nav-link rounded-pill d-inline-flex {{ Route::is(['fresns.group.index', 'fresns.group.detail']) ? 'active' : '' }}" href="{{ fs_route(route('fresns.group.index')) }}">
                        {!! Route::is(['fresns.group.*']) ? '<i class="fa-solid fa-newspaper mx-2 mt-1"></i>' : '<i class="fa-regular fa-newspaper mx-2 mt-1"></i>' !!}
                        <span class="me-2">{{ fs_db_config('menu_group_name') }}</span>
                    </a>
                </li>
                @if (fs_user()->check())
                    {{-- Notifications --}}
                    <li class="nav-item mt-1">
                        <a class="nav-link rounded-pill d-inline-flex {{ Route::is(['fresns.notifications.index']) ? 'active' : '' }}" href="{{ fs_route(route('fresns.notifications.index')) }}">
                            {!! Route::is(['fresns.notifications.index']) ? '<i class="fa-solid fa-bell mx-2 mt-1"></i>' : '<i class="fa-regular fa-bell mx-2 mt-1"></i>' !!}
                            <span class="me-2">{{ fs_db_config('menu_notifications') }}</span>

                            @if (array_sum(fs_user_panel('unreadNotifications')) > 0)
                                <span class="badge bg-danger rounded-pill">{{ array_sum(fs_user_panel('unreadNotifications')) }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Messages --}}
                    @if (fs_api_config('conversation_status'))
                        <li class="nav-item mt-1">
                            <a class="nav-link rounded-pill d-inline-flex {{ Route::is(['fresns.messages.index', 'fresns.messages.conversation']) ? 'active' : '' }}" href="{{ fs_route(route('fresns.messages.index')) }}">
                                {!! Route::is(['fresns.messages.index', 'fresns.messages.conversation']) ? '<i class="fa-solid fa-envelope mx-2 mt-1"></i>' : '<i class="fa-regular fa-envelope mx-2 mt-1"></i>' !!}
                                <span class="me-2">{{ fs_db_config('menu_conversations') }}</span>

                                @if (fs_user_panel('conversations.unreadMessages') > 0)
                                    <span class="badge bg-danger rounded-pill">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                    {{-- Profile --}}
                    <li class="nav-item mt-1">
                        <a class="nav-link rounded-pill d-inline-flex {{ Route::is('fresns.profile.*', ['uidOrUsername' => fs_user('detail.fsid')]) ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => fs_user('detail.fsid')])) }}">
                            {!! Route::is('fresns.profile.*', ['uidOrUsername' => fs_user('detail.fsid')]) ? '<i class="fa-solid fa-user mx-2 mt-1"></i>' : '<i class="fa-regular fa-user mx-2 mt-1"></i>' !!}
                            <span class="me-2">{{ fs_lang('userProfile') }}</span>
                        </a>
                    </li>
                    {{-- More --}}
                    <li class="nav-item mt-1 dropup-center dropup">
                        <a class="nav-link rounded-pill d-inline-flex" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-list-ul mx-2 mt-1"></i>
                            <span class="me-2">{{ fs_lang('more') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            {{-- Draft Box --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}">
                                    <i class="fa-solid fa-envelope-open-text me-2"></i>
                                    {{ fs_db_config('menu_editor_drafts') }}

                                    @if (array_sum(fs_user_panel('draftCount')) > 0)
                                        <span class="badge bg-success rounded-pill">{{ array_sum(fs_user_panel('draftCount')) }}</span>
                                    @endif
                                </a>
                            <li>
                            {{-- Blacklist --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ fs_route(route('fresns.user.blocking')) }}">
                                    <i class="fa-solid fa-user-shield me-2"></i>
                                    {{ fs_db_config('menu_block_users') }}
                                </a>
                            <li>
                            {{-- Favorites --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ fs_route(route('fresns.post.following')) }}">
                                    <i class="fa-solid fa-box-archive me-2"></i>
                                    {{ fs_db_config('menu_follow_posts') }}
                                </a>
                            <li>
                            {{-- Wallet --}}
                            @if (fs_api_config('wallet_status'))
                                <li>
                                    <a class="dropdown-item py-2" href="{{ fs_route(route('fresns.account.wallet')) }}"><i class="fa-solid fa-wallet me-2"></i> {{ fs_db_config('menu_account_wallet') }}</a>
                                </li>
                            @endif
                            {{-- Settings --}}
                            <li><a class="dropdown-item py-2" href="{{ fs_route(route('fresns.account.settings')) }}"><i class="fa-solid fa-gear me-2"></i> {{ fs_db_config('menu_account_settings') }}</a></li>
                            {{-- Switch Languages --}}
                            @if (fs_api_config('language_status'))
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="#translate" data-bs-toggle="modal"><i class="fa-solid fa-language me-2"></i> {{ fs_lang('optionLanguage') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    {{-- Publish --}}
                    <li class="nav-item mt-4">
                        <div class="d-grid gap-2">
                            @if (fs_db_config('fs_theme_quick_publish'))
                                <button class="btn btn-warning text-white rounded-pill fs-create" type="button" data-bs-toggle="modal" data-bs-target="#createModal">{{ fs_db_config('publish_post_name') }}</button>
                            @else
                                <a class="btn btn-warning text-white rounded-pill fs-create" href="{{ fs_route(route('fresns.editor.index', ['type' => 'post'])) }}">{{ fs_db_config('publish_post_name') }}</a>
                            @endif
                        </div>
                    </li>
                @else
                    {{-- Switch Languages --}}
                    @if (fs_api_config('language_status'))
                        <li class="nav-item mt-4 d-grid gap-2 dropup-center dropup">
                            <button class="btn btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-language"></i>
                                @foreach(fs_api_config('language_menus') as $lang)
                                    @if (current_lang_tag() == $lang['langTag']) {{ $lang['langName'] }} @endif
                                @endforeach
                            </button>
                            <ul class="dropdown-menu">
                                @foreach(fs_api_config('language_menus') as $lang)
                                    @if ($lang['isEnabled'])
                                        <li>
                                            <a class="dropdown-item py-3 @if (current_lang_tag() == $lang['langTag']) active @endif" hreflang="{{ $lang['langTag'] }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang['langTag'], null, [], true) }}">
                                                {{ $lang['langName'] }}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>

            {{-- Account --}}
            <div class="fs-account dropup-center dropup my-4 my-lg-0">
                @if (fs_user()->check())
                    <button type="button" class="btn btn-account rounded-pill d-flex py-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="nav-avatar ms-1"><img src="{{ fs_user('detail.avatar') }}" class="rounded-circle"></div>
                        <div class="text-start ms-2">
                            <div class="nav-nickname">{{ fs_user('detail.nickname') }}</div>
                            <div class="text-secondary fs-7">{{ '@'.fs_user('detail.username') }}</div>
                        </div>
                        <div class="text-secondary ms-4 pt-2 me-1" style="padding-top: 10px"><i class="fa-solid fa-ellipsis"></i></div>
                    </button>
                    <ul class="dropdown-menu">
                        {{-- User Center --}}
                        <li><a class="dropdown-item py-3" href="{{ fs_route(route('fresns.account.index')) }}"><i class="fa-regular fa-circle-user me-2"></i> {{ fs_db_config('menu_account') }}</a></li>
                        {{-- Manage Users --}}
                        @if (fs_user_panel('multiUser.status') || count(fs_account('detail.users')) > 1)
                            <li><a class="dropdown-item py-3" href="{{ fs_route(route('fresns.account.users')) }}"><i class="fa-solid fa-user-gear me-2"></i> {{ fs_db_config('menu_account_users') }}</a></li>
                        @endif
                        {{-- Switch Users --}}
                        @if (count(fs_account('detail.users')) > 1)
                            <li><a class="dropdown-item py-3" href="#userAuth" id="switch-user" data-bs-toggle="modal"><i class="fa-solid fa-users me-2"></i> {{ fs_lang('optionUser') }}</a></li>
                        @endif
                        {{-- Logout --}}
                        <li><a class="dropdown-item py-3" href="{{ fs_route(route('fresns.account.logout', ['redirectURL' => request()->fullUrl()])) }}"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> {{ fs_lang('accountLogout') }}</a></li>
                    </ul>
                @else
                    <a class="btn btn-outline-success" href="{{ fs_route(route('fresns.account.login', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountLogin') }}</a>

                    @if (fs_api_config('site_public_status'))
                        @if (fs_api_config('site_public_service'))
                            <button class="btn btn-outline-primary ms-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                data-type="account"
                                data-scene="join"
                                data-post-message-key="fresnsJoin"
                                data-title="{{ fs_lang('accountRegister') }}"
                                data-url="{{ fs_api_config('site_public_service') }}">
                                {{ fs_lang('accountRegister') }}
                            </button>
                        @else
                            <a class="btn btn-outline-primary ms-3" href="{{ fs_route(route('fresns.account.register', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                        @endif
                    @endif
                @endif
            </div>
            {{-- navbar-collapse end --}}
        </div>
    </div>
</nav>
