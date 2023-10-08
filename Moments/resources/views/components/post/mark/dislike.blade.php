@php
    $btnIcon = '/assets/Moments/images/icon-dislike.png';
    $btnIconActive = '/assets/Moments/images/icon-dislike-active.png';
@endphp

@if ($icon)
    @php
        $btnIcon = $icon['imageUrl'];
        $btnIconActive = $icon['imageActiveUrl'];
    @endphp
@endif

<form action="{{ route('fresns.api.user.mark') }}" method="post">
    @csrf
    <input type="hidden" name="interactionType" value="dislike"/>
    <input type="hidden" name="markType" value="post"/>
    <input type="hidden" name="fsid" value="{{ $pid }}"/>
    @if ($interaction['dislikeStatus'])
        <a class="btn btn-inter btn-active fs-mark" data-icon="{{ $btnIcon }}" data-icon-active="{{ $btnIconActive }}" data-interaction-active="{{ $interaction['dislikeStatus'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('cancel') }}">
            <img src="{{ $btnIconActive }}" loading="lazy">
            @if (fs_api_config('post_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-inter fs-mark" data-icon="{{ $btnIcon }}" data-icon-active="{{ $btnIconActive }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interaction['dislikeName'] }}">
            <img src="{{ $btnIcon }}" loading="lazy">
            @if (fs_api_config('post_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>
