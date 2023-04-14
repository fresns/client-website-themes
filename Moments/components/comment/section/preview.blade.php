<section class="comment-preview my-2 mx-3 position-relative d-flex flex-column">
    @foreach($subComments as $comment)
        <div class="text-break mb-2">
            @if (! $comment['creator']['status'])
                <span class="text-info">{{ fs_lang('contentCreatorDeactivate') }}</span>
            @elseif ($comment['isAnonymous'])
                <span class="text-info">{{ fs_lang('contentCreatorAnonymous') }}</span>
            @else
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $comment['creator']['fsid']])) }}" class="content-link text-decoration-none">{{ $comment['creator']['nickname'] }}</a>
            @endif

            @if ($comment['creator']['isPostCreator'])
                <span class="author-badge">{{ fs_lang('contentCreator') }}</span>
            @endif

            @if ($comment['replyToComment'])
                @if (! $comment['replyToComment']['creator']['status'])
                    {{ fs_db_config('publish_comment_name') }} <span class="text-info">{{ fs_lang('contentCreatorDeactivate') }}</span>
                @elseif ($comment['replyToComment']['isAnonymous'])
                    {{ fs_db_config('publish_comment_name') }} <span class="text-info">{{ fs_lang('contentCreatorAnonymous') }}</span>
                @else
                    {{ fs_db_config('publish_comment_name') }} <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $comment['replyToComment']['creator']['fsid']])) }}" class="content-link text-decoration-none">{{ $comment['replyToComment']['creator']['nickname'] }}</a>
                @endif
            @endif

            : {!! $comment['content'] !!}

            @if (count($comment['files']['images']) > 0)
                <span class="text-primary">[{{ fs_lang('image') }}]</span>
            @endif

            @if (count($comment['files']['videos']) > 0)
                <span class="text-primary">[{{ fs_lang('video') }}]</span>
            @endif

            @if (count($comment['files']['audios']) > 0)
                <span class="text-primary">[{{ fs_lang('audio') }}]</span>
            @endif

            @if (count($comment['files']['documents']) > 0)
                <span class="text-primary">[{{ fs_lang('document') }}]</span>
            @endif
        </div>
    @endforeach

    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $cid])) }}" class="text-decoration-none stretched-link mb-2">
        {{ fs_lang('modifierCount') }}
        {{ $commentCount }}
        {{ fs_lang('contentCommentCountDesc') }}
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</section>
