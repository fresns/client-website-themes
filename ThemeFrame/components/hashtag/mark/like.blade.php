<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactiveType" value="like"/>
    <input type="hidden" name="markType" value="hashtag"/>
    <input type="hidden" name="fsid" value="{{ $hid }}"/>
    @if ($interactive['likeStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interactive-active="{{ $interactive['likeStatus'] }}" data-bi="bi-hand-thumbs-up">
            <i class="bi bi-hand-thumbs-up-fill"></i>
            @if (fs_api_config('hashtag_liker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="bi-hand-thumbs-up-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interactive['likeName'] }}">
            <i class="bi bi-hand-thumbs-up"></i>
            @if (fs_api_config('hashtag_liker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
