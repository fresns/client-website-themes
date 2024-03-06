<div class="editor-alert">
    @if ($editControls['editableStatus'])
        <div class="alert alert-danger" role="alert">
            {{ fs_lang('editorEditTimeTitle') }}<br>
            <kbd>{{ fs_lang('editorEditTimeDesc') }}: {{ $editControls['editableTime'] }} ({{ $editControls['deadlineTime'] }})</kbd>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <kbd>{{ fs_lang('errorTimeout') }}</kbd>
            {{ fs_lang('editorEditTimeTitle') }}
        </div>
    @endif
</div>
