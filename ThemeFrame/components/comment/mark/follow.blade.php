<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="follow"/>
    <input type="hidden" name="markType" value="comment"/>
    <input type="hidden" name="fsid" value="{{ $cid }}"/>
    @if ($interaction['followStatus'])
        <a class="dropdown-item py-2 text-success fs-mark" data-interaction-active="{{ $interaction['followStatus'] }}" data-bi="bi-bookmark-check" data-name="{{ $interaction['followName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-check-fill"></i>
            <span class="show-text">{{ $interaction['followName'] }}</span>
            @if (fs_api_config('comment_follower_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="dropdown-item py-2 fs-mark" data-bi="bi-bookmark-check-fill" data-name="{{ $interaction['followName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-check"></i>
            <span class="show-text">{{ $interaction['followName'] }}</span>
            @if (fs_api_config('comment_follower_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
