@php
    $iconLike = null;
    $iconDislike = null;
    $iconFollow = null;
    $iconBlock = null;
    $iconComment = null;
    $iconShare = null;
    $iconMore = null;

    $title = null;
    $decorate = null;

    $totalFiles = 0;
    foreach($comment['files'] as $fileType => $files) {
        $totalFiles += count($files);
    }
@endphp

@if ($comment['operations']['buttonIcons'])
    @php
        $iconLike = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'like',
        ]);
        $iconDislike = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'dislike',
        ]);
        $iconFollow = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'follow',
        ]);
        $iconBlock = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'block',
        ]);
        $iconComment = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'comment',
        ]);
        $iconShare = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'share',
        ]);
        $iconMore = fs_helpers('Arr', 'pull', $comment['operations']['buttonIcons'], [
            'key' => 'code',
            'values' => 'more',
        ]);
    @endphp
@endif

@if ($comment['operations']['diversifyImages'])
    @php
        $title = fs_helpers('Arr', 'pull', $comment['operations']['diversifyImages'], [
            'key' => 'code',
            'values' => 'title',
        ]);
        $decorate = fs_helpers('Arr', 'pull', $comment['operations']['diversifyImages'], [
            'key' => 'code',
            'values' => 'decorate',
        ]);
    @endphp
@endif

<article class="position-relative border-bottom pb-3 pt-1" id="{{ $comment['cid'] }}">
    {{-- Post Preview --}}
    @component('components.comment.section.post', [
        'post' => $comment['replyToPost'],
    ])@endcomponent

    {{-- Comment Author --}}
    <section class="content-author order-0">
        @component('components.comment.section.author', [
            'cid' => $comment['cid'],
            'author' => $comment['author'],
            'isAnonymous' => $comment['isAnonymous'],
            'createdDatetime' => $comment['createdDatetime'],
            'createdTimeAgo' => $comment['createdTimeAgo'],
            'editedDatetime' => $comment['editedDatetime'],
            'editedTimeAgo' => $comment['editedTimeAgo'],
            'geotag' => $comment['geotag'],
            'moreInfo' => $comment['moreInfo'],
            'replyToComment' => $comment['replyToComment'],
        ])@endcomponent
    </section>

    {{-- Comment Main --}}
    <section class="content-main order-2 mx-3 position-relative">
        {{-- Title --}}
        <div class="content-title d-flex flex-row bd-highlight">
            {{-- Title Icon --}}
            @if ($title)
                <img src="{{ $title['imageUrl'] }}" loading="lazy" alt="{{ $title['name'] }}" class="me-2">
            @endif

            {{-- Sticky --}}
            @if ($comment['isSticky'])
                <img src="/assets/Moments/images/icon-sticky.png" loading="lazy" alt="Sticky" class="ms-2">
            @endif

            {{-- Digest --}}
            @if ($comment['digestState'] == 2)
                <img src="/assets/Moments/images/icon-digest.png" loading="lazy" alt="General Digest" class="ms-2">
            @elseif ($comment['digestState'] == 3)
                <img src="/assets/Moments/images/icon-digest.png" loading="lazy" alt="Senior Digest" class="ms-2">
            @endif
        </div>

        {{-- Content --}}
        <div class="content-article text-break">
            @if ($comment['isCommentPrivate'])
                <div class="alert alert-warning" role="alert">
                    <i class="fa-solid fa-circle-info"></i> {{ fs_lang('editorCommentPrivate') }}
                </div>
            @else
                @if ($comment['isMarkdown'])
                    {!! Str::markdown($comment['content']) !!}
                @else
                    {!! nl2br($comment['content']) !!}
                @endif
            @endif
        </div>
    </section>

    {{-- Comment Decorate --}}
    @if ($decorate)
        <div class="position-absolute top-0 end-0">
            <img src="{{ $decorate['imageUrl'] }}" loading="lazy" alt="{{ $decorate['name'] }}" height="88rem">
        </div>
    @endif

    {{-- Files --}}
    @if ($totalFiles > 0)
        <section class="content-files order-3 mx-3 mt-2 d-flex align-content-start flex-wrap file-image-{{ count($comment['files']['images']) }}">
            @component('components.comment.section.files', [
                'cid' => $comment['cid'],
                'createdDatetime' => $comment['createdDatetime'],
                'author' => $comment['author'],
                'files' => $comment['files'],
            ])@endcomponent
        </section>
    @endif

    {{-- Content Extends --}}
    @if ($comment['extends'])
        <section class="content-extends order-3 mx-3">
            @component('components.comment.section.extends', [
                'cid' => $comment['cid'],
                'createdDatetime' => $comment['createdDatetime'],
                'author' => $comment['author'],
                'extends' => $comment['extends']
            ])@endcomponent
        </section>
    @endif

    {{-- Comment Interaction --}}
    <section class="interaction order-5 mt-3 mx-3">
        <div class="d-flex">
            {{-- Like --}}
            @if ($comment['interaction']['likeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.like', [
                        'cid' => $comment['cid'],
                        'interaction' => $comment['interaction'],
                        'count' => $comment['likeCount'],
                        'icon' => $iconLike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Dislike --}}
            @if ($comment['interaction']['dislikeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.dislike', [
                        'cid' => $comment['cid'],
                        'interaction' => $comment['interaction'],
                        'count' => $comment['dislikeCount'],
                        'icon' => $iconDislike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Comment --}}
            <div class="interaction-box">
                <button class="btn btn-inter" type="button" data-bs-toggle="modal" @if (fs_user()->check()) data-bs-target="#commentModal-{{ $comment['cid'] }}" @else data-bs-target="#commentTipModal" @endif>
                    @if ($iconComment)
                        <img src="{{ $iconComment['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/Moments/images/icon-comment.png" loading="lazy">
                    @endif
                    <span class="cm-count">{{ $comment['commentCount'] }}</span>
                </button>
            </div>

            {{-- Share --}}
            <div class="interaction-box dropup">
                <button class="btn btn-inter" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($iconShare)
                        <img src="{{ $iconShare['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/Moments/images/icon-share.png" loading="lazy">
                    @endif
                </button>
                @component('components.comment.mark.share', [
                    'cid' => $comment['cid'],
                    'url' => $comment['url'],
                ])@endcomponent
            </div>

            {{-- More --}}
            <div class="ms-auto dropup text-end">
                <button class="btn btn-inter" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    @if ($iconMore)
                        <img src="{{ $iconMore['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/Moments/images/icon-more.png" loading="lazy">
                    @endif
                </button>
                @component('components.comment.mark.more', [
                    'cid' => $comment['cid'],
                    'uid' => $comment['author']['uid'],
                    'editControls' => $comment['editControls'],
                    'interaction' => $comment['interaction'],
                    'followCount' => $comment['followCount'],
                    'blockCount' => $comment['blockCount'],
                    'manages' => $comment['manages'],
                ])@endcomponent
            </div>
        </div>
    </section>

    {{-- Post Author Like Status --}}
    @if ($comment['interaction']['postAuthorLikeStatus'])
        <div class="post-author-liked order-5 mt-2 mx-3">
            <span class="author-badge p-1">{{ fs_lang('contentAuthorLiked') }}</span>
        </div>
    @endif
</article>

{{-- Comment Box --}}
@if (fs_user()->check())
    @component('components.editor.comment-box', [
        'nickname' => $comment['author']['nickname'],
        'pid' => $comment['replyToPost']['pid'],
        'cid' => $comment['cid'],
    ])@endcomponent
@endif

{{-- Comment Bar --}}
<div class="fs-tabbar fixed-bottom bg-light border-top d-sm-none">
    <div class="d-grid gap-2 mx-4 py-2">
        <button class="btn btn-outline-secondary rounded-pill text-start ps-3" type="button" data-bs-toggle="modal" @if (fs_user()->check()) data-bs-target="#commentModal-{{ $comment['cid'] }}" @else data-bs-target="#commentTipModal" @endif>
            {{ fs_config('publish_comment_name') }}
        </button>
    </div>
</div>
