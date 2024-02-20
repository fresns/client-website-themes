<div class="d-flex mx-3">
    @desktop
        <span class="me-2" style="margin-top:11px;">
            <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
        </span>
    @enddesktop
    <h1 class="fs-5 my-3">{{ fs_config('menu_block_users') }}</h1>
</div>

<nav class="nav nav-pills nav-fill nav-justified gap-2 p-1 small bg-white border rounded-pill shadow-sm m-3">
    @if (fs_config('block_user_setting'))
        <a class="nav-link rounded-pill {{ Route::is('fresns.user.blocking') ? 'active' : '' }}" href="{{ fs_route(route('fresns.user.blocking')) }}">{{ fs_config('user_name') }}</a>
    @endif

    @if (fs_config('block_group_setting'))
        <a class="nav-link rounded-pill {{ Route::is('fresns.group.blocking') ? 'active' : '' }}" href="{{ fs_route(route('fresns.group.blocking')) }}">{{ fs_config('group_name') }}</a>
    @endif

    @if (fs_config('block_hashtag_setting'))
        <a class="nav-link rounded-pill {{ Route::is('fresns.hashtag.blocking') ? 'active' : '' }}" href="{{ fs_route(route('fresns.hashtag.blocking')) }}">{{ fs_config('hashtag_name') }}</a>
    @endif

    @if (fs_config('block_post_setting'))
        <a class="nav-link rounded-pill {{ Route::is('fresns.post.blocking') ? 'active' : '' }}" href="{{ fs_route(route('fresns.post.blocking')) }}">{{ fs_config('post_name') }}</a>
    @endif

    @if (fs_config('block_comment_setting'))
        <a class="nav-link rounded-pill {{ Route::is('fresns.comment.blocking') ? 'active' : '' }}" href="{{ fs_route(route('fresns.comment.blocking')) }}">{{ fs_config('comment_name') }}</a>
    @endif
</nav>
