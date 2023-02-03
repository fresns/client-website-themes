<div class="d-flex">
    <div class="flex-shrink-0">
        @if (! $creator['deactivate'] && ! $isAnonymous)
            {{-- Normal Author --}}
            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $creator['fsid']])) }}">
                @if ($creator['decorate'])
                    <img src="{{ $creator['decorate'] }}" loading="lazy" alt="Avatar Decorate" class="user-decorate">
                @endif
                <img src="{{ $creator['avatar'] }}" loading="lazy" alt="{{ $creator['username'] }}" class="user-avatar rounded-circle">
            </a>
        @elseif (! $creator['deactivate'] && $isAnonymous)
            {{-- Anonymous Author --}}
            <img src="{{ $creator['avatar'] }}" loading="lazy" alt="{{ fs_lang('contentCreatorAnonymous') }}" class="user-avatar rounded-circle">
        @elseif ($creator['deactivate'])
            {{-- Deactivate Author --}}
            <img src="{{ fs_db_config('deactivate_avatar') }}" loading="lazy" alt="{{ fs_lang('contentCreatorDeactivate') }}" class="user-avatar rounded-circle">
        @endif
    </div>
    <div class="flex-grow-1">
        <div class="user-primary d-lg-flex">
            @if (! $creator['deactivate'] && ! $isAnonymous)
                {{-- Normal Author --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $creator['fsid']])) }}" class="user-link d-flex">
                        <div class="user-nickname text-nowrap overflow-hidden" style="color:{{ $creator['nicknameColor'] }};">{{ $creator['nickname'] }}</div>
                        @if ($creator['verifiedStatus'])
                            <div class="user-verified">
                                @if ($creator['verifiedIcon'])
                                    <img src="{{ $creator['verifiedIcon'] }}" loading="lazy" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['verifiedDesc'] }}">
                                @else
                                    <img src="/assets/themes/ThemeFrame/images/icon-verified.png" loading="lazy" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['verifiedDesc'] }}">
                                @endif
                            </div>
                        @endif
                        <div class="user-name text-secondary">{{ '@'.$creator['fsid'] }}</div>
                    </a>
                    <div class="user-role d-flex">
                        @if ($creator['roleIconDisplay'])
                            <div class="user-role-icon"><img src="{{ $creator['roleIcon'] }}" loading="lazy" alt="{{ $creator['roleName'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['roleName'] }}"></div>
                        @endif
                        @if ($creator['roleNameDisplay'])
                            <div class="user-role-name"><span class="badge rounded-pill">{{ $creator['roleName'] }}</span></div>
                        @endif
                    </div>
                </div>

                {{-- Post Author --}}
                @if ($creator['isPostCreator'])
                    <div>
                        <span class="author-badge" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ fs_db_config('post_name').': '.fs_lang('contentCreator') }}">
                            {{ fs_lang('contentCreator') }}
                        </span>
                    </div>
                @endif

                {{-- User Attachment Icons --}}
                @if ($creator['operations']['diversifyImages'])
                    <div class="user-icon d-flex flex-wrap flex-lg-nowrap overflow-hidden my-2 my-lg-0">
                        @foreach($creator['operations']['diversifyImages'] as $icon)
                            <img src="{{ $icon['imageUrl'] }}" loading="lazy" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}">
                        @endforeach
                    </div>
                @endif
            @elseif (! $creator['deactivate'] && $isAnonymous)
                {{-- Anonymous Author --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('contentCreatorAnonymous') }}</div>
                </div>
            @elseif ($creator['deactivate'])
                {{-- Deactivate Author --}}
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('contentCreatorDeactivate') }}</div>
                </div>
            @endif
        </div>
        <div class="user-secondary d-flex flex-wrap mb-3">
            {{-- Comment Created Time --}}
            <time class="text-secondary" datetime="{{ $createTime }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $createTime }}">{{ $createTimeFormat }}</time>

            {{-- Comment Edit Time --}}
            @if ($editTime)
                <div class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $editTime }}">({{ fs_lang('contentEditedOn') }} {{ $editTimeFormat }})</div>
            @endif

            {{-- Commenter Reply User --}}
            @if ($replyToUser)
                <div class="text-success ms-2">
                    {{ fs_db_config('publish_comment_name') }}
                    @if (! $replyToUser['deactivate'] && $replyToUser['fsid'])
                        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $replyToUser['fsid']])) }}">{{ '@'.$replyToUser['fsid'] }}</a>
                    @elseif (! $replyToUser['deactivate'] && empty($replyToUser['fsid']))
                        <span class="text-muted">{{ fs_lang('contentCreatorAnonymous') }}</span>
                    @elseif ($replyToUser['deactivate'])
                        <span class="text-muted">{{ fs_lang('contentCreatorDeactivate') }}</span>
                    @endif
                </div>
            @endif

            {{-- IP Location --}}
            @if (fs_db_config('account_ip_location_status') && current_lang_tag() == 'zh-Hans')
                <span class="text-secondary ms-3">
                    <i class="bi bi-geo"></i>
                    @if ($ipLocation)
                        {{ fs_lang('ipLocation').$ipLocation }}
                    @else
                        {{ fs_lang('errorIp') }}
                    @endif
                </span>
            @endif

            {{-- Commenter Location --}}
            @if ($location['isLbs'])
                <a href="{{ fs_route(route('fresns.comment.location', [
                    'cid' => $cid,
                    'type' => 'posts',
                ])) }}" class="link-secondary ms-3"><i class="bi bi-geo-alt-fill"></i> {{ $location['poi'] }}</a>
            @endif
        </div>
    </div>
</div>
