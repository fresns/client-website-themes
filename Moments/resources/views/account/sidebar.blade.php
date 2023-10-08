<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_db_config('menu_account') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-signs-post"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- User Center --}}
        <a href="{{ fs_route(route('fresns.account.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.index') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/Moments/images/menu-account.png" loading="lazy" width="36" height="36">
            {{ fs_db_config('menu_account') }}
        </a>

        {{-- Notifications --}}
        <a href="{{ fs_route(route('fresns.notifications.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.notifications.index') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/Moments/images/menu-account-notifications.png" loading="lazy" width="36" height="36">
            {{ fs_db_config('menu_notifications') }}

            @if (fs_user_panel('unreadNotifications.all') > 0)
                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.all') }}</span>
            @endif
        </a>

        {{-- Conversations --}}
        @if (fs_api_config('conversation_status'))
            <a href="{{ fs_route(route('fresns.messages.index')) }}" class="list-group-item list-group-item-action {{ Route::is(['fresns.messages.index', 'fresns.messages.conversation']) ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/Moments/images/menu-account-conversations.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_conversations') }}

                @if (fs_user_panel('conversations.unreadMessages') > 0)
                    <span class="badge bg-danger">{{ fs_user_panel('conversations.unreadMessages') }}</span>
                @endif
            </a>
        @endif

        {{-- Draft Box --}}
        <a href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.editor.drafts') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/Moments/images/menu-account-drafts.png" loading="lazy" width="36" height="36">
            {{ fs_db_config('menu_editor_drafts') }}

            @if (array_sum(fs_user_panel('draftCount')) > 0)
                <span class="badge bg-primary">{{ array_sum(fs_user_panel('draftCount')) }}</span>
            @endif
        </a>

        {{-- Wallet --}}
        @if (fs_api_config('wallet_status'))
            <a href="{{ fs_route(route('fresns.account.wallet')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.wallet') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/Moments/images/menu-account-wallet.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_account_wallet') }}
            </a>
        @endif

        {{-- Users of this account --}}
        @if (fs_user_panel('multiUser.status') || count(fs_account('detail.users')) > 1)
            <a href="{{ fs_route(route('fresns.account.users')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.users') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/Moments/images/menu-account-users.png" loading="lazy" width="36" height="36">
                {{ fs_db_config('menu_account_users') }}
            </a>
        @endif

        {{-- Settings --}}
        <a href="{{ fs_route(route('fresns.account.settings')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.settings') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/Moments/images/menu-account-settings.png" loading="lazy" width="36" height="36">
            {{ fs_db_config('menu_account_settings') }}
        </a>
    </div>
</nav>
