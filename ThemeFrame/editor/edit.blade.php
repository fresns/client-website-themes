@extends('commons.fresns')

@section('title', fs_config('menu_editor_functions'))

@section('content')
    <div class="container-fluid">
        <div class="fresns-editor">
            <form action="{{ fs_route(route('fresns.editor.publish', [$type, $draft['detail']['id']])) }}" method="post">
                @csrf
                @method("post")
                <input type="hidden" name="type" value="{{ $type ?? '' }}" />
                <input type="hidden" name="postGid" value="{{ $draft['detail']['group']['gid'] ?? '' }}" />
                {{-- Tip: Publish Permissions --}}
                @if ($config['publish']['limit']['status'] && $config['publish']['limit']['isInTime'])
                    @component('components.editor.tip.publish', [
                        'config' => $config['publish'],
                    ])@endcomponent
                @endif

                {{-- Tip: Edit Controls --}}
                @if ($draft['editControls']['isEditDraft'] && ! in_array($draft['detail']['state'], [2, 3]))
                    @component('components.editor.tip.edit', [
                        'config' => $draft['editControls'],
                    ])@endcomponent
                @endif

                {{-- Tip: Draft under review or published --}}
                @if (in_array($draft['detail']['state'], [2, 3]))
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ $draft['detail']['state'] == 2 ? fs_lang('contentEditReviewTip') : fs_lang('contentEditPublishedTip') }}
                    </div>
                @endif

                {{-- Group --}}
                @if ($config['editor']['features']['group']['status'])
                    @component('components.editor.section.group', [
                        'draftId' => $draft['detail']['id'],
                        'config' => $config['editor']['features']['group'],
                        'group' => $draft['detail']['group'],
                    ])@endcomponent
                @endif

                {{-- Toolbar --}}
                @component('components.editor.section.toolbar', [
                    'type' => $type,
                    'plid' => $plid,
                    'clid' => $clid,
                    'config' => $config['editor']['toolbar'],
                    'uploadInfo' => $uploadInfo,
                ])@endcomponent

                {{-- Content Start --}}
                <div class="editor-content p-3">
                    {{-- Title --}}
                    @if ($config['editor']['toolbar']['title']['status'] || optional($draft['detail'])['title'])
                        @component('components.editor.section.title', [
                            'config' => $config['editor']['toolbar']['title'],
                            'title' => $draft['detail']['title'] ?? '',
                        ])@endcomponent
                    @endif

                    {{-- Content --}}
                    <textarea class="form-control rounded-0 border-0 fresns-content" name="content" id="content" rows="15" placeholder="{{ fs_lang('editorContent') }}">{{ $draft['detail']['content'] }}</textarea>

                    {{-- Files --}}
                    @component('components.editor.section.files', [
                        'type' => $type,
                        'files' => $draft['detail']['files'],
                    ])@endcomponent

                    {{-- Extends --}}
                    @component('components.editor.section.extends', [
                        'type' => $type,
                        'plid' => $plid,
                        'clid' => $clid,
                        'extends' => $draft['detail']['extends'],
                    ])@endcomponent

                    {{-- readJson --}}
                    @if ($draft['detail']['readJson'])
                        @component('components.editor.section.read', [
                            'type' => $type,
                            'plid' => $plid,
                            'clid' => $clid,
                            'readConfig' => $draft['detail']['readJson'],
                        ])@endcomponent
                    @endif

                    {{-- commentBtnJson --}}
                    @if ($draft['detail']['commentBtnJson'])
                        @component('components.editor.section.comment-btn', [
                            'type' => $type,
                            'plid' => $plid,
                            'clid' => $clid,
                            'commentBtn' => $draft['detail']['commentBtnJson'],
                        ])@endcomponent
                    @endif

                    {{-- userListJson --}}
                    @if ($draft['detail']['userListJson'])
                        @component('components.editor.section.user-list', [
                            'type' => $type,
                            'plid' => $plid,
                            'clid' => $clid,
                            'userList' => $draft['detail']['userListJson'],
                        ])@endcomponent
                    @endif

                    <hr>

                    {{-- Location and Anonymous: Start --}}
                    <div class="d-flex justify-content-between">
                        {{-- Location --}}
                        @if ($config['editor']['features']['location']['status'])
                            @component('components.editor.section.location', [
                                'type' => $type,
                                'plid' => $plid,
                                'clid' => $clid,
                                'config' => $config['editor']['features']['location'],
                                'location' => $draft['detail']['mapJson'],
                            ])@endcomponent
                        @endif

                        {{-- Anonymous --}}
                        @if ($config['editor']['features']['anonymous'])
                            @component('components.editor.section.anonymous', [
                                'type' => $type,
                                'isAnonymous' => $draft['detail']['isAnonymous'],
                            ])@endcomponent
                        @endif

                        {{-- comment disable and private --}}
                        @if ($type == 'post')
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" name="postIsCommentDisabled" value="1" id="postIsCommentDisabled" {{ $draft['detail']['isCommentDisabled'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="postIsCommentDisabled">
                                    {{ fs_lang('editorCommentDisable') }}
                                </label>
                            </div>

                            <div class="form-check ms-3">
                                <input class="form-check-input" type="checkbox" name="postIsCommentPrivate" value="1" id="postIsCommentPrivate" {{ $draft['detail']['isCommentPrivate'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="postIsCommentPrivate">
                                    {{ fs_lang('editorCommentPrivate') }}
                                </label>
                            </div>
                        @endif

                        {{-- Markdown --}}
                        <div class="form-check ms-3">
                            <input class="form-check-input" type="checkbox" name="isMarkdown" value="1" id="isMarkdown" {{ $draft['detail']['isMarkdown'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="isMarkdown">{{ fs_lang('editorContentMarkdown') }}</label>
                        </div>
                    </div>
                    {{-- Location and Anonymous: End --}}
                </div>
                {{-- Content End --}}

                {{-- Button --}}
                <div class="editor-submit d-grid">
                    <button type="submit" class="btn btn-success btn-lg my-5 mx-3" {{ in_array($draft['detail']['state'], [2, 3]) ? 'disabled' : ''}}>
                        @if ($type == 'post')
                            {{ fs_config('publish_post_name') }}
                        @endif
                        @if ($type == 'comment')
                            {{ fs_config('publish_comment_name') }}
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Modal --}}
    <div class="modal fade" id="fresns-upload" tabindex="-1" aria-labelledby="fresns-upload" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_lang('editorUpload') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="mt-2" method="post" id="upload-form" multiple="true" enctype="multipart/form-data">
                        <input type="hidden" name="usageType" @if ($type === 'post') value="7" @elseif($type === "comment") value="8" @endif>
                        <input type="hidden" name="tableName" @if ($type === 'post') value="post_logs" @elseif($type === "comment") value="comment_logs" @endif>
                        <input type="hidden" name="tableColumn" value="id">
                        <input type="hidden" name="tableId" value="{{ $draft['detail']['id'] ?? '' }}">
                        <input type="hidden" name="uploadMode" value="file">
                        <input type="hidden" name="type">
                        <input class="form-control" type="file" id="formFile">
                        <label class="form-label mt-3 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadExtensions') }}: <span id="extensions"></span></label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadMaxSize') }}: <span id="maxSize"></span> MB</label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block" id="maxTimeDiv">{{ fs_lang('editorUploadMaxTime') }}: <span id="maxTime"></span> {{ fs_lang('unitSecond') }}</label>
                        <label class="form-label mt-1 ms-1 text-secondary text-break fs-7 d-block">{{ fs_lang('editorUploadNumber') }}: <span id="maxNumber"></span></label>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="ajax-upload">{{ fs_lang('editorUploadButton') }}</button>
                    <div class="progress w-100 d-none" id="upload-progress"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function addEditorAttachment(fileinfo) {
            let html;

            if (fileinfo.type === 1) {
                html = `
                <div class="position-relative">
                    <img src="${fileinfo.imageSquareUrl}" class="img-fluid">
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;

                $(".editor-file-image").append(html);
                let imgLength = $(".editor-file-image").find(".position-relative").length
                $(".editor-file-image").removeClass().addClass("editor-file-image editor-file-image-"+ imgLength +" mt-3 clearfix")
            }
            if (fileinfo.type === 2) {
                var videoImage = ''
                if (fileinfo.videoPosterUrl) {
                    videoImage = `<img src="${fileinfo.videoPosterUrl}" class="img-fluid">`
                } else {
                    videoImage = `<svg class="bd-placeholder-img rounded" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>`
                }
                html = `
                <div class="position-relative">
                    ${videoImage}
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <button type="button" class="btn btn-light editor-btn-video-play" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('editorVideoPlay') }}" title="{{ fs_lang('editorVideoPlay') }}">
                            <i class="bi bi-play-fill"></i>
                        </button>
                    </div>
                </div>`
                $(".editor-file-video").append(html);
            }
            if (fileinfo.type === 3) {
                html = `
                <div class="position-relative">
                    <audio src="${fileinfo.audioUrl}" controls="controls" preload="meta" controlsList="nodownload" oncontextmenu="return false">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button></div>
                </div>`
                $('.editor-file-audio').append(html);
            }
            if(fileinfo.type === 4) {
                html = `
                <div class="position-relative">
                    <div class="editor-document-box">
                        <div class="editor-document-icon">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div class="editor-document-name text-nowrap overflow-hidden">${fileinfo.name}</div>
                    </div>
                    <div class="position-absolute top-0 end-0 editor-btn-delete">
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-fid="${fileinfo.fid}" onclick="deleteFile(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ fs_lang('delete') }}" title="{{ fs_lang('delete') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`
                $(".editor-file-document").append(html);
            }
        }

        function deleteFile(obj) {
            let fid = $(obj).data('fid');

            $.post("{{ route('fresns.api.editor.update', ['type' => $type, 'draftId' => $draft['detail']['id']]) }}", {
                'deleteFile': fid
            }, function (data){
                console.log(data)
            })

            $(obj).parent().parent().remove();
        }

        function deleteMap() {
            $.post("{{ route('fresns.api.editor.update', ['type' => $type, 'draftId' => $draft['detail']['id']]) }}", {
                'deleteMap': 1
            }, function (data){
                console.log(data)
            });

            $('#location-info').hide();
            $('#location-btn').show();
        }

        (function($){
            let fileUploadModal = document.getElementById('fresns-upload');
            fileUploadModal.addEventListener('show.bs.modal', function (event) {
                let button = event.relatedTarget,
                    extensions = $(button).data('extensions'),
                    type = $(button).data('type'),
                    accept = $(button).data('accept'),
                    maxSize = $(button).data('maxsize');
                    maxTime = $(button).data('maxtime') ?? 0;
                    maxNumber = $(button).data('maxnumber');

                if ($.inArray(type, ['document', 'image']) >= 0 ) {
                    $("#formFile").attr('multiple', 'multiple')
                } else {
                    $("#formFile").removeAttr('multiple')
                }

                if (maxTime == 0) {
                    $(this).find("#maxTimeDiv").addClass('d-none');
                } else {
                    $(this).find("#maxTimeDiv").removeClass('d-none');
                }

                $("#formFile").prop('accept', accept)
                $("#extensions").text(extensions);
                $("#maxSize").text(maxSize);
                $("#maxTime").text(maxTime);
                $("#maxNumber").text(maxNumber);
                $("#fresns-upload input[name='type']").val(type);
            })

            $(".fresns-sticker").on('click',function (){
                $("#content").trigger('click').insertAtCaret("[" + $(this).attr('value') + "]");
            });

            $("#fresns-upload").on('show.bs.modal', function () {
                $(this).find('#ajax-upload').show().removeAttr("disabled");
                $(this).find('#formFile').val("");
                $(this).find("#upload-progress").addClass('d-none').empty();
            })

            $("#ajax-upload").on('click', function (event){
                event.preventDefault();
                let obj = $(this),
                    maxSize = $("#maxSize").text() || 0,
                    form = new FormData(document.getElementById("upload-form"))

                let files = $('#formFile').prop('files');

                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > maxSize  * 1024 * 1024) {
                        alert("{{ fs_lang('editorUploadMaxSize') }}: " + $("#maxSize").text() + "MB");
                        return;
                    }

                    form.append('files[]', files[i])
                    maxSize += files[i].size;
                }

                if (obj.is(":disabled")) {
                    return;
                }
                if (!$("#formFile").val()) {
                    alert("{{ fs_lang('editorUploadInfo') }}");
                    return;
                }

                obj.attr('disabled', true);
                obj.hide();

                // set progress
                progress.init().setParentElement(obj.next('.progress').removeClass('d-none')).work();

                $.ajax({
                    url: "{{ route('fresns.api.editor.upload.file') }}",
                    type: "POST",
                    data: form,
                    timeout: 600000,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(resp) {
                        progress.done();
                        if (resp.code === 0) {
                            resp.data.forEach(function (res){
                                addEditorAttachment(res);
                            })
                        } else {
                            tips(resp.message, resp.code)
                        }
                        $("#fresns-upload .btn-close").trigger('click');
                    },
                    error: function(e) {
                        progress.exit();
                        tips(e.responseJSON.message)
                        $("#fresns-upload .btn-close").trigger('click');
                    },
                });
            })

            // update draft
            const updateDraft = function (title, content, fid = ''){
                $.post("{{ route('fresns.api.editor.update', ['type' => $type, 'draftId' => $draft['detail']['id']]) }}", {
                    'postTitle' : title,
                    'content':  content,
                }, function(data) {
                    console.log(data);

                    // If the 'code' value in the returned JSON is not 0, stop the interval loop
                    if (data.code != 0) {
                        clearInterval(intervalId);
                    }
                });
            };

            let content, title;
            let intervalId;

            // Start the interval loop
            intervalId = setInterval(function() {
                content = $("#content").val();
                title = $("#title").val();
                updateDraft(title, content);
            }, 10000);

            // Add a click event listener to the submit button
            $(document).ready(function() {
                $("button[type='submit']").on('click', function(event) {
                    // Stop the interval loop
                    clearInterval(intervalId);
                });
            });
        })(jQuery);
    </script>
@endpush
