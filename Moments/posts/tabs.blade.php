<nav class="nav nav-pills nav-fill nav-justified gap-2 p-1 small bg-white border rounded-pill shadow-sm m-3">
    <a class="nav-link rounded-pill {{ Route::is('fresns.post.index') ? 'active' : '' }} @if (request()->url() === rtrim(fs_route(route('fresns.home')), '/')) active @endif" href="{{ fs_route(route('fresns.post.index')) }}">{{ fs_config('channel_post_name') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.follow.all.posts') ? 'active' : '' }}" href="{{ fs_route(route('fresns.follow.all.posts')) }}">{{ fs_config('menu_follow_all_posts') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.post.nearby') ? 'active' : '' }}" href="{{ fs_route(route('fresns.post.nearby')) }}">{{ fs_config('menu_nearby_posts') }}</a>
</nav>
