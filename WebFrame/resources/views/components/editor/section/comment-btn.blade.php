@if ($commentBtn['isCommentBtn'] ?? false)
    <ul class="list-group mt-3">
        <li class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
            <div class="bd-highlight">{{ fs_lang('editorCommentButtonTitle') }}:</div>
            <div class="bd-highlight">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    data-post-message-key="fresnsEditorCommentBtn"
                    @if ($type == 'post')
                        data-plid="{{ $plid }}"
                    @else
                        data-clid="{{ $clid }}"
                    @endif
                    data-title="{{ fs_lang('editorCommentButtonTitle') }}"
                    data-url="{{ $commentBtn['pluginUrl'] }}">
                >
                    {{ fs_lang('modify') }}
                </button>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorCommentButtonName') }}</div>
            <div class="bd-highlight">
                <span class="badge bg-secondary rounded-pill">{{ $commentBtn['defaultLangBtnName'] }}</span>
            </div>
        </li>
    </ul>
@endif
