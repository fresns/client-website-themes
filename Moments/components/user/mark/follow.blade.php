<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="follow"/>
    <input type="hidden" name="markType" value="user"/>
    <input type="hidden" name="fsid" value="{{ $uid }}"/>
    @if ($interaction['followStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['followStatus'] }}" data-bi="fa-regular fa-circle d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('userUnfollow') }}">
            <i class="fa-solid fa-user-check d-none"></i>
            {{ fs_lang('userFollowing') }}
            @if (fs_config('user_follower_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="fa-solid fa-user-check" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['followName'] }}">
            <i class="fa-regular fa-circle d-none"></i>
            {{ $interaction['followName'] }}
            @if (fs_config('user_follower_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
