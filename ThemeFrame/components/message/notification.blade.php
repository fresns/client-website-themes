<li class="list-group-item d-flex justify-content-start align-items-center">
    {{-- Read Status --}}
    @if(! $notification['readStatus'])
        <span class="p-1 bg-danger border border-light rounded-circle"></span>
    @endif

    {{-- User Avatar --}}
    @if ($notification['actionUser'])
        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $notification['actionUser']['fsid']])) }}">
            <img src="{{ $notification['actionUser']['avatar'] }}" class="rounded-circle mx-3" style="width:3.2rem;height:3.2rem;">
        </a>
    @endif

    <div class="my-2 w-100">
        {{-- User Profile --}}
        @if ($notification['actionUser'])
            <div class="user-info text-nowrap overflow-hidden">
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $notification['actionUser']['fsid']])) }}" class="user-link d-flex">
                    <div class="user-nickname text-nowrap overflow-hidden">{{ $notification['actionUser']['nickname'] }}</div>

                    @if ($notification['actionUser']['verifiedStatus'])
                        <div class="user-verified">
                            @if ($notification['actionUser']['verifiedIcon'])
                                <img src="{{ $notification['actionUser']['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notification['actionUser']['verifiedDesc'] ?? '' }}">
                            @else
                                <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notification['actionUser']['verifiedDesc'] ?? '' }}">
                            @endif
                        </div>
                    @endif

                    <div class="user-name text-secondary">{{ '@' . $notification['actionUser']['username'] }}</div>
                </a>
            </div>
        @endif

        {{-- Notification Content --}}
        <section class="user-secondary d-flex flex-wrap">
            <p class="mb-0 w-100">
                <span class="badge bg-primary">
                    @switch($notification['type'])
                        @case(3)
                            {{ fs_lang('notificationLike') }}
                        @break

                        @case(4)
                            {{ fs_lang('notificationDislike') }}
                        @break

                        @case(5)
                            {{ fs_lang('notificationFollow') }}
                        @break

                        @case(6)
                            {{ fs_lang('notificationBlock') }}
                        @break

                        @case(7)
                            {{ fs_lang('notificationMention') }}
                        @break

                        @case(8)
                            {{ fs_lang('notificationComment') }}
                        @break

                        @default

                        @break
                    @endswitch

                    @switch($notification['actionObject'])
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
                <span class="badge bg-light text-dark fw-normal ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notification['datetime'] }}">{{ $notification['datetimeFormat'] }}</span>
            </p>

            @if ($notification['content'])
                @if ($notification['actionCid'])
                    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $notification['actionCid']])) }}" class="text-decoration-none text-secondary fs-6 mt-2">{{ $notification['content'] }}</a>
                @else
                    <span class="text-secondary fs-6 mt-2">{{ $notification['content'] }}</span>
                @endif
            @endif
        </section>

        {{-- Content of the trigger notification --}}
        @switch($notification['actionObject'])
            @case(2)
                <div class="content-group mt-2">
                    <a href="{{ fs_route(route('fresns.group.detail', ['gid' => $notification['actionInfo']['gid']])) }}" class="badge rounded-pill text-decoration-none">
                        @if ($notification['actionInfo']['cover'])
                            <img src="{{ $notification['actionInfo']['cover'] }}" alt="$notification['actionInfo']['gname']" class="rounded">
                        @endif
                        {{ $notification['actionInfo']['gname'] }}
                    </a>
                </div>
            @break

            @case(3)
                <a href="{{ fs_route(route('fresns.hashtag.detail', ['hid' => $notification['actionInfo']['hid']])) }}" class="text-decoration-none text-secondary mt-2"><span class="badge text-bg-primary">{{ $notification['actionInfo']['hname'] }}</span></a>
            @break

            @case(4)
                <section class="comment-post mt-2 position-relative">
                    <div class="d-flex">
                        <div class="flex-shrink-0"><img src="{{ $notification['actionInfo']['creator']['avatar'] }}" class="rounded"></div>
                        <div class="flex-grow-1">{{ $notification['actionInfo']['title'] ?? Str::limit($notification['actionInfo']['content'], 80) }}</div>
                    </div>
                    @if ($notification['actionInfo']['group'])
                        <div class="comment-post-group border-top text-secondary">{{ $notification['actionInfo']['group']['gname'] }}</div>
                    @endif
                    <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $notification['actionInfo']['pid']])) }}" class="text-decoration-none stretched-link"></a>
                </section>
            @break

            @case(5)
                <section class="comment-post mt-2 position-relative">
                    <div class="d-flex">
                        <div class="flex-shrink-0"><img src="{{ $notification['actionInfo']['creator']['avatar'] }}" class="rounded"></div>
                        <div class="flex-grow-1">{{ $notification['actionInfo']['title'] ?? Str::limit($notification['actionInfo']['content'], 80) }}</div>
                    </div>
                    <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $notification['actionInfo']['cid']])) }}" class="text-decoration-none stretched-link"></a>
                </section>
            @break

            @default

            @break
        @endswitch
    </div>
</li>
