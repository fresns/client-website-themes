@if ($followType == 1)
    <form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
        @csrf
        <input type="hidden" name="interactiveType" value="follow"/>
        <input type="hidden" name="markType" value="group"/>
        <input type="hidden" name="fsid" value="{{ $gid }}"/>
        @if ($interactive['followStatus'])
            <a class="btn btn-success btn-sm fs-mark" data-interactive-active="{{ $interactive['followStatus'] }}" data-bi="bi-person-check">
                <i class="bi bi-person-check-fill"></i>
                @if (fs_api_config('group_follower_count'))
                    <span class="show-count">{{ $count }}</span>
                @endif
            </a>
        @else
            <a class="btn btn-outline-success btn-sm fs-mark" data-bi="bi-person-check-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interactive['followName'] }}">
                <i class="bi bi-person-check"></i>
                @if (fs_api_config('group_follower_count'))
                    <span class="show-count">{{ $count }}</span>
                @endif
            </a>
        @endif
    </form>
@elseif ($followType == 2)
    @if (! $interactive['followStatus'])
        <form class="float-start me-2">
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                data-lang-tag="{{ current_lang_tag() }}"
                data-type="group"
                data-scene="follow"
                data-post-message-key="fresnsFollow"
                data-gid="{{ $gid }}"
                data-title="{{ $interactive['followName'] }}: {{ $gname }}"
                data-url="{{ $followUrl }}">
                <i class="bi bi-person-check"></i>
                {{ $interactive['followName'] }}
                @if (fs_api_config('group_follower_count'))
                    <span class="badge rounded-pill bg-success">{{ $count }}</span>
                @endif
            </button>
        </form>
    @endif
@endif
