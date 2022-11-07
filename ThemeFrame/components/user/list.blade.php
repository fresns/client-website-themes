<article class="d-flex mb-3">
    {{-- Avatar --}}
    <section class="flex-shrink-0">
        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $user['fsid']])) }}">
            @if ($user['decorate'])
                <img src="{{ $user['decorate'] }}" alt="Decorate" class="user-decorate">
            @endif
            <img src="{{ $user['avatar'] }}" alt="{{ $user['nickname'] }}" class="user-avatar rounded-circle">
        </a>
    </section>
    <div class="flex-grow-1">
        {{-- Header --}}
        <header class="user-primary d-lg-flex">
            <div class="user-info d-flex text-nowrap overflow-hidden">
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $user['fsid']])) }}" class="user-link d-flex">
                    <div class="user-nickname text-nowrap overflow-hidden" style="color:{{ $user['nicknameColor'] }};">{{ $user['nickname'] }}</div>
                    @if ($user['verifiedStatus'])
                        <div class="user-verified">
                            @if ($user['verifiedIcon'])
                                <img src="{{ $user['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
                            @else
                                <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
                            @endif
                        </div>
                    @endif
                    <div class="user-name text-secondary">{{ '@' . $user['username'] }}</div>
                </a>
                <div class="user-role d-flex">
                    @if ($user['roleIconDisplay'])
                        <div class="user-role-icon"><img src="{{ $user['roleIcon'] }}" alt="{{ $user['roleName'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['roleName'] }}"></div>
                    @endif
                    @if ($user['roleNameDisplay'])
                        <div class="user-role-name"><span class="badge rounded-pill">{{ $user['roleName'] }}</span></div>
                    @endif
                </div>
            </div>

            {{-- User Attachment Icons --}}
            @if ($user['operations']['diversifyImages'])
                <div class="user-icon d-flex flex-wrap flex-lg-nowrap overflow-hidden my-2 my-lg-0">
                    @foreach($user['operations']['diversifyImages'] as $icon)
                        <img src="{{ $icon['icon'] }}" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}">
                    @endforeach
                </div>
            @endif
        </header>

        {{-- Bio --}}
        <section class="user-secondary d-flex flex-wrap mb-1">
            <p class="fs-7 mt-1 mb-2 pe-2 text-secondary">{{ $user['bio'] }}</p>
        </section>

        {{-- Interactive information and features --}}
        <footer class="interactive-btn">
            {{-- Like --}}
            @if ($user['interactive']['likeSetting'])
                @component('components.user.mark.like', [
                    'uid' => $user['uid'],
                    'interactive' => $user['interactive'],
                    'count' => $user['stats']['likeMeCount']
                ])@endcomponent
            @endif

            {{-- Dislike --}}
            @if ($user['interactive']['dislikeSetting'])
                @component('components.user.mark.dislike', [
                    'uid' => $user['uid'],
                    'interactive' => $user['interactive'],
                    'count' => $user['stats']['dislikeMeCount']
                ])@endcomponent
            @endif

            {{-- Follow --}}
            @if ($user['interactive']['followSetting'])
                @component('components.user.mark.follow', [
                    'uid' => $user['uid'],
                    'interactive' => $user['interactive'],
                    'count' => $user['stats']['followMeCount']
                ])@endcomponent
            @endif

            {{-- Block --}}
            @if ($user['interactive']['blockSetting'])
                @component('components.user.mark.block', [
                    'uid' => $user['uid'],
                    'interactive' => $user['interactive'],
                    'count' => $user['stats']['blockMeCount']
                ])@endcomponent
            @endif

            {{-- Follow Status --}}
            @if ($user['interactive']['followMeStatus'] && $user['interactive']['followStatus'])
                <span class="badge rounded-pill bg-secondary mt-1">{{ fs_lang('userFollowMutual') }}</span>
            @elseif ($user['interactive']['followMeStatus'])
                <span class="badge rounded-pill bg-secondary mt-1">{{ fs_lang('userFollowMe') }}</span>
            @endif
        </footer>
    </div>
</article>
