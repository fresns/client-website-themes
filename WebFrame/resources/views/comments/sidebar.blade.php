<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_db_config('comment_name') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-signpost-2"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- Comment Home --}}
        @if (fs_db_config('menu_comment_status'))
            <a href="{{ fs_route(route('fresns.comment.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.index') ? 'active' : '' }}
                @if (request()->url() === rtrim(fs_route(route('fresns.home')), '/')) active @endif">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-comment-home.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_comment_name') }}
            </a>
        @endif

        {{-- Comment List --}}
        @if (fs_db_config('menu_comment_list_status'))
            <a href="{{ fs_route(route('fresns.comment.list')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.list') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-comment-list.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_comment_list_name') }}
            </a>
        @endif

        {{-- Nearby --}}
        @if (fs_api_config('comment_editor_location'))
            <a href="{{ fs_route(route('fresns.comment.nearby')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.nearby') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-nearby.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_nearby_comments') }}
            </a>
        @endif

        {{-- Likes --}}
        @if (fs_api_config('like_comment_setting'))
            <a href="{{ fs_route(route('fresns.comment.likes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.likes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-likes.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_like_comments') }}
            </a>
        @endif

        {{-- Dislikes --}}
        @if (fs_api_config('dislike_comment_setting'))
            <a href="{{ fs_route(route('fresns.comment.dislikes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.dislikes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-dislikes.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_dislike_comments') }}
            </a>
        @endif

        {{-- Following --}}
        @if (fs_api_config('follow_comment_setting'))
            <a href="{{ fs_route(route('fresns.comment.following')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.following') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-following.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_follow_comments') }}
            </a>
        @endif

        {{-- Blocking --}}
        @if (fs_api_config('block_comment_setting'))
            <a href="{{ fs_route(route('fresns.comment.blocking')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.comment.blocking') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-blocking.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_block_comments') }}
            </a>
        @endif

        {{-- Comment List by Follow --}}
        @if (fs_api_config('view_comments_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.all.comments')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.all.comments') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-follow-comments.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_follow_all_comments') }}
            </a>
        @endif
    </div>
</nav>
