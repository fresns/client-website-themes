@if ($readConfig['isReadLocked'] ?? false)
    <ul class="list-group mt-3">
        <li class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
            <div class="bd-highlight">{{ fs_lang('editorReadConfigTitle') }}:</div>
            <div class="bd-highlight">
                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    data-post-message-key="fresnseditorReadConfig"
                    @if ($type == 'post')
                        data-plid="{{ $plid }}"
                    @else
                        data-clid="{{ $clid }}"
                    @endif
                    data-title="{{ fs_lang('editorReadConfigTitle') }}"
                    data-url="{{ $readConfig['pluginUrl'] }}">
                >
                    {{ fs_lang('modify') }}
                </button>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorReadConfigRoleName') }}</div>
            <div class="bd-highlight">
                @foreach($readConfig['permissions']['roles'] as $role)
                    <span class="badge bg-secondary rounded-pill">{{ $role['name'] }}</span>
                @endforeach
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorReadConfigUserName') }}</div>
            <div class="bd-highlight">
                @foreach($readConfig['permissions']['users'] as $user)
                    <span class="badge bg-secondary rounded-pill">{{ $user['nickname'] }}</span>
                @endforeach
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorReadConfigPercentageName') }}</div>
            <div class="bd-highlight">
                <span class="badge bg-secondary rounded-pill">{{ $readConfig['previewPercentage'] }}%</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorReadConfigButtonName') }}</div>
            <div class="bd-highlight">
                <span class="badge bg-secondary rounded-pill">{{ $readConfig['defaultLangBtnName'] }}</span>
            </div>
        </li>
    </ul>
@endif
