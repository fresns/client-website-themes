<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactiveType" value="block"/>
    <input type="hidden" name="markType" value="post"/>
    <input type="hidden" name="fsid" value="{{ $pid }}"/>
    @if ($interactive['blockStatus'])
        <a class="dropdown-item py-2 text-success fs-mark" data-interactive-active="{{ $interactive['blockStatus'] }}" data-bi="bi-bookmark-x" data-name="{{ $interactive['blockName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-x-fill"></i>
            <span class="show-text">√ {{ $interactive['blockName'] }}</span>
            @if (fs_api_config('post_disliker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="dropdown-item py-2 fs-mark" data-bi="bi-bookmark-x-fill" data-name="{{ $interactive['blockName'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-x"></i>
            <span class="show-text">{{ $interactive['blockName'] }}</span>
            @if (fs_api_config('post_disliker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
