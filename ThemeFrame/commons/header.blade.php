<header class="fixed-top">
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ fs_route(route('fresns.home')) }}"><img src="{{ fs_db_config('site_logo') }}" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsNavbar" aria-controls="fresnsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-3" id="fresnsNavbar">
                {{-- navbar --}}
                <ul class="nav nav-pills me-auto my-4 my-lg-0">
                    {{-- portal --}}
                    @if (fs_db_config('menu_portal_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('fresns.portal') ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'portal') active @endif"
                                href="{{ fs_route(route('fresns.portal')) }}">
                                {{ fs_db_config('menu_portal_name') }}
                            </a>
                        </li>
                    @endif

                    {{-- user --}}
                    @if (fs_db_config('menu_user_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.user.*', 'fresns.follow.user.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'user') active @endif"
                                href="{{ fs_route(route('fresns.user.index')) }}">
                                {{ fs_db_config('menu_user_name') }}
                            </a>
                        </li>
                    @endif

                    {{-- group --}}
                    @if (fs_db_config('menu_group_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.group.*', 'fresns.follow.group.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'group') active @endif"
                                href="{{ fs_route(route('fresns.group.index')) }}">
                                {{ fs_db_config('menu_group_name') }}
                            </a>
                        </li>
                    @endif

                    {{-- hashtag --}}
                    @if (fs_db_config('menu_hashtag_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.hashtag.*', 'fresns.follow.hashtag.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'hashtag') active @endif"
                                href="{{ fs_route(route('fresns.hashtag.index')) }}">
                                {{ fs_db_config('menu_hashtag_name') }}
                            </a>
                        </li>
                    @endif

                    {{-- post --}}
                    @if (fs_db_config('menu_post_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.post.*', 'fresns.follow.all.posts']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'post') active @endif"
                                href="{{ fs_route(route('fresns.post.index')) }}">
                                {{ fs_db_config('menu_post_name') }}
                            </a>
                        </li>
                    @endif

                    {{-- comment --}}
                    @if (fs_db_config('menu_comment_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.comment.*', 'fresns.follow.all.comments']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'comment') active @endif"
                                href="{{ fs_route(route('fresns.comment.index')) }}">
                                {{ fs_db_config('menu_comment_name') }}
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- search --}}
                <form class="me-3 my-4 my-lg-0" action="{{ fs_route(route('fresns.search.index')) }}" method="get">
                    <input type="hidden" name="searchType" value="post"/>
                    <input class="form-control" name="searchKey" value="{{ request('searchKey') }}" placeholder="{{ fs_lang('search') }}" aria-label="Search">
                </form>

                {{-- Login Status --}}
                <div class="d-flex mb-4 mb-lg-0">
                    @if (fs_user()->check())
                        {{-- Logged In --}}
                        <a class="btn" href="{{ fs_route(route('fresns.account.index')) }}" role="button"><img src="{{ fs_user('detail.avatar') }}" loading="lazy" class="nav-avatar rounded-circle"> {{ fs_user('detail.nickname') }}</a>

                        <button type="button" class="btn btn-outline-secondary btn-nav ms-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i></button>

                        <a href="{{ fs_route(route('fresns.notifications.index')) }}"role="button" class="btn btn-outline-secondary btn-nav ms-2 rounded-circle position-relative">
                            <i class="bi bi-bell"></i>
                            @if (array_sum(fs_user_panel('unreadNotifications')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ array_sum(fs_user_panel('unreadNotifications')) }}</span>
                            @endif
                        </a>

                        @if (fs_api_config('conversation_status'))
                            <a href="{{ fs_route(route('fresns.messages.index')) }}"role="button" class="btn btn-outline-secondary btn-nav ms-2 rounded-circle position-relative">
                                <i class="bi bi-envelope"></i>
                                @if (fs_user_panel('conversations.unreadMessages') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                                @endif
                            </a>
                        @endif

                        {{-- User Menus --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-nav ms-2 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-caret-down-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                {{-- User Center --}}
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.index')) }}"><i class="bi bi-person-fill"></i> {{ fs_db_config('menu_account') }}</a></li>

                                {{-- Notifications --}}
                                <li>
                                    <a class="dropdown-item" href="{{ fs_route(route('fresns.notifications.index')) }}">
                                        <i class="bi bi-bell"></i>
                                        {{ fs_db_config('menu_notifications') }}

                                        @if (array_sum(fs_user_panel('unreadNotifications')) > 0)
                                            <span class="badge bg-danger">{{ array_sum(fs_user_panel('unreadNotifications')) }}</span>
                                        @endif
                                    </a>
                                </li>

                                {{-- Conversations --}}
                                @if (fs_api_config('conversation_status'))
                                    <li>
                                        <a class="dropdown-item" href="{{ fs_route(route('fresns.messages.index')) }}">
                                            <i class="bi bi-envelope"></i>
                                            {{ fs_db_config('menu_conversations') }}

                                            @if (fs_user_panel('conversations.unreadMessages') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- Drafts --}}
                                <li>
                                    <a class="dropdown-item" href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}">
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ fs_db_config('menu_editor_drafts') }}

                                        @if (array_sum(fs_user_panel('draftCount')) > 0)
                                            <span class="badge bg-primary">{{ array_sum(fs_user_panel('draftCount')) }}</span>
                                        @endif
                                    </a>
                                </li>

                                {{-- Wallet --}}
                                @if (fs_api_config('wallet_status'))
                                    <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.wallet')) }}"><i class="bi bi-wallet"></i> {{ fs_db_config('menu_account_wallet') }}</a></li>
                                @endif

                                {{-- Users of this account --}}
                                @if (fs_user_panel('multiUser.status') || count(fs_account('detail.users')) > 1)
                                    <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.users')) }}"><i class="bi bi-people"></i> {{ fs_db_config('menu_account_users') }}</a></li>
                                @endif

                                {{-- Settings --}}
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.settings')) }}"><i class="bi bi-gear"></i> {{ fs_db_config('menu_account_settings') }}</a></li>
                                <li><hr class="dropdown-divider"></li>

                                {{-- Switch Languages --}}
                                @if (fs_api_config('language_status'))
                                    <li><a class="dropdown-item" href="#translate" data-bs-toggle="modal"><i class="bi bi-translate"></i> {{ fs_lang('optionLanguage') }}</a></li>
                                @endif

                                {{-- Switch Users --}}
                                @if (count(fs_account('detail.users')) > 1)
                                    <li><a class="dropdown-item" href="#userAuth" id="switch-user" data-bs-toggle="modal"><i class="bi bi-people"></i> {{ fs_lang('optionUser') }}</a></li>
                                @endif

                                {{-- Logout --}}
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.logout')) }}"><i class="bi bi-power"></i> {{ fs_lang('accountLogout') }}</a></li>
                            </ul>
                        </div>
                    @else
                        {{-- Not Logged In --}}
                        <a class="btn btn-outline-success me-3" href="{{ fs_route(route('fresns.account.login', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountLogin') }}</a>

                        @if (fs_api_config('site_public_status'))
                            @if (fs_api_config('site_public_service'))
                                <button class="btn btn-success me-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                    data-type="account"
                                    data-scene="join"
                                    data-post-message-key="fresnsJoin"
                                    data-title="{{ fs_lang('accountRegister') }}"
                                    data-url="{{ fs_api_config('site_public_service') }}">
                                    {{ fs_lang('accountRegister') }}
                                </button>
                            @else
                                <a class="btn btn-success me-3" href="{{ fs_route(route('fresns.account.register', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                            @endif
                        @endif

                        @if (fs_api_config('language_status'))
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="language" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-translate"></i>
                                    @foreach(fs_api_config('language_menus') as $lang)
                                        @if (current_lang_tag() == $lang['langTag']) {{ $lang['langName'] }} @endif
                                    @endforeach
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @foreach(fs_api_config('language_menus') as $lang)
                                        @if ($lang['isEnable'])
                                            <li>
                                                <a class="dropdown-item @if (current_lang_tag() == $lang['langTag']) active @endif" hreflang="{{ $lang['langTag'] }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang['langTag'], null, [], true) }}">
                                                    {{ $lang['langName'] }}
                                                    @if ($lang['areaName'])
                                                        {{ '('.$lang['areaName'].')' }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    @endif
                </div>

            </div>
        </div>
    </nav>
</header>
