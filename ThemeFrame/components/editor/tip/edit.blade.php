<div class="editor-alert">
    @if ($config['editableStatus'])
        <div class="alert alert-danger" role="alert">
            {{ fs_lang('editoreditedDatetimeTitle') }}<br>
            <kbd>{{ fs_lang('editoreditedDatetimeDesc') }}: {{ $config['editableTime'] }} ({{ $config['deadlineTime'] }})</kbd>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <kbd>{{ fs_lang('errorTimeout') }}</kbd>
            {{ fs_lang('editoreditedDatetimeTitle') }}
        </div>
    @endif
</div>
