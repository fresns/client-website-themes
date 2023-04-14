<div class="collapse @if ($config['view'] == 1 || $title) show @endif" id="titleCollapse">
    <input type="text" class="form-control form-control-lg rounded-0 border-0 ps-2"
        id="title"
        name="postTitle"
        placeholder="{{ fs_lang('editorTitle') }} (@if ($config['required']) {{ fs_lang('editorRequired') }} @else {{ fs_lang('editorOptional') }} @endif)"
        maxlength="{{ $config['length'] }}"
        @if ($config['required']) required @endif
        value="{{ $title }}"
    >
    <hr>
</div>
