<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="block"/>
    <input type="hidden" name="markType" value="comment"/>
    <input type="hidden" name="fsid" value="{{ $cid }}"/>
    @if ($interaction['blockStatus'])
        <a class="dropdown-item py-2 text-success fs-mark" data-interaction-active="{{ $interaction['blockStatus'] }}" data-bi="bi-bookmark-x" data-name="{{ $interaction['blockName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-x-fill"></i>
            <span class="show-text">{{ $interaction['blockName'] }}</span>
            @if (fs_api_config('comment_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="dropdown-item py-2 fs-mark" data-bi="bi-bookmark-x-fill" data-name="{{ $interaction['blockName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-x"></i>
            <span class="show-text">{{ $interaction['blockName'] }}</span>
            @if (fs_api_config('comment_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
