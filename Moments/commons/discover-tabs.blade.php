@desktop
@else
    <div class="mx-3 mb-4">
        {{-- Search --}}
        <aside class="mt-2 mb-3">
            <form action="{{ fs_route(route('fresns.search.index')) }}" method="get">
                <input type="hidden" name="searchType" value="post"/>
                <input class="form-control rounded-pill bg-light p-2" name="searchKey" value="{{ request('searchKey') }}" placeholder="{{ fs_lang('search') }}" aria-label="Search">
            </form>
        </aside>

        {{-- Sticky Posts --}}
        @if (fs_sticky_posts())
            <aside class="fs-list-group rounded mb-3">
                <h4 class="fs-5 px-3 pb-1 pt-3">{{ fs_lang('contentSticky') }}</h4>
                @foreach(fs_sticky_posts() as $sticky)
                    @component('components.post.sticky', compact('sticky'))@endcomponent
                @endforeach
            </aside>
        @endif
    </div>
@enddesktop

<nav class="nav nav-pills nav-fill nav-justified gap-2 p-1 small bg-white border rounded-pill shadow-sm m-3">
    <a class="nav-link rounded-pill {{ Route::is('fresns.hashtag.list') ? 'active' : '' }}" href="{{ fs_route(route('fresns.hashtag.list')) }}">{{ fs_db_config('menu_hashtag_list_name') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.user.list') ? 'active' : '' }}" href="{{ fs_route(route('fresns.user.list')) }}">{{ fs_db_config('menu_user_list_name') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.post.list') ? 'active' : '' }}" href="{{ fs_route(route('fresns.post.list')) }}">{{ fs_db_config('menu_post_list_name') }}</a>
    <a class="nav-link rounded-pill {{ Route::is('fresns.comment.list') ? 'active' : '' }}" href="{{ fs_route(route('fresns.comment.list')) }}">{{ fs_db_config('menu_comment_list_name') }}</a>
</nav>
