<div class="editor-group">
    <div class="d-grid">
        <button class="rounded-0 border-0 d-flex justify-content-between p-3" type="button" data-bs-toggle="modal" data-bs-target="#fresns-group">
            <span>
                <i class="bi bi-archive-fill me-2"></i>
                <span id="group">@if(!empty($group)) {{ $group['gname'] }} @else {{ fs_api_config('group_name') }}: {{ fs_lang('editorNoChooseGroup') }} @endif</span>
            </span>
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<div class="modal fade" id="fresns-group" tabindex="-1" aria-labelledby="fresns-group" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ fs_api_config('group_name') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Group Body --}}
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button type="button" id="not-select-group" class="btn btn-outline-secondary btn-sm mb-2 modal-close" data-bs-dismiss="modal" aria-label="Close">{{ fs_lang('editorNoGroup') }} {{ fs_api_config('group_name') }}</button>
                        {{-- Group Categories --}}
                        @foreach(fs_groups('categories') as $groupCategory)
                            <button class="nav-link group-categories" data-page-size=15 data-page=1 data-action="{{ route('fresns.api.group.list', ['gid' => $groupCategory['gid']]) }}" id="v-pills-{{ $groupCategory['gid'] }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $groupCategory['gid'] }}" type="button" role="tab" aria-controls="v-pills-{{ $groupCategory['gid'] }}" aria-selected="false">
                                @if ($groupCategory['cover'])
                                    <img src="{{ $groupCategory['cover'] }}" height="20">
                                @endif
                                {{ $groupCategory['gname'] }}
                            </button>
                        @endforeach
                    </div>

                    <div class="tab-content" id="v-pills-tabContent" style="width:70%;">
                        {{-- Group List --}}
                        @foreach(fs_groups('categories') as $groupCategory)
                            <div class="tab-pane fade" id="v-pills-{{ $groupCategory['gid'] }}" role="tabpanel" aria-labelledby="v-pills-{{ $groupCategory['gid'] }}-tab">
                                <div class="list-group"></div>
                                <div class="list-group-addmore text-center my-3"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Group Body End --}}
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        /**
         * @param obj
         */
        function selectGroup(obj) {
            let gid = $(obj).data('gid'),
                gname = $(obj).text();
            $('#fresns-group .modal-close').trigger('click');
            $('.fresns-editor .editor-group #group').text(gname);
            $(".fresns-editor input[name='postGid']").val(gid);
        }

        function ajaxGetGroupList(action, pageSize = 10, page = 1){
            let html = '';

            $('#v-pills-tabContent .tab-pane .list-group').append('<div class="text-center mt-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            $('#fresns-group .tab-pane.fade.active.show .list-group-addmore').empty().append("{{ fs_lang('loading') }}");

            $.get(action + "?page=" + page + "&pageSize=" + pageSize, function (data){
                let lists = data.list
                page = page + 1
                if (lists.length > 0) {
                    $.each(lists, function (i, list){
                        html += '<a href="javascript:void(0)" data-gid="'+ list.gid +'" onclick="selectGroup(this)" class="list-group-item list-group-item-action">';
                        if (list.cover) {
                            html += '<img src="' + list.cover + '" height="20" class="me-1">';
                        }
                        html += list.gname + '</a>'
                    });
                }
                if (data.paginate.currentPage === 1){
                    $('#fresns-group .list-group').each(function (){
                        $(this).empty();
                        $(this).next().empty();
                    });
                }

                $('#fresns-group .tab-pane.fade.active.show .list-group').append(html);

                $('#fresns-group .tab-pane.fade.active.show .list-group-addmore').empty();
                if (data.paginate.currentPage < data.paginate.lastPage) {
                    let addMoreHtml = `<a href="javascript:void(0)"  class="add-more" onclick="ajaxGetGroupList('${action}', ${pageSize}, ${page})">{{ fs_lang('clickToLoadMore') }}</a>`;
                    $('#fresns-group .tab-pane.fade.active.show .list-group-addmore').append(addMoreHtml);
                }

                $("#fresns-group .group-categories").each(function (){
                    $(this).attr('disabled', false)
                })
            })
        }

        $(function (){
            $("#fresns-group .group-categories").on('click', function (){
                let obj = $(this),
                    pageSize = obj.data('page-size'),
                    page = obj.data('page'),
                    action = obj.data('action')

                $("#fresns-group .group-categories").each(function (){
                    $(this).attr('disabled', true)
                })

                $('#fresns-group .list-group').each(function (){
                    $(this).empty();
                    $(this).next().empty();
                });
                ajaxGetGroupList(action, pageSize, page)
            })

            $("#not-select-group").on('click', function (){
                $('.fresns-editor .editor-group #group').text("{{ fs_lang('editorNoChooseGroup') }}");
                $(".fresns-editor input[name='postGid']").val("");
            })
        })
    </script>
@endpush
