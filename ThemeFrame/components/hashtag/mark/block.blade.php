<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactionType" value="block"/>
    <input type="hidden" name="markType" value="hashtag"/>
    <input type="hidden" name="fsid" value="{{ $hid }}"/>
    @if ($interaction['blockStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['blockStatus'] }}" data-bi="bi-x-octagon">
            <i class="bi bi-x-octagon-fill"></i>
            @if (fs_api_config('hashtag_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm" id="fs-mark-block-{{ $hid }}" data-bs-toggle="collapse" href="#collapse-{{ $hid }}" aria-expanded="false" aria-controls="collapse-{{ $hid }}">
            <i class="bi bi-x-octagon"></i>
            @if (fs_api_config('hashtag_blocker_count') && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>

        <div class="collapse" id="collapse-{{ $hid }}">
            <div class="card card-body my-1">
                <h5 class="card-title fs-6">{{ $interaction['blockName'] }}?</h5>
                <a class="btn btn-danger btn-sm fs-mark" role="button" data-id="fs-mark-block-{{ $hid }}" data-collapse-id="collapse-{{ $hid }}" data-bi="bi-x-octagon-fill" data-name="{{ $interaction['blockName'] }}" href="javascript:void(0)">{{ fs_lang('confirm') }}</a>
            </div>
        </div>
    @endif
</form>
