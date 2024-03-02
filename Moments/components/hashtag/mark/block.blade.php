<form action="{{ route('fresns.api.post', ['path' => '/api/fresns/v1/user/mark']) }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="markType" value="block"/>
    <input type="hidden" name="type" value="hashtag"/>
    <input type="hidden" name="fsid" value="{{ $htid }}"/>
    @if ($interaction['blockStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interaction-active="{{ $interaction['blockStatus'] }}" data-bi="fa-regular fa-circle-xmark" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('cancel') }}">
            <i class="fa-solid fa-circle-xmark"></i>
            @if ($interaction['blockPublicCount'] && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm" id="fs-mark-block-{{ $htid }}" data-bs-toggle="collapse" href="#collapse-{{ $htid }}" aria-expanded="false" aria-controls="collapse-{{ $htid }}">
            <i class="fa-regular fa-circle-xmark"></i>
            @if ($interaction['blockPublicCount'] && $count)
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>

        <div class="collapse" id="collapse-{{ $htid }}">
            <div class="card card-body my-1">
                <h5 class="card-title fs-6">{{ $interaction['blockName'] }}?</h5>
                <a class="btn btn-danger btn-sm fs-mark" role="button" data-id="fs-mark-block-{{ $htid }}" data-collapse-id="collapse-{{ $htid }}" data-bi="fa-solid fa-circle-xmark" data-name="{{ $interaction['blockName'] }}" href="javascript:void(0)">{{ fs_lang('confirm') }}</a>
            </div>
        </div>
    @endif
</form>
