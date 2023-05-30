@if (Route::is([
    'fresns.home',
    'fresns.portal',
    'fresns.post.index',
    'fresns.post.nearby',
    'fresns.group.index',
    'fresns.follow.all.posts',
    'fresns.account.index',
    'fresns.account.login',
    'fresns.account.register',
    'fresns.account.reset.password',
]) || request()->url() == fs_route(route('fresns.custom.page', ['name' => 'channels'])))
    <div class="clearfix py-5 d-sm-none"></div>
    <div class="fs-tabbar fixed-bottom bg-light border-top d-sm-none">
        <div class="row mx-1">
            {{-- home --}}
            <div class="col text-center">
                <a class="text-decoration-none {{ Route::is('fresns.home') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.home')) }}">
                    <div class="fs-5 pt-2">{!! Route::is('fresns.home') ? '<i class="fa-solid fa-house-user"></i>' : '<i class="fa-solid fa-house"></i>' !!}</div>
                    <div class="fs-8 pb-2">{{ fs_lang('home') }}</div>
                </a>
            </div>

            {{-- portal or Post --}}
            <div class="col text-center">
                @if (fs_db_config('default_homepage') == 'post')
                    <a class="text-decoration-none {{ Route::is('fresns.portal') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.portal')) }}">
                        <div class="fs-5 pt-2">{!! Route::is('fresns.portal') ? '<i class="fa-solid fa-newspaper"></i>' : '<i class="fa-regular fa-newspaper"></i>' !!}</div>
                        <div class="fs-8 pb-2">{{ fs_db_config('menu_portal_name') }}</div>
                    </a>
                @else
                    <a class="text-decoration-none {{ Route::is('fresns.post.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.post.index')) }}">
                        <div class="fs-5 pt-2">{!! Route::is('fresns.post.index') ? '<i class="fa-solid fa-newspaper"></i>' : '<i class="fa-regular fa-newspaper"></i>' !!}</div>
                        <div class="fs-8 pb-2">{{ fs_db_config('menu_post_name') }}</div>
                    </a>
                @endif
            </div>

            {{-- group --}}
            <div class="col text-center">
                <a class="text-decoration-none {{ Route::is('fresns.group.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.group.index')) }}">
                    <div class="fs-5 pt-2">{!! Route::is(['fresns.group.*']) ? '<i class="fa-solid fa-building"></i>' : '<i class="fa-regular fa-building"></i>' !!}</div>
                    <div class="fs-8 pb-2">{{ fs_db_config('menu_group_name') }}</div>
                </a>
            </div>

            {{-- channels --}}
            <div class="col text-center">
                <a class="text-decoration-none {{ Route::is('fresns.custom.page', ['name' => 'channels']) ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.custom.page', ['name' => 'channels'])) }}">
                    <div class="fs-5 pt-2">{!! Route::is('fresns.custom.page', ['name' => 'channels']) ? '<i class="fa-solid fa-compass"></i>' : '<i class="fa-regular fa-compass"></i>' !!}</div>
                    <div class="fs-8 pb-2">{{ fs_lang('discover') }}</div>
                </a>
            </div>

            {{-- user --}}
            <div class="col text-center">
                <a class="text-decoration-none {{ Route::is('fresns.account.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.account.index')) }}">
                    <div class="fs-5 pt-2 position-relative">
                        {!! Route::is(['fresns.account.*']) ? '<i class="fa-solid fa-user"></i>' : '<i class="fa-regular fa-user"></i>' !!}

                        @if (fs_user()->check())
                            @php
                                $unreadCount = fs_user_panel('conversations.unreadMessages') + array_sum(fs_user_panel('unreadNotifications'));
                            @endphp
                            @if ($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" style="font-size:0.6rem">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="fs-8 pb-2">{{ fs_lang('userMy') }}</div>
                </a>
            </div>
        </div>
    </div>
@endif
