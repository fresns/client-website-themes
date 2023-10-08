@php
    $btnIcon = '/assets/WebFrame/images/icon-like.png';
    $btnIconActive = '/assets/WebFrame/images/icon-like-active.png';
@endphp

@if ($icon)
    @php
        $btnIcon = $icon['imageUrl'];
        $btnIconActive = $icon['imageActiveUrl'];
    @endphp
@endif

<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="like"/>
    <input type="hidden" name="markType" value="comment"/>
    <input type="hidden" name="fsid" value="{{ $cid }}"/>
    @if ($interaction['likeStatus'])
        <a class="btn btn-inter btn-active fs-mark" data-icon="{{ $btnIcon }}" data-icon-active="{{ $btnIconActive }}" data-interaction-active="{{ $interaction['likeStatus'] }}">
            <img src="{{ $btnIconActive }}" loading="lazy">
            @if (fs_api_config('comment_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-inter fs-mark" data-icon="{{ $btnIcon }}" data-icon-active="{{ $btnIconActive }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['likeName'] }}">
            <img src="{{ $btnIcon }}" loading="lazy">
            @if (fs_api_config('comment_liker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
