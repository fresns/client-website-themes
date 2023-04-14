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

{{-- Digest Posts --}}
<aside class="fs-list-group rounded mb-3">
    <h4 class="fs-5 px-3 pb-1 pt-3">{{ fs_lang('contentHotList') }}</h4>
    @foreach(fs_list('posts') as $topPost)
        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $topPost['pid']])) }}" class="list-group-item list-group-item-action text-break px-3 py-2">
            <i class="fa-solid fa-arrow-trend-up me-1 text-primary"></i>
            {{ $topPost['title'] ?? Str::limit(strip_tags($topPost['content']), 80) }}
        </a>
    @endforeach
</aside>

{{-- Recommend Users --}}
<aside class="fs-list-group rounded mb-3">
    <h4 class="fs-5 px-3 pb-1 pt-3">{{ fs_lang('contentRecommend') }}</h4>
    @foreach(fs_index_list('users') as $topUser)
        @component('components.user.sidebar-list', compact('topUser'))@endcomponent
    @endforeach
</aside>
