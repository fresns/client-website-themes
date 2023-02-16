@if ($post)
    <section class="comment-post mt-3 mx-3 position-relative">
        <div class="d-flex">
            <div class="flex-shrink-0"><img src="{{ $post['creator']['avatar'] }}" loading="lazy" alt="{{ $post['creator']['nickname'] }}" class="rounded"></div>
            <div class="flex-grow-1">
                @if ($post['creator']['deactivate'])
                    {{ fs_lang('contentCreatorDeactivate') }}:
                @elseif (empty($post['creator']['fsid']))
                    {{ fs_lang('contentCreatorAnonymous') }}:
                @else
                    {{ $post['creator']['nickname'] }}:
                @endif

                {!! Str::limit(strip_tags($post['content']), 140) !!}
            </div>
        </div>

        @if ($post['group'])
            <div class="comment-post-group border-top text-secondary">{{ $post['group']['gname'] }}</div>
        @endif

        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $post['pid']])) }}" class="text-decoration-none stretched-link"></a>
    </section>
@endif
