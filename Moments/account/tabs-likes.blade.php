<div class="d-flex justify-content-between mx-3 mt-3">
    <h1 class="fs-5">{{ fs_db_config('menu_like_posts') }}</h1>
</div>

<nav class="nav nav-pills nav-fill nav-justified gap-2 p-1 small bg-white border rounded-pill shadow-sm m-3">
    <a class="nav-link rounded-pill {{ Route::is('fresns.post.likes') ? 'active' : '' }}" href="{{ fs_route(route('fresns.post.likes')) }}">{{ fs_db_config('post_name') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.comment.likes') ? 'active' : '' }}" href="{{ fs_route(route('fresns.comment.likes')) }}">{{ fs_db_config('comment_name') }}</a>
</nav>
