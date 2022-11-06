<div class="editor-toolbar d-flex flex-wrap shadow-sm">
    {{-- Sticker --}}
    @if ($config['sticker'])
        <div class="stickers">
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <div class="d-flex flex-column">
                    <i class="bi bi-emoji-smile"></i>
                    <span>{{ fs_lang('editorStickers') }}</span>
                </div>
            </button>
            {{-- Sticker List --}}
            <div class="dropdown-menu rounded-0 pt-0" aria-labelledby="stickers">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach($stickers as $sticker)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($loop->first) active @endif" id="sticker-{{ $loop->index }}-tab" data-bs-toggle="tab" data-bs-target="#sticker-{{ $loop->index }}" type="button" role="tab" aria-controls="sticker-{{ $loop->index }}" aria-selected="{{ $loop->first }}">{{ $sticker['name'] }}</button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content p-2" id="sticker">
                    @foreach($stickers as $sticker)
                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="sticker-{{ $loop->index }}" role="tabpanel" aria-labelledby="sticker-{{ $loop->index }}-tab">
                            @foreach($sticker['stickers'] as $value)
                                <a class="fresns-sticker btn btn-outline-secondary rounded-0 border-0" href="javascript:;" value="{{ $value['code'] }}" title="{{ $value['code'] }}" >
                                    <img src="{{ $value['image'] }}" alt="{{ $value['code'] }}" title="{{ $value['code'] }}">
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Image --}}
    @if ($config['image']['status'])
        @if ($config['image']['uploadForm'] == 'fresns')
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-upload"
                data-type="image"
                data-accept="{{ $config['image']['inputAccept'] }}"
                data-extensions="{{ $config['image']['extensions'] }}"
                data-maxsize="{{ $config['image']['maxSize'] }}"
                data-maxnumber="{{ $config['image']['uploadNumber'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-image"></i>
                    <span>{{ fs_lang('editorImages') }}</span>
                </div>
            </button>
        @else
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                data-lang-tag="{{ current_lang_tag() }}"
                data-post-message-key="fresnsEditorUpload"
                data-type="editor"
                data-scene="{{ $type.'Editor' }}"
                @if ($type == 'post')
                    data-plid="{{ $plid }}"
                @else
                    data-clid="{{ $clid }}"
                @endif
                data-upload-info="{{ urlencode(base64_encode(json_encode($uploadInfo['image']))) }}"
                data-title="{{ fs_lang('editorUpload') }}"
                data-url="{{ $config['image']['uploadUrl'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-image"></i>
                    <span>{{ fs_lang('editorImages') }}</span>
                </div>
            </button>
        @endif
    @endif

    {{-- Video --}}
    @if ($config['video']['status'])
        @if ($config['video']['uploadForm'] == 'fresns')
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-upload"
                data-type="video"
                data-accept="{{ $config['video']['inputAccept'] }}"
                data-extensions="{{ $config['video']['extensions'] }}"
                data-maxsize="{{ $config['video']['maxSize'] }}"
                data-maxtime="{{ $config['video']['maxTime'] }}"
                data-maxnumber="{{ $config['video']['uploadNumber'] }}">
                    <div class="d-flex flex-column">
                    <i class="bi bi-film"></i>
                    <span>{{ fs_lang('editorVideos') }}</span>
                </div>
            </button>
        @else
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                data-lang-tag="{{ current_lang_tag() }}"
                data-post-message-key="fresnsEditorUpload"
                data-type="editor"
                data-scene="{{ $type.'Editor' }}"
                @if ($type == 'post')
                    data-plid="{{ $plid }}"
                @else
                    data-clid="{{ $clid }}"
                @endif
                data-upload-info="{{ urlencode(base64_encode(json_encode($uploadInfo['video']))) }}"
                data-title="{{ fs_lang('editorUpload') }}"
                data-url="{{ $config['video']['uploadUrl'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-film"></i>
                    <span>{{ fs_lang('editorVideos') }}</span>
                </div>
            </button>
        @endif
    @endif

    {{-- Audio --}}
    @if ($config['audio']['status'])
        @if ($config['audio']['uploadForm'] == 'fresns')
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-upload"
                data-type="audio"
                data-accept="{{ $config['audio']['inputAccept'] }}"
                data-extensions="{{ $config['audio']['extensions'] }}"
                data-maxsize="{{ $config['audio']['maxSize'] }}"
                data-maxtime="{{ $config['audio']['maxTime'] }}"
                data-maxnumber="{{ $config['audio']['uploadNumber'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-music-note-beamed"></i>
                    <span>{{ fs_lang('editorAudios') }}</span>
                </div>
            </button>
        @else
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                data-lang-tag="{{ current_lang_tag() }}"
                data-post-message-key="fresnsEditorUpload"
                data-type="editor"
                data-scene="{{ $type.'Editor' }}"
                @if ($type == 'post')
                    data-plid="{{ $plid }}"
                @else
                    data-clid="{{ $clid }}"
                @endif
                data-upload-info="{{ urlencode(base64_encode(json_encode($uploadInfo['audio']))) }}"
                data-title="{{ fs_lang('editorUpload') }}"
                data-url="{{ $config['audio']['uploadUrl'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-music-note-beamed"></i>
                    <span>{{ fs_lang('editorAudios') }}</span>
                </div>
            </button>
        @endif
    @endif

    {{-- Document --}}
    @if ($config['document']['status'])
        @if ($config['document']['uploadForm'] == 'fresns')
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-upload"
                data-type="document"
                data-accept="{{ $config['document']['inputAccept'] }}"
                data-extensions="{{ $config['document']['extensions'] }}"
                data-maxsize="{{ $config['document']['maxSize'] }}"
                data-maxnumber="{{ $config['document']['uploadNumber'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>{{ fs_lang('editorDocuments') }}</span>
                </div>
            </button>
        @else
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                data-lang-tag="{{ current_lang_tag() }}"
                data-post-message-key="fresnsEditorUpload"
                data-type="editor"
                data-scene="{{ $type.'Editor' }}"
                @if ($type == 'post')
                    data-plid="{{ $plid }}"
                @else
                    data-clid="{{ $clid }}"
                @endif
                data-upload-info="{{ urlencode(base64_encode(json_encode($uploadInfo['document']))) }}"
                data-title="{{ fs_lang('editorUpload') }}"
                data-url="{{ $config['document']['uploadUrl'] }}">
                <div class="d-flex flex-column">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>{{ fs_lang('editorDocuments') }}</span>
                </div>
            </button>
        @endif
    @endif

    {{-- Title --}}
    @if ($config['title']['status'])
        <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="collapse" href="#titleCollapse" aria-expanded="false" aria-controls="titleCollapse">
            <div class="d-flex flex-column">
                <i class="bi bi-textarea-t"></i>
                <span>{{ fs_lang('editorTitle') }}</span>
            </div>
        </button>
    @endif

    {{-- Mention --}}
    @if ($config['mention'])
        <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-mention">
            <div class="d-flex flex-column">
                <i class="bi bi-at"></i>
                <span>{{ fs_lang('editorMention') }}</span>
            </div>
        </button>
    @endif

    {{-- Hashtag --}}
    @if ($config['hashtag']['status'])
        <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresns-hashtag">
            <div class="d-flex flex-column">
                <i class="bi bi-hash"></i>
                <span>{{ fs_lang('editorHashtag') }}</span>
            </div>
        </button>
    @endif

    {{-- Extend Toolbar --}}
    @if ($config['extend']['list'])
        @foreach($config['extend']['list'] as $extend)
            @if ($extend['editorToolbar'])
                <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                    data-lang-tag="{{ current_lang_tag() }}"
                    data-post-message-key="fresnsEditorExtension"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    @if ($type == 'post')
                        data-plid="{{ $plid }}"
                    @else
                        data-clid="{{ $clid }}"
                    @endif
                    data-title="{{ $extend['name'] }}"
                    data-url="{{ $extend['url'] }}">
                    <div class="d-flex flex-column">
                        <img src="{{ $extend['icon'] }}" width="20" height="20">
                        <span>{{ $extend['name'] }}</span>
                    </div>
                </button>
            @endif
        @endforeach
    @endif

    {{-- Extend Menu --}}
    @if ($config['extend']['status'] && $config['extend']['list'])
        <div class="dropdown">
            <button type="button" class="btn btn-outline-secondary rounded-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex flex-column">
                    <i class="bi bi-menu-up"></i>
                    <span>{{ fs_lang('editorExtends') }}</span>
                </div>
            </button>

            {{-- Extend List --}}
            <ul class="dropdown-menu rounded-0" aria-labelledby="expands">
                @foreach($config['extend']['list'] as $extend)
                    @if (! $extend['editorToolbar'])
                        <li>
                            <a class="dropdown-item" role="button" data-bs-toggle="modal" href="#fresnsModal"
                                data-lang-tag="{{ current_lang_tag() }}"
                                data-post-message-key="fresnsEditorExtension"
                                data-type="editor"
                                data-scene="{{ $type.'Editor' }}"
                                @if ($type == 'post')
                                    data-plid="{{ $plid }}"
                                @else
                                    data-clid="{{ $clid }}"
                                @endif
                                data-title="{{ $extend['name'] }}"
                                data-url="{{ $extend['url'] }}">
                                <img src="{{ $extend['icon'] }}" width="20" height="20">
                                {{ $extend['name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>


{{-- Mention Modal --}}
@if ($config['mention'])
    <div class="modal fade" id="fresns-mention" tabindex="-1" aria-labelledby="fresns-mention" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" list="memberLists" class="form-control" id="atUser" placeholder="{{ fs_api_config('user_name_name') }} {{ fs_lang('modifierOr') }} {{ fs_api_config('user_nickname_name') }}">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-bs-dismiss="modal" aria-label="Close">✓</button>
                    </div>
                    <datalist id="memberLists">

                    </datalist>
                </div>
            </div>
        </div>
    </div>
@endif


{{-- Hashtag Modal --}}
@if ($config['hashtag']['status'])
    <div class="modal fade" id="fresns-hashtag" tabindex="-1" aria-labelledby="fresns-hashtag" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">#</span>
                        <input type="text" list="hashtagLists" id="atHashtag" class="form-control" placeholder="{{ fs_api_config('hashtag_name') }}">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-bs-dismiss="modal" aria-label="Close">✓</button>
                    </div>
                    <datalist id="hashtagLists">

                    </datalist>
                </div>
            </div>
        </div>
    </div>
@endif

@push('script')
    <script>
        $(function (){
            $("#atUser").on('input propertychange change', function (){
                let query = $(this).val().trim();
                if (query) {
                    $.get("{{ route('fresns.api.input.tips') }}", {"type": 'user', "key": query}, function (data) {
                        let html = "";
                        $.each(data, function (k,v){
                            html += "<option value='" + v.name + "'>" + v.nickname + " " + "@" + v.name + "</option>"
                        })
                        $("#memberLists").empty().html(html);
                    }, 'json')
                }
            }).bind('keypress', function (event) {
                if (event.keyCode === 13) {
                    event.preventDefault()
                    $("#atUser").next().trigger("click")
                }
            })

            $("#atHashtag").on('input propertychange change', function (){
                let query = $(this).val().trim();
                if (query) {
                    $.get("{{ route('fresns.api.input.tips') }}", {"type": 'hashtag', "key": query}, function (data) {
                        let html = "";
                        $.each(data, function (k,v){
                            html += "<option value='" + v.name +"'>"+ v.name +"</option>"
                        })
                        $("#hashtagLists").empty().html(html);
                    }, 'json')
                }
            }).bind('keypress', function (event) {
                if (event.keyCode === 13) {
                    event.preventDefault()
                    $("#atHashtag").next().trigger("click")
                }
            })

            $("#atHashtag").next().on('click',function () {
                let hashtagContent = $("#atHashtag").val();
                if (hashtagContent) {
                    @if(fs_api_config('hashtag_show') == 2)
                        $("#content").trigger('click').insertAtCaret(" #" + hashtagContent + "# ");
                    @else
                        $("#content").trigger('click').insertAtCaret(" #" + hashtagContent + " ");
                    @endif
                }
            });

            $("#atUser").next().on('click',function () {
                let userContent = $("#atUser").val();
                if (userContent) {
                    $("#content").trigger('click').insertAtCaret(" @" + userContent + " ");
                }
            });
        })
    </script>
@endpush
