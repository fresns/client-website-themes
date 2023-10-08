<table class="table table-hover">
    <thead>
        <tr class="table-secondary">
            <th scope="col">ID</th>
            <th scope="col">{{ fs_lang('editorTitle') }}</th>
            <th scope="col" class="text-center" style="width:30%">{{ fs_lang('setting') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drafts as $draft)
            <tr id="{{ $draft['id'] }}">
                <th scope="row">{{ $draft['id'] }}</th>
                <td>
                    {{-- title --}}
                    @if ($draft['title'] ?? null)
                        {{ $draft['title'] }}
                    @else
                        {{ Str::limit($draft['content'], 80) }}
                    @endif

                    {{-- post --}}
                    @if ($draft['pid'] ?? null)
                        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $draft['pid']])) }}" target="_blank">
                            <span class="badge bg-info">{{ fs_lang('contentViewOriginal') }}: {{ $draft['pid'] }}</span>
                        </a>
                    @endif

                    {{-- comment --}}
                    @if ($draft['cid'] ?? null)
                        <a href="{{ fs_route(route('fresns.comment.detail', ['cid' => $draft['cid']])) }}" target="_blank">
                            <span class="badge bg-info">{{ fs_lang('contentViewOriginal') }}: {{ $draft['cid'] }}</span>
                        </a>
                    @endif

                    {{-- state --}}
                    @if ($draft['state'] == 2)
                        <span class="badge bg-success">{{ fs_lang('contentReviewPending') }}</span>
                    @endif
                    @if ($draft['state'] == 4)
                        <span class="badge bg-danger me-1">{{ fs_lang('contentReviewRejected') }}</span>
                        <span class="badge bg-secondary">{{ $draft['reason'] }}</span>
                    @endif
                </td>
                <td class="text-center">
                    @if ($draft['state'] == 1 || $draft['state'] == 4)
                        <a class="btn btn-outline-primary btn-sm" href="{{ fs_route(route('fresns.editor.edit', ['type' => $type, 'draftId' => $draft['id']])) }}" role="button">{{ fs_lang('edit') }}</a>
                        <a class="btn btn-link link-danger text-decoration-none api-request-link" href="#" data-method="DELETE" data-id="{{ $draft['id'] }}" data-action="{{ route('fresns.api.editor.delete', ['type' => $type, 'draftId' => $draft['id']]) }}">{{ fs_lang('delete') }}</a>
                    @elseif ($draft['state'] == 2)
                        <a class="btn btn-outline-success btn-sm api-request-link" href="#" data-method="PATCH" data-action="{{ route('fresns.api.editor.recall', ['type' => $type, 'draftId' => $draft['id']]) }}">{{ fs_lang('recall') }}</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
