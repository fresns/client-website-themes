<article class="d-flex">
    @if ($group['cover'])
        <section class="flex-shrink-0">
            <img src="{{ $group['cover'] }}" loading="lazy" alt="{{ $group['gname'] }}" class="rounded list-cover">
        </section>
    @endif

    <div class="flex-grow-1 ms-3 position-relative">
        <header class="d-lg-flex">
            <section class="d-flex">
                {{ $group['gname'] }}
                @if ($group['recommend'])
                    <img src="/assets/themes/Moments/images/icon-recommend.png" loading="lazy" class="list-recommend" alt="{{ fs_lang('contentRecommend') }}">
                @endif
            </section>

            <section class="list-btn ms-auto">
                {{-- Like --}}
                @if ($group['interaction']['likeSetting'])
                    @component('components.group.mark.like', [
                        'gid' => $group['gid'],
                        'interaction' => $group['interaction'],
                        'count' => $group['likeCount'],
                    ])@endcomponent
                @endif

                {{-- Dislike --}}
                @if ($group['interaction']['dislikeSetting'])
                    @component('components.group.mark.dislike', [
                        'gid' => $group['gid'],
                        'interaction' => $group['interaction'],
                        'count' => $group['dislikeCount'],
                    ])@endcomponent
                @endif

                {{-- Follow --}}
                @if ($group['interaction']['followSetting'])
                    @component('components.group.mark.follow', [
                        'gid' => $group['gid'],
                        'gname' => $group['gname'],
                        'followType' => $group['followType'],
                        'followUrl' => $group['followUrl'],
                        'interaction' => $group['interaction'],
                        'count' => $group['followCount'],
                    ])@endcomponent
                @endif

                {{-- Block --}}
                @if ($group['interaction']['blockSetting'])
                    @component('components.group.mark.block', [
                        'gid' => $group['gid'],
                        'interaction' => $group['interaction'],
                        'count' => $group['blockCount'],
                    ])@endcomponent
                @endif
            </section>
        </header>

        <section class="badge-bg-info">
            <span class="badge rounded-pill">{{ $group['postCount'] }} {{ fs_db_config('post_name') }}</span>
            <span class="badge rounded-pill">{{ $group['postDigestCount'] }} {{ fs_lang('contentDigest') }}</span>
        </section>

        <section class="fs-7 mt-1 text-secondary">{{ $group['description'] }}</section>

        <div class="position-absolute top-0 end-0 d-lg-none">
            @if (fs_db_config('fs_theme_quick_publish'))
                <button class="btn btn-warning text-white rounded-pill fs-create shadow me-4" type="button" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i></button>
            @else
                <a class="btn btn-warning text-white rounded-pill fs-create shadow me-4" href="{{ fs_route(route('fresns.editor.index', ['type' => 'post'])) }}"><i class="fa-solid fa-plus"></i></a>
            @endif
        </div>
    </div>
</article>
