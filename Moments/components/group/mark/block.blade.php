<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="block"/>
    <input type="hidden" name="markType" value="group"/>
    <input type="hidden" name="fsid" value="{{ $gid }}"/>
    @if ($interaction['blockStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['blockStatus'] }}" data-bi="fa-regular fa-circle-xmark" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('cancel') }}">
            <i class="fa-solid fa-circle-xmark"></i>
            @if (fs_api_config('group_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="fa-solid fa-circle-xmark" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['blockName'] }}">
            <i class="fa-regular fa-circle-xmark"></i>
            @if (fs_api_config('group_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
