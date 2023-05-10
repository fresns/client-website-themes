<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="dislike"/>
    <input type="hidden" name="markType" value="hashtag"/>
    <input type="hidden" name="fsid" value="{{ $hid }}"/>
    @if ($interaction['dislikeStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['dislikeStatus'] }}" data-bi="bi-hand-thumbs-down">
            <i class="bi bi-hand-thumbs-down-fill"></i>
            @if (fs_api_config('hashtag_disliker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="bi-hand-thumbs-down-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['dislikeName'] }}">
            <i class="bi bi-hand-thumbs-down"></i>
            @if (fs_api_config('hashtag_disliker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
