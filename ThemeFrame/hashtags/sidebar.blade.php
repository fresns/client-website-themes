<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_db_config('hashtag_name') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-signpost-2"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- Hashtag Home --}}
        @if (fs_db_config('menu_hashtag_status'))
            <a href="{{ fs_route(route('fresns.hashtag.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.index') ? 'active' : '' }}
                @if (request()->url() === rtrim(fs_route(route('fresns.home')), '/')) active @endif">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-hashtag-home.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_hashtag_name') }}
            </a>
        @endif

        {{-- Hashtag List --}}
        @if (fs_db_config('menu_hashtag_list_status'))
            <a href="{{ fs_route(route('fresns.hashtag.list')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.list') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-hashtag-list.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_hashtag_list_name') }}
            </a>
        @endif

        {{-- Likes --}}
        @if (fs_api_config('like_hashtag_setting'))
            <a href="{{ fs_route(route('fresns.hashtag.likes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.likes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-likes.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_like_hashtags') }}
            </a>
        @endif

        {{-- Dislikes --}}
        @if (fs_api_config('dislike_hashtag_setting'))
            <a href="{{ fs_route(route('fresns.hashtag.dislikes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.dislikes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-dislikes.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_dislike_hashtags') }}
            </a>
        @endif

        {{-- Following --}}
        @if (fs_api_config('follow_hashtag_setting'))
            <a href="{{ fs_route(route('fresns.hashtag.following')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.following') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-following.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_follow_hashtags') }}
            </a>
        @endif

        {{-- Blocking --}}
        @if (fs_api_config('block_hashtag_setting'))
            <a href="{{ fs_route(route('fresns.hashtag.blocking')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.hashtag.blocking') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-blocking.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_block_hashtags') }}
            </a>
        @endif

        {{-- Post List by Follow Hashtags --}}
        @if (fs_api_config('view_posts_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.hashtag.posts')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.hashtag.posts') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-follow-posts.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_follow_hashtag_posts') }}
            </a>
        @endif

        {{-- Comment List by Follow Hashtags --}}
        @if (fs_api_config('view_comments_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.hashtag.comments')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.hashtag.comments') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-follow-comments.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_follow_hashtag_comments') }}
            </a>
        @endif
    </div>
</nav>
