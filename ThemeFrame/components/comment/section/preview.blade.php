<section class="comment-preview mt-2 mx-3 position-relative d-flex flex-column">
    @foreach($subComments as $comment)
        <div class="text-break mb-2">
            @if ($comment['isAnonymous'])
                <span class="text-info">{{ fs_lang('contentCreatorAnonymous') }}</span>
            @else
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $comment['creator']['fsid']])) }}" class="content-link text-decoration-none">{{ $comment['creator']['nickname'] }}</a>
            @endif

            @if ($comment['creator']['isPostCreator'])
                <span class="author-badge">{{ fs_lang('contentCreator') }}</span>
            @endif

            @if ($comment['replyToUser'])
                @if ($comment['replyToUser']['nickname'])
                    {{ fs_db_config('publish_comment_name') }} <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $comment['replyToUser']['fsid']])) }}" class="content-link text-decoration-none">{{ $comment['replyToUser']['nickname'] }}</a>
                @else
                    {{ fs_db_config('publish_comment_name') }} <span class="text-info">{{ fs_lang('contentCreatorAnonymous') }}</span>
                @endif
            @endif

            : {!! $comment['content'] !!}

            @if ($comment['fileCount']['images'] > 0)
                <span class="text-primary">[{{ fs_lang('image') }}]</span>
            @endif

            @if ($comment['fileCount']['videos'] > 0)
                <span class="text-primary">[{{ fs_lang('video') }}]</span>
            @endif

            @if ($comment['fileCount']['audios'] > 0)
                <span class="text-primary">[{{ fs_lang('audio') }}]</span>
            @endif

            @if ($comment['fileCount']['documents'] > 0)
                <span class="text-primary">[{{ fs_lang('document') }}]</span>
            @endif
        </div>
    @endforeach

    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $cid])) }}" class="text-decoration-none stretched-link mb-2">
        {{ fs_lang('modifierCount') }}
        {{ $commentCount }}
        {{ fs_lang('contentCommentCountDesc') }}
        <i class="bi bi-chevron-right"></i>
    </a>
</section>
