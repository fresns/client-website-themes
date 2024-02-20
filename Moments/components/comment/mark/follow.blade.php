<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="follow"/>
    <input type="hidden" name="markType" value="comment"/>
    <input type="hidden" name="fsid" value="{{ $cid }}"/>
    @if ($interaction['followStatus'])
        <a class="dropdown-item py-2 text-success fs-mark" data-bi="fa-regular fa-heart" data-name="{{ $interaction['followName'] }}" data-interaction-active="{{ $interaction['followStatus'] }}" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('cancel') }}">
            <i class="fa-solid fa-heart"></i>
            <span class="show-text">{{ $interaction['followName'] }}</span>
            @if (fs_config('comment_follower_count') && $count)
                <span class="show-count badge text-bg-light">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="dropdown-item py-2 fs-mark" data-bi="fa-solid fa-heart" data-name="{{ $interaction['followName'] }}" href="javascript:void(0)">
            <i class="fa-regular fa-heart"></i>
            <span class="show-text">{{ $interaction['followName'] }}</span>
            @if (fs_config('comment_follower_count') && $count)
                <span class="show-count badge text-bg-light">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
