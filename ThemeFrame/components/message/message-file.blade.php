{{-- Image --}}
@if ($file['type'] == 1)
    <img src="{{ $file['imageRatioUrl'] }}" data-zoom-src="{{ $file['imageBigUrl'] }}" class="img-fluid zoom-image">
@endif

{{-- Video --}}
@if ($file['type'] == 2)
    <video controls preload="metadata" controls="true" controlslist="nodownload"
        @if ($file['videoGifUrl'])
            poster="{{ $file['videoGifUrl'] }}"
        @elseif ($file['videoCoverUrl'])
            poster="{{ $file['videoCoverUrl'] }}"
        @endif
    >
        <source src="{{ $file['videoUrl'] }}" type="{{ $file['mime'] }}">
        <span class="alert alert-warning my-2" role="alert">Your browser does not support the video element.</span>
    </video>
@endif

{{-- Audio --}}
@if ($file['type'] == 3)
    <audio src="{{ $file['audioUrl'] }}" controls="controls" preload="metadata" controlsList="nodownload" oncontextmenu="return false">
        <span class="alert alert-warning my-2" role="alert">Your browser does not support the audio element.</span>
    </audio>
@endif

{{-- Document --}}
@if ($file['type'] == 4)
    <a href="{{ route('fresns.api.content.file.link', ['fid' => $file['fid'], 'type' => 'conversation', 'fsid' => $messageId]) }}" data-name="{{ $file['name'] }}" data-mime="{{ $file['mime'] }}" class="btn doc-box" role="button">
        <span class="doc-icon">
            @if ($file['extension'] == 'doc' || $file['extension'] == 'docx' || $file['extension'] == 'pages')
                <i class="bi bi-file-earmark-word"></i>
            @elseif ($file['extension'] == 'xls' || $file['extension'] == 'xlsx' || $file['extension'] == 'numbers')
                <i class="bi bi-file-earmark-excel"></i>
            @elseif ($file['extension'] == 'ppt' || $file['extension'] == 'pptx' || $file['extension'] == 'key' || $file['extension'] == 'pps' || $file['extension'] == 'ppts')
                <i class="bi bi-file-earmark-ppt"></i>
            @elseif ($file['extension'] == 'csv')
                <i class="bi bi-file-earmark-spreadsheet"></i>
            @elseif ($file['extension'] == 'pdf')
                <i class="bi bi-file-earmark-pdf"></i>
            @elseif ($file['extension'] == 'rar' || $file['extension'] == 'zip' || $file['extension'] == '7z' || $file['extension'] == 'tar' || $file['extension'] == 'gz' || $file['extension'] == 'tar.gz')
                <i class="bi bi-file-earmark-zip"></i>
            @elseif ($file['extension'] == 'epub' || $file['extension'] == 'mobi')
                <i class="bi bi-book"></i>
            @elseif ($file['extension'] == 'md')
                <i class="bi bi-markdown"></i>
            @elseif ($file['extension'] == 'txt')
                <i class="bi bi-file-text"></i>
            @else
                <i class="bi bi-file-earmark"></i>
            @endif
        </span>
        <span class="doc-name text-nowrap overflow-hidden mx-3">{{ $file['name'] }}</span>
    </a>
@endif
