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

@if ($sticky['operations']['buttonIcons'])
    @php
        $iconLike = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'like');
        $iconDislike = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'dislike');
        $iconFollow = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'follow');
        $iconBlock = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'block');
        $iconComment = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'comment');
        $iconShare = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'share');
        $iconMore = ArrUtility::pull($sticky['operations']['buttonIcons'], 'code', 'more');
    @endphp
@endif

@if ($sticky['operations']['diversifyImages'])
    @php
        $title = ArrUtility::pull($sticky['operations']['diversifyImages'], 'code', 'title');
        $decorate = ArrUtility::pull($sticky['operations']['diversifyImages'], 'code', 'decorate');
    @endphp
@endif

<div class="position-relative pb-2" id="{{ $sticky['cid'] }}">
    {{-- Comment Author Information --}}
    <section class="content-creator order-0">
        @component('components.comment.section.creator', [
            'cid' => $sticky['cid'],
            'creator' => $sticky['creator'],
            'isAnonymous' => $sticky['isAnonymous'],
            'createTime' => $sticky['createTime'],
            'createTimeFormat' => $sticky['createTimeFormat'],
            'editTime' => $sticky['editTime'],
            'editTimeFormat' => $sticky['editTimeFormat'],
            'ipLocation' => $sticky['ipLocation'],
            'location' => $sticky['location'],
            'replyToUser' => $sticky['replyToUser'],
        ])@endcomponent
    </section>

    {{-- Comment --}}
    <section class="content-main order-2 mx-3 position-relative">
        {{--  Title --}}
        <div class="content-title d-flex flex-row bd-highlight">
            {{--  Title Icon --}}
            @if ($title)
                <img src="{{ $title['imageUrl'] }}" loading="lazy" alt="{{ $title['name'] }}" class="me-2">
            @endif

            {{-- Sticky --}}
            @if ($sticky['isSticky'])
                <img src="/assets/themes/ThemeFrame/images/icon-sticky.png" loading="lazy" alt="Sticky" class="ms-2">
            @endif

            {{-- Digest --}}
            @if ($sticky['digestState'] == 2)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" loading="lazy" alt="Digest 1" class="ms-2">
            @elseif ($sticky['digestState'] == 3)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" loading="lazy" alt="Digest 2" class="ms-2">
            @endif
        </div>

        {{-- Full Text --}}
        <div class="content-article">
            @if ($sticky['isMarkdown'])
                {!! Str::markdown($sticky['content']) !!}
            @else
                {!! nl2br($sticky['content']) !!}
            @endif

            {{-- Detail Page Link --}}
            @if ($detailLink)
                <p class="mt-2">
                    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $sticky['cid']])) }}" class="text-decoration-none stretched-link">
                        @if ($sticky['isBrief'])
                            {{ fs_lang('contentFull') }}
                        @endif
                    </a>
                </p>
            @endif
        </div>
    </section>

    {{-- Decorate --}}
    @if ($decorate)
        <div class="position-absolute top-0 end-0">
            <img src="{{ $decorate['imageUrl'] }}" loading="lazy" alt="{{ $decorate['name'] }}" height="88rem">
        </div>
    @endif

    {{-- Files --}}
    <section class="content-files order-3 mx-3 mt-2 d-flex align-content-start flex-wrap file-image-{{ $sticky['fileCount']['images'] }}">
        @component('components.comment.section.files', [
            'cid' => $sticky['cid'],
            'createTime' => $sticky['createTime'],
            'creator' => $sticky['creator'],
            'fileCount' => $sticky['fileCount'],
            'files' => $sticky['files'],
        ])@endcomponent
    </section>

    {{-- Extends --}}
    @if ($sticky['extends'])
        <section class="content-extends order-3 mx-3">
            @component('components.comment.section.extends', [
                'cid' => $sticky['cid'],
                'createTime' => $sticky['createTime'],
                'creator' => $sticky['creator'],
                'extends' => $sticky['extends']
            ])@endcomponent
        </section>
    @endif

    {{-- Interaction Function --}}
    <section class="interaction order-5 mt-3 mx-3">
        <div class="d-flex">
            {{-- Like --}}
            @if ($sticky['interaction']['likeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.like', [
                        'cid' => $sticky['cid'],
                        'interaction' => $sticky['interaction'],
                        'count' => $sticky['likeCount'],
                        'icon' => $iconLike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Dislike --}}
            @if ($sticky['interaction']['dislikeSetting'])
                <div class="interaction-box">
                    @component('components.comment.mark.dislike', [
                        'cid' => $sticky['cid'],
                        'interaction' => $sticky['interaction'],
                        'count' => $sticky['dislikeCount'],
                        'icon' => $iconDislike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Reply --}}
            <div class="interaction-box fresns-trigger-reply">
                <a class="btn btn-inter" href="javascript:;" role="button">
                    @if ($iconComment)
                        <img src="{{ $iconComment['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-comment.png" loading="lazy">
                    @endif
                    <span class="cm-count">
                    {{ $sticky['commentCount'] }}
                    </span>
                </a>
            </div>

            {{-- Share --}}
            <div class="interaction-box dropup">
                <button class="btn btn-inter" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($iconShare)
                        <img src="{{ $iconShare['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-share.png" loading="lazy">
                    @endif
                </button>
                @component('components.comment.mark.share', [
                    'cid' => $sticky['cid'],
                    'url' => $sticky['url'],
                ])@endcomponent
            </div>

            {{-- More --}}
            <div class="ms-auto dropup text-end">
                <button class="btn btn-inter" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    @if ($iconMore)
                        <img src="{{ $iconMore['imageUrl'] }}" loading="lazy">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-more.png" loading="lazy">
                    @endif
                </button>
                @component('components.comment.mark.more', [
                    'cid' => $sticky['cid'],
                    'uid' => $sticky['creator']['uid'],
                    'editStatus' => $sticky['editStatus'],
                    'interaction' => $sticky['interaction'],
                    'followCount' => $sticky['followCount'],
                    'blockCount' => $sticky['blockCount'],
                    'manages' => $sticky['manages'],
                ])@endcomponent
            </div>
        </div>

        {{-- Reply Box --}}
        @component('components.editor.comment-box', [
            'nickname' => $sticky['creator']['nickname'],
            'pid' => $sticky['post']['pid'],
            'cid' => $sticky['cid'],
        ])@endcomponent
    </section>

    {{-- Post Author Likes Status --}}
    @if ($sectionCreatorLiked && $sticky['interaction']['postCreatorLikeStatus'])
        <div class="post-creator-liked order-5 mt-2 mx-3">
            <span class="author-badge p-1">{{ fs_lang('contentCreatorLiked') }}</span>
        </div>
    @endif
</div>
