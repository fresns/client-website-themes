@if (! $allow['isAllow'] ?? false)
    <ul class="list-group mt-3">
        <li class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
            <div class="bd-highlight">{{ fs_lang('editorAllowTitle') }}:</div>
            <div class="bd-highlight">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    data-post-message-key="fresnsEditorAllow"
                    @if ($type == 'post')
                        data-plid="{{ $plid }}"
                    @else
                        data-clid="{{ $clid }}"
                    @endif
                    data-title="{{ fs_lang('editorAllowTitle') }}"
                    data-url="{{ $allow['pluginUrl'] }}">
                >
                    {{ fs_lang('modify') }}
                </button>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorAllowRoleName') }}</div>
            <div class="bd-highlight">
                @foreach($allow['permissions']['roles'] as $role)
                    <span class="badge bg-secondary rounded-pill">{{ $role['name'] }}</span>
                @endforeach
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorAllowUserName') }}</div>
            <div class="bd-highlight">
                @foreach($allow['permissions']['users'] as $user)
                    <span class="badge bg-secondary rounded-pill">{{ $user['nickname'] }}</span>
                @endforeach
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorAllowProportionName') }}</div>
            <div class="bd-highlight">
                <span class="badge bg-secondary rounded-pill">{{ $allow['proportion'] }}%</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorAllowBtnName') }}</div>
            <div class="bd-highlight">
                <span class="badge bg-secondary rounded-pill">{{ $allow['defaultLangBtnName'] }}</span>
            </div>
        </li>
    </ul>
@endif
