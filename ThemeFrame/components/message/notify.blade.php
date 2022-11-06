<li class="list-group-item d-flex justify-content-start align-items-center">
    {{-- Read Status --}}
    @if(! $notify['readStatus'])
        <span class="p-1 bg-danger border border-light rounded-circle"></span>
    @endif

    {{-- User Avatar --}}
    @if ($notify['actionUser'])
        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $notify['actionUser']['fsid']])) }}">
            <img src="{{ $notify['actionUser']['avatar'] }}" alt="Avatar" class="rounded-circle mx-3" style="width:3.2rem;height:3.2rem;">
        </a>
    @endif

    <div class="my-2 w-100">
        {{-- User Profile --}}
        @if ($notify['actionUser'])
            <div class="user-info text-nowrap overflow-hidden">
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $notify['actionUser']['fsid']])) }}" class="user-link d-flex">
                    <div class="user-nickname text-nowrap overflow-hidden">{{ $notify['actionUser']['nickname'] }}</div>

                    @if ($notify['actionUser']['verifiedStatus'])
                        <div class="user-verified">
                            @if ($notify['actionUser']['verifiedIcon'])
                                <img src="{{ $notify['actionUser']['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notify['actionUser']['verifiedDesc'] ?? '' }}">
                            @else
                                <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notify['actionUser']['verifiedDesc'] ?? '' }}">
                            @endif
                        </div>
                    @endif

                    <div class="user-name text-secondary">{{ '@' . $notify['actionUser']['username'] }}</div>
                </a>
            </div>
        @endif

        {{-- Notify Content --}}
        <section class="user-secondary d-flex flex-wrap">
            <p class="mb-0 w-100">
                <span class="badge bg-primary">
                    @switch($notify['type'])
                        @case(3)
                            {{ fs_lang('notifyLike') }}
                        @break

                        @case(4)
                            {{ fs_lang('notifyDislike') }}
                        @break

                        @case(5)
                            {{ fs_lang('notifyFollow') }}
                        @break

                        @case(6)
                            {{ fs_lang('notifyBlock') }}
                        @break

                        @case(7)
                            {{ fs_lang('notifyMention') }}
                        @break

                        @case(8)
                            {{ fs_lang('notifyComment') }}
                        @break

                        @default

                        @break
                    @endswitch

                    @switch($notify['actionObject'])
                        @case(2)
                            : {{ fs_api_config('group_name') }}
                        @break

                        @case(3)
                            : {{ fs_api_config('hashtag_name') }}
                        @break

                        @case(4)
                            : {{ fs_api_config('post_name') }}
                        @break

                        @case(5)
                            : {{ fs_api_config('comment_name') }}
                        @break

                        @default

                        @break
                    @endswitch
                </span>
                <span class="badge bg-light text-dark fw-normal ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notify['notifyTime'] }}">{{ $notify['notifyTimeFormat'] }}</span>
            </p>

            @if ($notify['content'])
                <a href="#" class="text-decoration-none text-secondary fs-6 mt-2">{{ $notify['content'] }}</a>
            @endif
        </section>

        {{-- Content of the trigger notification --}}
        @switch($notify['actionObject'])
            @case(2)
                <div class="content-group mt-2">
                    <a href="{{ fs_route(route('fresns.group.detail', ['gid' => $notify['actionInfo']['gid']])) }}" class="badge rounded-pill text-decoration-none">
                        @if ($notify['actionInfo']['cover'])
                            <img src="{{ $notify['actionInfo']['cover'] }}" alt="Cover Image" class="rounded">
                        @endif
                        {{ $notify['actionInfo']['gname'] }}
                    </a>
                </div>
            @break

            @case(3)
                <a href="{{ fs_route(route('fresns.hashtag.detail', ['hid' => $notify['actionInfo']['hid']])) }}" class="text-decoration-none text-secondary mt-2"><span class="badge text-bg-primary">{{ $notify['actionInfo']['hname'] }}</span></a>
            @break

            @case(4)
                <section class="comment-post mt-2 position-relative">
                    <div class="d-flex">
                        <div class="flex-shrink-0"><img src="{{ $notify['actionInfo']['creator']['avatar'] }}" alt="User Avatar" class="rounded"></div>
                        <div class="flex-grow-1">{{ $notify['actionInfo']['title'] ?? Str::limit($notify['actionInfo']['content'], 80) }}</div>
                    </div>
                    @if ($notify['actionInfo']['group'])
                        <div class="comment-post-group border-top text-secondary">{{ $notify['actionInfo']['group']['gname'] }}</div>
                    @endif
                    <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $notify['actionInfo']['pid']])) }}" class="text-decoration-none stretched-link"></a>
                </section>
            @break

            @case(5)
                <section class="comment-post mt-2 position-relative">
                    <div class="d-flex">
                        <div class="flex-shrink-0"><img src="{{ $notify['actionInfo']['creator']['avatar'] }}" alt="User Avatar" class="rounded"></div>
                        <div class="flex-grow-1">{{ $notify['actionInfo']['title'] ?? Str::limit($notify['actionInfo']['content'], 80) }}</div>
                    </div>
                    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $notify['actionInfo']['cid']])) }}" class="text-decoration-none stretched-link"></a>
                </section>
            @break

            @default

            @break
        @endswitch
    </div>
</li>
