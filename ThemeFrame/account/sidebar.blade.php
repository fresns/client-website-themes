<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_api_config('menu_account') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-signpost-2"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- User Center --}}
        <a href="{{ fs_route(route('fresns.account.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.index') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account.png" width="36" height="36">
            {{ fs_api_config('menu_account') }}
        </a>

        {{-- Messages --}}
        <a href="{{ fs_route(route('fresns.message.notify', ['types' => 1])) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.message.notify') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-notifies.png" width="36" height="36">
            {{ fs_api_config('menu_notifies') }}

            @if(array_sum($userPanel['notifyUnread']) > 0)
                <span class="badge bg-danger">{{ array_sum($userPanel['notifyUnread']) }}</span>
            @endif
        </a>

        {{-- Dialogs --}}
        @if (fs_api_config('dialog_status'))
            <a href="{{ fs_route(route('fresns.message.index')) }}" class="list-group-item list-group-item-action {{ Route::is(['fresns.message.index', 'fresns.message.dialog']) ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-dialog.png" width="36" height="36">
                {{ fs_db_config('menu_dialogs') }}

                @if($userPanel['dialogUnread']['messages'] > 0)
                    <span class="badge bg-danger">{{ $userPanel['dialogUnread']['messages'] }}</span>
                @endif
            </a>
        @endif

        {{-- Draft Box --}}
        <a href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.editor.drafts') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-drafts.png" width="36" height="36">
            {{ fs_api_config('menu_editor_drafts') }}

            @if(array_sum($userPanel['draftCount']) > 0)
                <span class="badge bg-primary">{{ array_sum($userPanel['draftCount']) }}</span>
            @endif
        </a>

        {{-- Wallet --}}
        <a href="{{ fs_route(route('fresns.account.wallet')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.wallet') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-wallet.png" width="36" height="36">
            {{ fs_api_config('menu_account_wallet') }}
        </a>

        {{-- List of users belonging to the current account --}}
        @if (count(fs_account('detail.users')) > 1)
            <a href="{{ fs_route(route('fresns.account.users')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.users') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-users.png" width="36" height="36">
                {{ fs_api_config('menu_account_users') }}
            </a>
        @endif

        {{-- Settings --}}
        <a href="{{ fs_route(route('fresns.account.settings')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.account.settings') ? 'active' : '' }}">
            <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-account-settings.png" width="36" height="36">
            {{ fs_api_config('menu_account_settings') }}
        </a>
    </div>
</nav>
