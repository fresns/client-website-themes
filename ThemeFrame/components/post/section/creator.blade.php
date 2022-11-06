@if (! $creator['deactivate'] && ! $isAnonymous)
    {{-- Normal Author --}}
    <div class="d-flex">
        <div class="flex-shrink-0">
            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $creator['fsid']])) }}">
                @if ($creator['decorate'])
                    <img src="{{ $creator['decorate'] }}" alt="Avatar Decorate" class="user-decorate">
                @endif
                <img src="{{ $creator['avatar'] }}" alt="Avatar" class="user-avatar rounded-circle">
            </a>
        </div>
        <div class="flex-grow-1">
            <div class="user-primary d-lg-flex">
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $creator['fsid']])) }}" class="user-link d-flex">
                        <div class="user-nickname text-nowrap overflow-hidden" style="color:{{ $creator['nicknameColor'] }};">{{ $creator['nickname'] }}</div>
                        @if ($creator['verifiedStatus'])
                            <div class="user-verified">
                                @if ($creator['verifiedIcon'])
                                    <img src="{{ $creator['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['verifiedDesc'] }}">
                                @else
                                    <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['verifiedDesc'] }}">
                                @endif
                            </div>
                        @endif
                        <div class="user-name text-secondary">{{ '@' . $creator['username'] }}</div>
                    </a>
                    <div class="user-role d-flex">
                        @if ($creator['roleIconDisplay'])
                            <div class="user-role-icon"><img src="{{ $creator['roleIcon'] }}" alt="Main Role" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $creator['roleName'] }}"></div>
                        @endif
                        @if ($creator['roleNameDisplay'])
                            <div class="user-role-name"><span class="badge rounded-pill">{{ $creator['roleName'] }}</span></div>
                        @endif
                    </div>
                </div>

                {{-- User Attachment Icons --}}
                @if ($creator['operations']['diversifyImages'])
                    <div class="user-icon d-flex flex-wrap flex-lg-nowrap overflow-hidden my-2 my-lg-0">
                        @foreach($creator['operations']['diversifyImages'] as $icon)
                            <img src="{{ $icon['imageUrl'] }}" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="user-secondary d-flex flex-wrap mb-3">
                {{-- Post Created Time --}}
                <time class="text-secondary" datetime="{{ $createTime }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $createTime }}">{{ $createTimeFormat }}</time>

                {{-- Post Edit Time --}}
                @if ($editTime)
                    <div class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $editTime }}">({{ fs_lang('contentEditedOn') }} {{ $editTimeFormat }})</div>
                @endif

                {{-- Post Location --}}
                @if ($location['isLbs'])
                    <a href="{{ fs_route(route('fresns.post.location', [
                        'mapId' => $location['mapId'],
                        'mapLng' => $location['latitude'],
                        'mapLat' => $location['longitude'],
                    ])) }}" class="link-secondary ms-2"><i class="bi bi-geo-alt-fill"></i>{{ $location['poi'] }}</a>
                @endif
            </div>
        </div>
    </div>
@elseif (! $creator['deactivate'] && $isAnonymous)
    {{-- Anonymous Author --}}
    <div class="d-flex">
        <div class="flex-shrink-0">
            <img src="{{ $creator['avatar'] }}" alt="Anonymous Avatar" class="user-avatar rounded-circle">
        </div>
        <div class="flex-grow-1">
            <div class="user-primary d-lg-flex">
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('contentCreatorAnonymous') }}</div>
                </div>
            </div>
            <div class="user-secondary d-flex flex-wrap mb-3">
                {{-- Post Created Time --}}
                <time class="text-secondary" datetime="{{ $createTime }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $createTime }}">{{ $createTimeFormat }}</time>

                {{-- Post Edit Time --}}
                @if ($editTime)
                    <div class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $editTime }}">({{ fs_lang('contentEditedOn') }} {{ $editTimeFormat }})</div>
                @endif

                {{-- Post Location --}}
                @if ($location['isLbs'])
                    <a href="{{ fs_route(route('fresns.post.location', [
                        'mapId' => $location['mapId'],
                        'mapLng' => $location['latitude'],
                        'mapLat' => $location['longitude'],
                    ])) }}" class="link-secondary ms-2"><i class="bi bi-geo-alt-fill"></i>{{ $location['poi'] }}</a>
                @endif
            </div>
        </div>
    </div>
@elseif ($creator['deactivate'])
    {{-- Deactivate Author --}}
    <div class="d-flex">
        <div class="flex-shrink-0">
            <img src="{{ $creator['avatar'] }}" alt="Avatars of deactivated accounts" class="user-avatar rounded-circle">
        </div>
        <div class="flex-grow-1">
            <div class="user-primary d-lg-flex">
                <div class="user-info d-flex text-nowrap overflow-hidden">
                    <div class="text-muted">{{ fs_lang('contentCreatorDeactivate') }}</div>
                </div>
            </div>
            <div class="user-secondary d-flex flex-wrap mb-3">
                {{-- Post Created Time --}}
                <time class="text-secondary" datetime="{{ $createTime }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $createTime }}">{{ $createTimeFormat }}</time>

                {{-- Post Edit Time --}}
                @if ($editTime)
                    <div class="text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $editTime }}">({{ fs_lang('contentEditedOn') }} {{ $editTimeFormat }})</div>
                @endif

                {{-- Post Location --}}
                @if ($location['isLbs'])
                    <a href="{{ fs_route(route('fresns.post.location', [
                        'mapId' => $location['mapId'],
                        'mapLng' => $location['latitude'],
                        'mapLat' => $location['longitude'],
                    ])) }}" class="link-secondary ms-2"><i class="bi bi-geo-alt-fill"></i>{{ $location['poi'] }}</a>
                @endif
            </div>
        </div>
    </div>
@endif
