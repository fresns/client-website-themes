<div class="editor-alert">
    <ul class="list-group mb-3">
        <li class="list-group-item list-group-item-danger">{{ fs_lang('editorLimitTitle') }}:</li>
        @if ($config['limit']['type'] == 1)
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div class="bd-highlight">{{ fs_lang('editorLimitTypeName') }}</div>
                <div class="bd-highlight">
                    <kbd>{{ fs_lang('editorLimitType1Desc') }}</kbd>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div class="bd-highlight">{{ fs_lang('editorLimitDateName') }}</div>
                <div class="bd-highlight">
                    <kbd>{{ $config['limit']['periodStart'] }}</kbd>
                    -
                    <kbd>{{ $config['limit']['periodEnd'] }}</kbd>
                </div>
            </li>
        @else
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div class="bd-highlight">{{ fs_lang('editorLimitTypeName') }}</div>
                <div class="bd-highlight">
                    <kbd>{{ fs_lang('editorLimitType2Desc') }}</kbd>
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div class="bd-highlight">{{ fs_lang('editorLimitCycleName') }}</div>
                <div class="bd-highlight">
                    <kbd>{{ $config['limit']['cycleStart'] }}</kbd>
                    -
                    <kbd>{{ $config['limit']['cycleEnd'] }}</kbd>
                </div>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight">{{ fs_lang('editorLimitRuleName') }}</div>
            <div class="bd-highlight">
                @if ($config['limit']['rule'] == 1)
                    <kbd>{{ fs_lang('editorLimitRule1Desc') }}</kbd>
                @else
                    <kbd>{{ fs_lang('editorLimitRule2Desc') }}</kbd>
                @endif
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="bd-highlight w-50">{{ fs_lang('editorLimitPromptName') }}</div>
            <div class="bd-highlight">{{ $config['limit']['tip'] }}</div>
        </li>
    </ul>
</div>
