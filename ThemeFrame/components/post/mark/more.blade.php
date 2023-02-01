<ul class="dropdown-menu interaction-more" aria-labelledby="more">
    {{-- Edit --}}
    @if ($editStatus['isMe'] && $editStatus['canEdit'])
        <li>
            <a class="dropdown-item py-2 web-request-link" href="#" data-action="{{ fs_route(route('fresns.editor.store', ['type' => 'post', 'fsid' => $pid])) }}">
                <i class="bi bi-pencil-square"></i>
                {{ fs_lang('edit') }}
            </a>
        </li>
    @endif

    {{-- Delete --}}
    @if ($editStatus['isMe'] && $editStatus['canDelete'])
        <li>
            <a class="dropdown-item py-2 api-request-link" href="#" data-method="DELETE" data-id="{{ $pid }}" data-action="{{ route('fresns.api.content.delete',  ['type' => 'post', 'fsid' => $pid]) }}">
                <i class="bi bi-trash"></i>
                {{ fs_lang('delete') }}
            </a>
        </li>
    @endif

    {{-- Follow --}}
    @if ($interaction['followSetting'])
        <li>
            @component('components.post.mark.follow', [
                'pid' => $pid,
                'interaction' => $interaction,
                'count' => $followCount,
            ])@endcomponent
        </li>
    @endif

    {{-- Block --}}
    @if ($interaction['blockSetting'])
        <li>
            @component('components.post.mark.block', [
                'pid' => $pid,
                'interaction' => $interaction,
                'count' => $blockCount,
            ])@endcomponent
        </li>
    @endif

    {{-- Management Extensions --}}
    @if ($manages)
        @foreach($manages as $plugin)
            <li>
                <a class="dropdown-item py-2" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="post"
                    data-scene="manage"
                    data-post-message-key="fresnsPostManage"
                    data-pid="{{ $pid }}"
                    data-uid="{{ $uid }}"
                    data-title="{{ $plugin['name'] }}"
                    data-url="{{ $plugin['url'] }}">
                    @if ($plugin['icon'])
                        <img src="{{ $plugin['icon'] }}" width="20" height="20">
                    @endif
                    {{ $plugin['name'] }}
                </a>
            </li>
        @endforeach
    @endif
</ul>
