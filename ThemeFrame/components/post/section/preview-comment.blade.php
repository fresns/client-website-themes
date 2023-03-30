@if (count($previewComments) == 1)
    @php
        $topComment = $previewComments[0];
    @endphp

    <section class="post-top-comment order-5 mx-3 mt-3 position-relative">
        {{-- Title --}}
        <div class="clearfix">
            <span class="badge bg-warning text-dark fs-7">{{ fs_lang('contentTopComment') }}</span>
            <span class="float-end text-secondary">{{ $topComment['likeCount'] }} {{ fs_db_config('like_post_name') }}</span>
        </div>

        {{-- Content --}}
        <div class="text-break mt-2">
            @if (! $topComment['creator']['status'])
                <span class="text-info">{{ fs_lang('contentCreatorDeactivate') }}</span>:
            @elseif ($topComment['isAnonymous'])
                <span class="text-info">{{ fs_lang('contentCreatorAnonymous') }}</span>:
            @else
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $topComment['creator']['fsid']])) }}" class="fresns_link">{{ $topComment['creator']['nickname'] }}</a>:
            @endif
            <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $pid])).'#commentList' }}" class="text-decoration-none link-dark stretched-link">{!! $topComment['content'] !!}</a>
        </div>

        {{-- Files Images --}}
        @if ($topComment['files']['images'])
            <div class="d-flex align-content-start flex-wrap comment-image-{{ count($topComment['files']['images']) }}">
                @foreach($topComment['files']['images'] as $image)
                    <img src="{{ $image['imageSquareUrl'] }}" loading="lazy" class="img-fluid">
                @endforeach
            </div>
        @endif
    </section>
@else
    <section class="comment-preview mt-3 mx-3 position-relative d-flex flex-column">
        @foreach($previewComments as $comment)
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

        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $pid])).'#commentList' }}" class="text-decoration-none stretched-link mb-2">
            {{ fs_lang('modifierCount') }}
            {{ $commentCount }}
            {{ fs_lang('contentCommentCountDesc') }}
            <i class="bi bi-chevron-right"></i>
        </a>
    </section>
@endif
