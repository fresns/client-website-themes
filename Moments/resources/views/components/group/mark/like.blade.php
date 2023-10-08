<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="like"/>
    <input type="hidden" name="markType" value="group"/>
    <input type="hidden" name="fsid" value="{{ $gid }}"/>
    @if ($interaction['likeStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['likeStatus'] }}" data-bi="fa-regular fa-thumbs-up" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('cancel') }}">
            <i class="fa-solid fa-thumbs-up"></i>
            @if (fs_api_config('group_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="fa-solid fa-thumbs-up" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['likeName'] }}">
            <i class="fa-regular fa-thumbs-up"></i>
            @if (fs_api_config('group_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
