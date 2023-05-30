@extends('commons.fresns')

@section('title', fs_db_config('menu_editor_functions'))

@section('content')
    <div class="container-fluid">
        <div class="fresns-editor">
            {{-- Tip: Publish Permissions --}}
            @if ($config['publish']['limit']['status'] && $config['publish']['limit']['isInTime'])
                @component('components.editor.tip.publish', [
                    'config' => $config['publish'],
                ])@endcomponent
            @endif

            {{-- Toolbar --}}
            @component('components.editor.section.toolbar', [
                'type' => $type,
                'plid' => null,
                'clid' => null,
                'config' => $config['editor']['toolbar'],
                'uploadInfo' => $uploadInfo,
            ])@endcomponent

            {{-- Content Start --}}
            <div class="editor-content p-3">
                {{-- Title --}}
                @if ($config['editor']['toolbar']['title']['status'])
                    @component('components.editor.section.title', [
                        'config' => $config['editor']['toolbar']['title'],
                        'title' => '',
                    ])@endcomponent
                @endif

                {{-- Content --}}
                <textarea class="form-control rounded-0 border-0" id="content" rows="20" placeholder="{{ fs_lang('editorContent') }}"></textarea>
            </div>
            {{-- Content End --}}

            {{-- Button --}}
            <div class="editor-submit d-grid">
                <button type="submit" class="btn btn-success btn-lg my-5 mx-3">
                    @if ($type == 'post')
                        {{ fs_db_config('publish_post_name') }}
                    @endif
                    @if ($type == 'comment')
                        {{ fs_db_config('publish_comment_name') }}
                    @endif
                </button>
            </div>
        </div>
    </div>

    {{-- Draft Modal --}}
    <div class="modal fade" id="fresns-drafts" tabindex="-1" data-bs-backdrop="static" aria-labelledby="fresns-drafts" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_db_config('menu_editor_drafts') }}</h5>
                </div>

                {{-- Draft List --}}
                <div class="modal-body">
                    @component('components.editor.draft-list', [
                        'type' => $type,
                        'drafts' => $drafts,
                    ])@endcomponent
                </div>

                <div class="modal-footer">
                    <a class="btn btn-secondary" href="{{ fs_route(route('fresns.post.index')) }}" role="button">{{ fs_lang('return') }}</a>
                    <form action="{{ fs_route(route('fresns.editor.store', ['type' => $type])) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ fs_lang('editorDraftCreate') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            $(function (){
                var myModal = new bootstrap.Modal(document.getElementById('fresns-drafts'), {});
                myModal.show()
            })
        })(jQuery);
    </script>
@endpush
