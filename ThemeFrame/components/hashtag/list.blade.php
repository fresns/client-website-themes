<article class="d-flex">
    @if ($hashtag['cover'])
        <section class="flex-shrink-0">
            <a href="{{ fs_route(route('fresns.hashtag.detail', ['hid' => $hashtag['hid']])) }}"><img src="{{ $hashtag['cover'] }}" loading="lazy" alt="{{ $hashtag['hname'] }}" class="rounded list-cover"></a>
        </section>
    @endif
    <div class="flex-grow-1 ms-3">
        <header class="d-lg-flex">
            <section class="d-flex">
                <a href="{{ fs_route(route('fresns.hashtag.detail', ['hid' => $hashtag['hid']])) }}" class="text-nowrap overflow-hidden list-name">{{ $hashtag['hname'] }}</a>
                <div class="badge-bg-info ms-2">
                    <span class="badge rounded-pill">{{ $hashtag['postCount'] }} {{ fs_db_config('post_name') }}</span>
                    <span class="badge rounded-pill">{{ $hashtag['postDigestCount'] }} {{ fs_lang('contentDigest') }}</span>
                </div>
            </section>

            <section class="list-btn ms-auto">
                {{-- Like --}}
                @if ($hashtag['interaction']['likeSetting'])
                    @component('components.hashtag.mark.like', [
                        'hid' => $hashtag['hid'],
                        'interaction' => $hashtag['interaction'],
                        'count' => $hashtag['likeCount'],
                    ])@endcomponent
                @endif

                {{-- Dislike --}}
                @if ($hashtag['interaction']['dislikeSetting'])
                    @component('components.hashtag.mark.dislike', [
                        'hid' => $hashtag['hid'],
                        'interaction' => $hashtag['interaction'],
                        'count' => $hashtag['dislikeCount'],
                    ])@endcomponent
                @endif

                {{-- Follow --}}
                @if ($hashtag['interaction']['followSetting'])
                    @component('components.hashtag.mark.follow', [
                        'hid' => $hashtag['hid'],
                        'interaction' => $hashtag['interaction'],
                        'count' => $hashtag['followCount'],
                    ])@endcomponent
                @endif

                {{-- Block --}}
                @if ($hashtag['interaction']['blockSetting'])
                    @component('components.hashtag.mark.block', [
                        'hid' => $hashtag['hid'],
                        'interaction' => $hashtag['interaction'],
                        'count' => $hashtag['blockCount'],
                    ])@endcomponent
                @endif
            </section>
        </header>

        @if ($hashtag['description'])
            <section class="fs-7 mt-1 text-secondary">{{ $hashtag['description'] }}</section>
        @endif
    </div>
</article>
