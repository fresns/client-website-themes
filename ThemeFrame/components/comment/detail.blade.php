@php
    use \App\Utilities\ArrUtility;

    $iconLike = null;
    $iconDislike = null;
    $iconFollow = null;
    $iconBlock = null;
    $iconComment = null;
    $iconShare = null;
    $iconMore = null;

    $title = null;
    $decorate = null;
@endphp

@if ($comment['operations']['buttonIcons'])
    @php
        $iconLike = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'like');
        $iconDislike = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'dislike');
        $iconFollow = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'follow');
        $iconBlock = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'block');
        $iconComment = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'comment');
        $iconShare = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'share');
        $iconMore = ArrUtility::pull($comment['operations']['buttonIcons'], 'code', 'more');
    @endphp
@endif

@if ($comment['operations']['diversifyImages'])
    @php
        $title = ArrUtility::pull($comment['operations']['diversifyImages'], 'code', 'title');
        $decorate = ArrUtility::pull($comment['operations']['diversifyImages'], 'code', 'decorate');
    @endphp
@endif

<div class="position-relative pb-2" id="{{ $comment['cid'] }}">
    {{-- Main post preview content --}}
    @component('components.comment.section.post', [
        'post' => $comment['post'],
    ])@endcomponent

    {{-- Comment Author Information --}}
    <section class="content-creator order-0">
        @component('components.comment.section.creator', [
            'creator' => $comment['creator'],
            'isAnonymous' => $comment['isAnonymous'],
            'createTime' => $comment['createTime'],
            'createTimeFormat' => $comment['createTimeFormat'],
            'editTime' => $comment['editTime'],
            'editTimeFormat' => $comment['editTimeFormat'],
            'location' => $comment['location'],
            'replyToUser' => $comment['replyToUser'],
        ])@endcomponent
    </section>

    {{-- Comment --}}
    <section class="content-main order-2 mx-3 position-relative">
        {{-- Title --}}
        <div class="content-title d-flex flex-row bd-highlight">
            {{-- Title Icon --}}
            @if ($title)
                <img src="{{ $title['imageUrl'] }}" alt="{{ $title['name'] }}" class="me-2">
            @endif

            {{-- Sticky --}}
            @if ($comment['isSticky'])
                <img src="/assets/themes/ThemeFrame/images/icon-sticky.png" alt="Sticky" class="ms-2">
            @endif

            {{-- Digest --}}
            @if ($comment['digestState'] == 2)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" alt="Digest 1" class="ms-2">
            @elseif ($comment['digestState'] == 3)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" alt="Digest 2" class="ms-2">
            @endif
        </div>

        {{-- Full Text --}}
        <div class="content-article">
            @if ($comment['isMarkdown'])
                {!! Str::markdown($comment['content']) !!}
            @else
                {!! nl2br($comment['content']) !!}
            @endif
        </div>
    </section>

    {{-- Decorate --}}
    @if ($decorate)
        <div class="position-absolute top-0 end-0">
            <img src="{{ $decorate['imageUrl'] }}" alt="{{ $decorate['name'] }}" height="88rem">
        </div>
    @endif

    {{-- Files --}}
    <section class="content-files order-3 mx-3 mt-2 d-flex align-content-start flex-wrap file-image-{{ $comment['fileCount']['images'] }}">
        @component('components.comment.section.files', [
            'cid' => $comment['cid'],
            'createTime' => $comment['createTime'],
            'creator' => $comment['creator'],
            'fileCount' => $comment['fileCount'],
            'files' => $comment['files'],
        ])@endcomponent
    </section>

    {{-- Extends --}}
    @if ($comment['extends'])
        <section class="content-extends order-3 mx-3">
            @component('components.comment.section.extends', [
                'cid' => $comment['cid'],
                'createTime' => $comment['createTime'],
                'creator' => $comment['creator'],
                'extends' => $comment['extends']
            ])@endcomponent
        </section>
    @endif

    {{-- Interaction Function --}}
    <section class="interaction order-5 mt-3 mx-3">
        <div class="d-flex">
            {{-- Like --}}
            @if ($comment['interactive']['likeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.like', [
                        'cid' => $comment['cid'],
                        'interactive' => $comment['interactive'],
                        'count' => $comment['likeCount'],
                        'icon' => $iconLike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Dislike --}}
            @if ($comment['interactive']['dislikeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.dislike', [
                        'cid' => $comment['cid'],
                        'interactive' => $comment['interactive'],
                        'count' => $comment['dislikeCount'],
                        'icon' => $iconDislike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Reply --}}
            <div class="interaction-box fresns-trigger-reply">
                <a class="btn btn-inter" href="javascript:;" role="button">
                    @if ($iconComment)
                        <img src="{{ $iconComment['imageUrl'] }}">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-comment.png">
                    @endif
                    {{ $comment['commentCount'] }}
                </a>
            </div>

            {{-- Share --}}
            <div class="interaction-box dropup">
                <button class="btn btn-inter" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($iconShare)
                        <img src="{{ $iconShare['imageUrl'] }}">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-share.png">
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
                        <img src="{{ $iconMore['imageUrl'] }}">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-more.png">
                    @endif
                </button>
                @component('components.comment.mark.more', [
                    'cid' => $comment['cid'],
                    'uid' => $comment['creator']['uid'],
                    'editStatus' => $comment['editStatus'],
                    'interactive' => $comment['interactive'],
                    'followCount' => $comment['followCount'],
                    'blockCount' => $comment['blockCount'],
                    'manages' => $comment['manages'],
                ])@endcomponent
            </div>
        </div>

        {{-- Reply Box --}}
        @component('components.editor.comment-box', [
            'nickname' => $comment['creator']['nickname'],
            'type' => 'comment',
            'pid' => $comment['post']['pid'],
            'cid' => $comment['cid'],
            'show' => true,
        ])@endcomponent
    </section>

    {{-- Post Author Likes Status --}}
    @if ($comment['interactive']['postCreatorLikeStatus'])
        <div class="post-creator-liked order-5 mt-2 mx-3">
            <span class="author-badge p-1">{{ fs_lang('contentCreatorLiked') }}</span>
        </div>
    @endif
</div>
