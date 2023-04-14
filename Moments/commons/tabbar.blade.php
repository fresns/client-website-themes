<div class="clearfix py-5 d-sm-none"></div>
<div class="fs-tabbar fixed-bottom bg-light border-top d-sm-none">
    <div class="row mx-1">
        <div class="col text-center">
            <a class="text-decoration-none {{ Route::is('fresns.home') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.home')) }}">
                <div class="fs-5 pt-2">{!! Route::is('fresns.home') ? '<i class="fa-solid fa-house-user"></i>' : '<i class="fa-solid fa-house"></i>' !!}</div>
                <div class="fs-8 pb-2">{{ fs_lang('home') }}</div>
            </a>
        </div>
        <div class="col text-center">
            <a class="text-decoration-none {{ Route::is([
                'fresns.hashtag.list',
                'fresns.post.list',
                'fresns.comment.list',
                'fresns.user.list',
            ]) ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.hashtag.list')) }}">
                <div class="fs-5 pt-2">{!! Route::is([
                    'fresns.hashtag.list',
                    'fresns.post.list',
                    'fresns.comment.list',
                    'fresns.user.list',
                ]) ? '<i class="fa-solid fa-compass mx-2 mt-1"></i>' : '<i class="fa-regular fa-compass mx-2 mt-1"></i>' !!}</div>
                <div class="fs-8 pb-2">{{ fs_lang('discover') }}</div>
            </a>
        </div>
        <div class="col text-center">
            <a class="text-decoration-none {{ Route::is('fresns.group.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.group.index')) }}">
                <div class="fs-5 pt-2">{!! Route::is(['fresns.group.*']) ? '<i class="fa-solid fa-newspaper"></i>' : '<i class="fa-regular fa-newspaper"></i>' !!}</div>
                <div class="fs-8 pb-2">{{ fs_db_config('menu_group_name') }}</div>
            </a>
        </div>
        <div class="col text-center">
            <a class="text-decoration-none {{ Route::is('fresns.notifications.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.notifications.index')) }}">
                <div class="fs-5 pt-2 position-relative">
                    {!! Route::is(['fresns.notifications.index']) ? '<i class="fa-solid fa-bell"></i>' : '<i class="fa-regular fa-bell"></i>' !!}

                    @if (fs_user()->check())
                        @if (array_sum(fs_user_panel('unreadNotifications')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" style="font-size:0.6rem">{{ array_sum(fs_user_panel('unreadNotifications')) }}</span>
                        @endif
                    @endif
                </div>
                <div class="fs-8 pb-2">{{ fs_db_config('menu_notifications') }}</div>
            </a>
        </div>
        <div class="col text-center">
            <a class="text-decoration-none {{ Route::is('fresns.account.index') ? 'link-fresns' : 'link-secondary' }}" href="{{ fs_route(route('fresns.account.index')) }}">
                <div class="fs-5 pt-2 position-relative">
                    {!! Route::is(['fresns.account.*']) ? '<i class="fa-solid fa-user"></i>' : '<i class="fa-regular fa-user"></i>' !!}

                    @if (fs_user()->check())
                        @if (fs_user_panel('conversations.unreadMessages') > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" style="font-size:0.6rem">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                        @endif
                    @endif
                </div>
                <div class="fs-8 pb-2">{{ fs_lang('userMy') }}</div>
            </a>
        </div>
    </div>
</div>
