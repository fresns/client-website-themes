<a href="{{ fs_route(route('fresns.message.conversation', ['conversationId' => $conversation['id']])) }}" class="list-group-item list-group-item-action d-flex justify-content-between position-relative">
    @if ($conversation['userIsDeactivate'])
        <img src="{{ fs_db_config('deactivate_avatar') }}" class="conversation-avatar rounded-circle">
    @else
        <img src="{{ $conversation['user']['avatar'] }}" class="conversation-avatar rounded-circle">
    @endif

    <div class="flex-fill ms-2">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">
                @if ($conversation['userIsDeactivate'])
                    {{ fs_lang('contentCreatorDeactivate') }}
                @else
                    {{ $conversation['user']['nickname'] }}

                    @if($conversation['user']['verifiedStatus'])
                        @if ($conversation['user']['verifiedIcon'])
                            <img src="{{ $conversation['user']['verifiedIcon'] }}" class="conversation-user-verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $conversation['user']['verifiedDesc'] }}">
                        @else
                            <img src="/assets/themes/ThemeFrame/images/icon-verified.png" class="conversation-user-verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $conversation['user']['verifiedDesc'] }}">
                        @endif
                    @endif

                    <span class="conversation-user-name text-secondary">{{ '@' . $conversation['user']['username'] }}</span>
                @endif
            </h5>
            <small class="text-muted pt-1">{{ $conversation['latestMessage']['datetimeFormat'] }}</small>
        </div>

        {{-- Message --}}
        <div class="conversation-brief mt-1">
            @if ($conversation['latestMessage']['type'] == 1)
                {{ $conversation['latestMessage']['message'] }}
            @else
                {{ '['.$conversation['latestMessage']['message'].']' }}
            @endif
        </div>
    </div>

    {{-- Unread --}}
    @if ($conversation['unreadCount'] > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $conversation['unreadCount'] }}</span>
    @endif
</a>
