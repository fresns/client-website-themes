@if ($quotedPost['creator'] ?? null)
    <section class="comment-post my-2 mx-3 position-relative">
        <div class="d-flex">
            <div class="flex-shrink-0"><img src="{{ $quotedPost['creator']['avatar'] }}" loading="lazy" alt="{{ $quotedPost['creator']['nickname'] }}" class="rounded"></div>
            <div class="flex-grow-1">
                @if (isset($quotedPost['creator']['status']) && ! $quotedPost['creator']['status'])
                    {{ fs_lang('contentCreatorDeactivate') }}:
                @elseif (! $quotedPost['creator']['fsid'])
                    {{ fs_lang('contentCreatorAnonymous') }}:
                @else
                    {{ $quotedPost['creator']['nickname'] }}:
                @endif

                {!! Str::limit(strip_tags($quotedPost['content']), 140) !!}
            </div>
        </div>

        @if ($quotedPost['group'])
            <div class="comment-post-group border-top text-secondary">{{ $quotedPost['group']['gname'] }}</div>
        @endif

        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $quotedPost['pid']])) }}" class="text-decoration-none stretched-link"></a>
    </section>
@endif
