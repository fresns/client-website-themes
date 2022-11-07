@php
    $user = $user ?? $profile;
@endphp

@if ($user['banner'])
    <img src="{{ $user['banner'] }}" class="card-img-top">
@endif

<section class="avatar" style="margin-top:1rem">
    @if ($user['decorate'])
        <img src="{{ $user['decorate'] }}" alt="Decorate" class="profile-decorate">
    @endif
    <img src="{{ $user['avatar'] }}" alt="{{ $user['nickname'] }}" class="profile-avatar rounded-circle">
</section>

<section class="userinfo">
    <div class="profile-nickname d-flex justify-content-center">
        <h1 style="color:{{ $user['nicknameColor'] }};">{{ $user['nickname'] }}</h1>
        @if ($user['verifiedStatus'])
            @if ($user['verifiedIcon'])
                <img src="{{ $user['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
            @else
                <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
            @endif
        @endif
        @if ($user['roleIconDisplay'] && $user['roleIcon'])
            <img src="{{ $user['roleIcon'] }}" alt="{{ $user['roleName'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['roleName'] }}">
        @endif
        @if ($user['roleNameDisplay'])
            <span class="badge text-bg-secondary">{{ $user['roleName'] }}</span>
        @endif
    </div>
    <div class="mb-2 text-secondary">{{ '@' . $user['username'] }}</div>
    <p class="fs-7 text-secondary">{{ $user['bio'] }}</p>

    {{-- User Attachment Icons --}}
    @if ($user['operations']['diversifyImages'])
        <div class="text-center">
            @foreach($user['operations']['diversifyImages'] as $icon)
                <img src="{{ $icon['imageUrl'] }}" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}" style="height:2rem">
            @endforeach
        </div>
    @endif
</section>

@if ($followersYouFollow)
    <section class="text-center my-3">
        @foreach($followersYouFollow as $friend)
            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $friend['fsid']])) }}">{{ $friend['nickname'] }}</a>@if (! $loop->last), @endif
        @endforeach
        {{ fs_lang('userFollowersYouKnow') }}
    </section>
@endif

<section class="d-flex justify-content-center overflow-hidden mb-4">
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
        <span class="badge rounded-pill bg-secondary m-1">{{ fs_lang('userFollowMutual') }}</span>
    @elseif ($user['interactive']['followMeStatus'])
        <span class="badge rounded-pill bg-secondary m-1">{{ fs_lang('userFollowMe') }}</span>
    @endif
</section>
