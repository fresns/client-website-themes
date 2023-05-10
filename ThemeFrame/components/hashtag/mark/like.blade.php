<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="like"/>
    <input type="hidden" name="markType" value="hashtag"/>
    <input type="hidden" name="fsid" value="{{ $hid }}"/>
    @if ($interaction['likeStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['likeStatus'] }}" data-bi="bi-hand-thumbs-up">
            <i class="bi bi-hand-thumbs-up-fill"></i>
            @if (fs_api_config('hashtag_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="bi-hand-thumbs-up-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['likeName'] }}">
            <i class="bi bi-hand-thumbs-up"></i>
            @if (fs_api_config('hashtag_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
