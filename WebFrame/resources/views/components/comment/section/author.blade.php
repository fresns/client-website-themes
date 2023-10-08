<div class="d-flex">
    <div class="flex-shrink-0">
        @if (! $author['status'])
            {{-- Deactivate --}}
            <img src="{{ fs_api_config('deactivate_avatar') }}" loading="lazy" alt="{{ fs_lang('userDeactivate') }}" class="user-avatar rounded-circle">
        @elseif ($isAnonymous)
            {{-- Anonymous --}}
            <img src="{{ $author['avatar'] }}" loading="lazy" alt="{{ fs_lang('contentAuthorAnonymous') }}" class="user-avatar rounded-circle">
        @else
            {{-- Author --}}
            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $author['fsid']])) }}">
                @if ($author['decorate'])
                    <img src="{{ $author['decorate'] }}" loading="lazy" alt="Avatar Decorate" class="user-decorate">
                @endif
                <img src="{{ $author['avatar'] }}" loading="lazy" alt="{{ $author['username'] }}" class="user-avatar rounded-circle">
            </a>
        @endif
    </div>

    <div class="flex-grow-1">
        <div class="user-primary d-lg-flex">
            @if (! $author['status'])
                {{-- Deactivate --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('userDeactivate') }}</div>
                </div>
            @elseif ($isAnonymous)
                {{-- Anonymous --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('contentAuthorAnonymous') }}</div>
                </div>
            @else
                {{-- Author --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $author['fsid']])) }}" class="user-link d-flex">
                        <div class="user-nickname text-nowrap overflow-hidden" style="color:{{ $author['nicknameColor'] }};">{{ $author['nickname'] }}</div>
                        @if ($author['verifiedStatus'])
                            <div class="user-verified">
                                @if ($author['verifiedIcon'])
                                    <img src="{{ $author['verifiedIcon'] }}" loading="lazy" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $author['verifiedDesc'] }}">
                                @else
                                    <img src="/assets/WebFrame/images/icon-verified.png" loading="lazy" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $author['verifiedDesc'] }}">
                                @endif
                            </div>
                        @endif
                        <div class="user-name text-secondary">{{ '@'.$author['fsid'] }}</div>
                    </a>
                    <div class="user-role d-flex">
                        @if ($author['roleIconDisplay'])
                            <div class="user-role-icon"><img src="{{ $author['roleIcon'] }}" loading="lazy" alt="{{ $author['roleName'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $author['roleName'] }}"></div>
                        @endif
                        @if ($author['roleNameDisplay'])
                            <div class="user-role-name"><span class="badge rounded-pill">{{ $author['roleName'] }}</span></div>
                        @endif
                    </div>
                </div>

                {{-- Post Author --}}
                @if ($author['isPostAuthor'])
                    <div>
                        <span class="author-badge" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ fs_db_config('post_name').': '.fs_lang('contentAuthor') }}">
                            {{ fs_lang('contentAuthor') }}
                        </span>
                    </div>
                @endif

                {{-- User Affiliate Icons --}}
                @if ($author['operations']['diversifyImages'])
                    <div class="user-icon d-flex flex-wrap flex-lg-nowrap overflow-hidden my-2 my-lg-0">
                        @foreach($author['operations']['diversifyImages'] as $icon)
                            <img src="{{ $icon['imageUrl'] }}" loading="lazy" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}">
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
        <div class="user-secondary d-flex flex-wrap mb-3">
            {{-- Create Time --}}
            <time class="text-secondary" datetime="{{ $createdDatetime }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $createdDatetime }}">{{ $createdTimeAgo }}</time>

            {{-- Edit Time --}}
            @if ($editedDatetime)
                <div class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $editedDatetime }}">({{ fs_lang('contentEditedOn') }} {{ $editedTimeAgo }})</div>
            @endif

            {{-- Reply To Comment --}}
            @if ($replyToComment)
                <div class="text-success ms-2">
                    {{ fs_db_config('publish_comment_name') }}

                    @if (! $replyToComment['author']['status'])
                        <span class="text-muted">{{ fs_lang('userDeactivate') }}</span>
                    @elseif (! $replyToComment['author']['fsid'])
                        <span class="text-muted">{{ fs_lang('contentAuthorAnonymous') }}</span>
                    @else
                        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $replyToComment['author']['fsid']])) }}">{{ $replyToComment['author']['nickname'] }}</a>
                    @endif
                </div>
            @endif

            {{-- IP Location --}}
            @if (fs_api_config('account_ip_location_status') && current_lang_tag() == 'zh-Hans')
                <span class="text-secondary ms-3">
                    <i class="bi bi-geo"></i>
                    @if ($moreJson['ipLocation'] ?? null)
                        {{ fs_lang('ipLocation').$moreJson['ipLocation'] }}
                    @else
                        {{ fs_lang('errorIp') }}
                    @endif
                </span>
            @endif

            {{-- Comment Location --}}
            @if ($location['isLbs'])
                <a href="{{ fs_route(route('fresns.post.location', $location['encode'])) }}" class="link-secondary ms-3"><i class="bi bi-geo-alt-fill"></i> {{ $location['poi'] }}</a>
            @endif
        </div>
    </div>
</div>
