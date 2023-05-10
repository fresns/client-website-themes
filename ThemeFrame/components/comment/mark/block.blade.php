<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="block"/>
    <input type="hidden" name="markType" value="comment"/>
    <input type="hidden" name="fsid" value="{{ $cid }}"/>
    @if ($interaction['blockStatus'])
        <a class="dropdown-item py-2 text-success fs-mark" data-bi="bi-bookmark-x" data-name="{{ $interaction['blockName'] }}" data-interaction-active="{{ $interaction['blockStatus'] }}" href="javascript:void(0)">
            <i class="bi bi-bookmark-x-fill"></i>
            <span class="show-text">{{ $interaction['blockName'] }}</span>
            @if (fs_api_config('comment_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="dropdown-item py-2" id="fs-mark-block-{{ $cid }}" data-bs-toggle="collapse" href="#collapse-{{ $cid }}" aria-expanded="false" aria-controls="collapse-{{ $cid }}">
            <i class="bi bi-bookmark-x"></i>
            <span class="show-text">{{ $interaction['blockName'] }}</span>
            @if (fs_api_config('comment_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>

        <div class="collapse" id="collapse-{{ $cid }}">
            <div class="card card-body mx-3 my-1">
                <h5 class="card-title fs-6">{{ $interaction['blockName'] }}?</h5>
                <a class="btn btn-danger btn-sm fs-mark" role="button" data-id="fs-mark-block-{{ $cid }}" data-collapse-id="collapse-{{ $cid }}" data-bi="bi-bookmark-x-fill" data-name="{{ $interaction['blockName'] }}" href="javascript:void(0)">{{ fs_lang('confirm') }}</a>
            </div>
        </div>
    @endif
</form>
