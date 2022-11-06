<article class="d-flex my-3">
    @if ($group['cover'])
        <section class="flex-shrink-0">
            <img src="{{ $group['cover'] }}" alt="{{ $group['gname'] }}" class="rounded list-cover">
        </section>
    @endif
    <div class="flex-grow-1 ms-3">
        <header class="d-lg-flex">
            <section class="d-flex">
                {{ $group['gname'] }}
                @if ($group['recommend'])
                    <img src="/assets/themes/ThemeFrame/images/icon-recommend.png" class="list-recommend" alt="Group Recommend">
                @endif
            </section>

            <section class="list-btn ms-auto">
                {{-- Like --}}
                @if ($group['interactive']['likeSetting'])
                    @component('components.group.mark.like', [
                        'gid' => $group['gid'],
                        'interactive' => $group['interactive'],
                        'count' => $group['likeCount'],
                    ])@endcomponent
                @endif

                {{-- Dislike --}}
                @if ($group['interactive']['dislikeSetting'])
                    @component('components.group.mark.dislike', [
                        'gid' => $group['gid'],
                        'interactive' => $group['interactive'],
                        'count' => $group['dislikeCount'],
                    ])@endcomponent
                @endif

                {{-- Follow --}}
                @if ($group['interactive']['followSetting'])
                    @component('components.group.mark.follow', [
                        'gid' => $group['gid'],
                        'gname' => $group['gname'],
                        'followType' => $group['followType'],
                        'followUrl' => $group['followUrl'],
                        'interactive' => $group['interactive'],
                        'count' => $group['followCount'],
                    ])@endcomponent
                @endif

                {{-- Block --}}
                @if ($group['interactive']['blockSetting'])
                    @component('components.group.mark.block', [
                        'gid' => $group['gid'],
                        'interactive' => $group['interactive'],
                        'count' => $group['blockCount'],
                    ])@endcomponent
                @endif
            </section>
        </header>

        <section class="badge-bg-info">
            <span class="badge rounded-pill">{{ $group['postCount'] }} {{ fs_api_config('post_name') }}</span>
            <span class="badge rounded-pill">{{ $group['postDigestCount'] }} {{ fs_lang('contentDigest') }}</span>
        </section>

        <section class="fs-7 mt-1 text-secondary">{{ $group['description'] }}</section>
    </div>
</article>
