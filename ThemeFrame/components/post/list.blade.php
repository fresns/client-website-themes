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

@if ($post['operations']['buttonIcons'])
    @php
        $iconLike = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'like');
        $iconDislike = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'dislike');
        $iconFollow = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'follow');
        $iconBlock = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'block');
        $iconComment = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'comment');
        $iconShare = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'share');
        $iconMore = ArrUtility::pull($post['operations']['buttonIcons'], 'code', 'more');
    @endphp
@endif

@if ($post['operations']['diversifyImages'])
    @php
        $title = ArrUtility::pull($post['operations']['diversifyImages'], 'code', 'title');
        $decorate = ArrUtility::pull($post['operations']['diversifyImages'], 'code', 'decorate');
    @endphp
@endif

<div class="position-relative pb-2" id="{{ $post['pid'] }}">
    {{-- Post Author Information --}}
    <section class="content-creator order-0">
        @component('components.post.section.creator', [
            'pid' => $post['pid'],
            'creator' => $post['creator'],
            'isAnonymous' => $post['isAnonymous'],
            'createTime' => $post['createTime'],
            'createTimeFormat' => $post['createTimeFormat'],
            'editTime' => $post['editTime'],
            'editTimeFormat' => $post['editTimeFormat'],
            'ipLocation' => $post['ipLocation'],
            'location' => $post['location']
        ])@endcomponent
    </section>

    {{-- Post --}}
    <section class="content-main order-2 mx-3 position-relative">
        {{-- Title --}}
        <div class="content-title d-flex flex-row bd-highlight">
            {{-- Title Icon --}}
            @if ($title)
                <img src="{{ $title['imageUrl'] }}" alt="{{ $title['name'] }}" class="me-2">
            @endif

            {{-- Title Text --}}
            @if ($post['title'])
                <h1 class="h5 mb-3">{{ $post['title'] }}</h1>
            @endif

            {{-- Sticky --}}
            @if ($post['stickyState'] == 2)
                <img src="/assets/themes/ThemeFrame/images/icon-sticky.png" alt="Sticky Group" class="ms-2">
            @elseif ($post['stickyState'] == 3)
                <img src="/assets/themes/ThemeFrame/images/icon-sticky.png" alt="Sticky All" class="ms-2">
            @endif

            {{-- Digest --}}
            @if ($post['digestState'] == 2)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" alt="Digest 1" class="ms-2">
            @elseif ($post['digestState'] == 3)
                <img src="/assets/themes/ThemeFrame/images/icon-digest.png" alt="Digest 2" class="ms-2">
            @endif
        </div>

        {{-- Full Text --}}
        <div class="content-article">
            @if ($post['isMarkdown'])
                {!! Str::markdown($post['content']) !!}
            @else
                {!! nl2br(e($post['content'])) !!}
            @endif

            {{-- Detail Page Link --}}
            <p class="mt-2">
                <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $post['pid']])) }}" class="text-decoration-none stretched-link">
                    @if ($post['isBrief'])
                        {{ fs_lang('contentFull') }}
                    @endif
                </a>
            </p>
        </div>
    </section>

    {{-- Post permission information --}}
    @if ($post['isAllow'])
        <section class="post-allow order-2">
            <div class="post-allow-static"></div>
            <div class="text-center">
                <p class="text-secondary mb-2">{{ fs_lang('contentAllowInfo') }} {{ $post['allowProportion'] }}%</p>
                <button type="button" class="btn btn-outline-info btn-lg w-50" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-lang-tag="{{ current_lang_tag() }}"
                    data-type="post"
                    data-scene="postAllowBtn"
                    data-post-message-key="fresnsPostUserList"
                    data-pid="{{ $post['pid'] }}"
                    data-uid="{{ $post['creator']['uid'] }}"
                    data-title="{{ $post['allowBtnName'] }}"
                    data-url="{{ $post['allowBtnUrl'] }}">
                    {{ $post['allowBtnName'] }}
                </button>
            </div>
        </section>
    @endif

    {{-- Decorate --}}
    @if ($decorate)
        <div class="position-absolute top-0 end-0">
            <img src="{{ $decorate['imageUrl'] }}" alt="{{ $decorate['name'] }}" height="88rem">
        </div>
    @endif

    {{-- Files --}}
    <section class="content-files order-3 mx-3 mt-2 d-flex align-content-start flex-wrap file-image-{{ $post['fileCount']['images'] }}">
        @component('components.post.section.files', [
            'pid' => $post['pid'],
            'createTime' => $post['createTime'],
            'creator' => $post['creator'],
            'fileCount' => $post['fileCount'],
            'files' => $post['files'],
        ])@endcomponent
    </section>

    {{-- Extends --}}
    @if ($post['extends'])
        <section class="content-extends order-3 mx-3">
            @component('components.post.section.extends', [
                'pid' => $post['pid'],
                'createTime' => $post['createTime'],
                'creator' => $post['creator'],
                'extends' => $post['extends']
            ])@endcomponent
        </section>
    @endif

    {{-- Post extended information --}}
    @if ($post['group'] || $post['isUserList'] || $post['hashtags'])
        <section class="content-append order-4 mx-3 mt-3 d-flex">
            <div class="me-auto d-flex flex-row">
                {{-- Post Group --}}
                @if ($post['group'])
                    <div class="content-group me-2">
                        <a href="{{ fs_route(route('fresns.group.detail', ['gid' => $post['group']['gid']])) }}" class="badge rounded-pill text-decoration-none">
                            @if (!empty($post['group']['cover']))
                                <img src="{{ $post['group']['cover'] }}" alt="$post['group']['gname']" class="rounded">
                            @endif
                            {{ $post['group']['gname'] }}
                        </a>
                    </div>
                @endif

                {{-- Post Hashtags --}}
                @if ($post['hashtags'])
                    @foreach($post['hashtags'] as $hashtag)
                        <div class="content-group me-2 mt-1">
                            <a href="{{ fs_route(route('fresns.hashtag.detail', ['hid' => $hashtag['hid']])) }}" class="badge rounded-pill text-decoration-none">
                                {{ '# '.$hashtag['hname'] }}
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Post Users --}}
            @if ($post['isUserList'])
                <div class="content-user-list">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                        data-lang-tag="{{ current_lang_tag() }}"
                        data-type="post"
                        data-scene="postUserList"
                        data-post-message-key="fresnsPostUserList"
                        data-pid="{{ $post['pid'] }}"
                        data-uid="{{ $post['creator']['uid'] }}"
                        data-title="{{ $post['userListName'] }}"
                        data-url="{{ $post['userListUrl'] }}">
                        {{ $post['userListName'] }}
                        <span class="badge bg-light text-dark">{{ $post['userListCount'] }}</span>
                    </button>
                </div>
            @endif
        </section>
    @endif

    {{-- Post Top Comment --}}
    @if ($post['topComment'])
        @component('components.post.section.top-comment', [
            'pid' => $post['pid'],
            'topComment' => $post['topComment'],
        ])@endcomponent
    @endif

    {{-- Interaction Function --}}
    <section class="interaction order-5 mt-3 px-3">
        <div class="d-flex">
            {{-- Like --}}
            @if ($post['interactive']['likeSetting'])
                <div class="interaction-box">
                    @component('components.post.mark.like', [
                        'pid' => $post['pid'],
                        'interactive' => $post['interactive'],
                        'count' => $post['likeCount'],
                        'icon' => $iconLike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Dislike --}}
            @if ($post['interactive']['dislikeSetting'])
                <div class="interaction-box">
                    @component('components.post.mark.dislike', [
                        'pid' => $post['pid'],
                        'interactive' => $post['interactive'],
                        'count' => $post['dislikeCount'],
                        'icon' => $iconDislike,
                    ])@endcomponent
                </div>
            @endif

            {{-- Comment --}}
            <div class="interaction-box fresns-trigger-reply">
                <a class="btn btn-inter" href="javascript:;" role="button">
                    @if ($iconComment)
                        <img src="{{ $iconComment['imageUrl'] }}">
                    @else
                        <img src="/assets/themes/ThemeFrame/images/icon-comment.png">
                    @endif
                    <span class="cm-count">
                        {{ $post['commentCount'] }}
                    </span>
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
                @component('components.post.mark.share', [
                    'pid' => $post['pid'],
                    'url' => $post['url'],
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
                @component('components.post.mark.more', [
                    'pid' => $post['pid'],
                    'uid' => $post['creator']['uid'],
                    'editStatus' => $post['editStatus'],
                    'interactive' => $post['interactive'],
                    'followCount' => $post['followCount'],
                    'blockCount' => $post['blockCount'],
                    'manages' => $post['manages'],
                ])@endcomponent
            </div>
        </div>

        {{-- Comment reply box --}}
        @component('components.editor.comment-box', [
            'nickname' => $post['creator']['nickname'],
            'pid' => $post['pid'],
        ])@endcomponent
    </section>
</div>
