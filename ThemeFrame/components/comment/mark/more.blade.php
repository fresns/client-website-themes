<ul class="dropdown-menu interaction-more" aria-labelledby="more">
    {{-- Edit --}}
    @if ($editStatus['isMe'] && $editStatus['canEdit'])
        <li>
            <a class="dropdown-item py-2 web-request-link" href="#" data-action="{{ fs_route(route('fresns.editor.store', ['type' => 'comment', 'fsid' => $cid])) }}">
                <i class="bi bi-pencil-square"></i>
                {{ fs_lang('edit') }}
            </a>
        </li>
    @endif

    {{-- Delete --}}
    @if ($editStatus['isMe'] && $editStatus['canDelete'])
        <li><a class="dropdown-item py-2" data-bs-toggle="modal" href="#delete-{{ $cid }}"><i class="fa-regular fa-trash-can"></i> {{ fs_lang('delete') }}</a></li>
    @endif

    {{-- Follow --}}
    @if ($interaction['followSetting'])
        <li>
            @component('components.comment.mark.follow', [
                'cid' => $cid,
                'interaction' => $interaction,
                'count' => $followCount,
            ])@endcomponent
        </li>
    @endif

    {{-- Block --}}
    @if ($interaction['blockSetting'])
        <li>
            @component('components.comment.mark.block', [
                'cid' => $cid,
                'interaction' => $interaction,
                'count' => $blockCount,
            ])@endcomponent
        </li>
    @endif

    {{-- Manages --}}
    @if ($manages)
        @foreach($manages as $plugin)
            <li>
                <a class="dropdown-item py-2" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="comment"
                    data-scene="manage"
                    data-post-message-key="fresnsCommentManage"
                    data-cid="{{ $cid }}"
                    data-uid="{{ $uid }}"
                    data-title="{{ $plugin['name'] }}"
                    data-url="{{ $plugin['url'] }}">
                    @if ($plugin['icon'])
                        <img src="{{ $plugin['icon'] }}" loading="lazy" width="20" height="20">
                    @endif
                    {{ $plugin['name'] }}
                </a>
            </li>
        @endforeach
    @endif
</ul>

{{-- Delete Secondary Confirmation --}}
@if ($editStatus['isMe'] && $editStatus['canDelete'])
    <div class="modal fade" id="delete-{{ $cid }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-{{ $cid }}Label" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">{{ fs_lang('delete') }}?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ fs_lang('cancel') }}</button>
                    <a class="btn btn-danger api-request-link" href="#" role="button" data-method="DELETE" data-id="{{ $cid }}" data-action="{{ route('fresns.api.content.delete',  ['type' => 'comment', 'fsid' => $cid]) }}" data-bs-dismiss="modal">{{ fs_lang('delete') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif