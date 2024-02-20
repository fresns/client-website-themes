<ul class="nav nav-tabs card-header-tabs">
    {{-- posts --}}
    @if (fs_config('it_posts'))
        <li class="nav-item">
            <a class="nav-link {{ Route::is('fresns.profile.posts') ? 'active' : '' }}"href="{{ fs_route(route('fresns.profile.posts', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('post_name') }}</a>
        </li>
    @endif

    {{-- comments --}}
    @if (fs_config('it_comments'))
        <li class="nav-item">
            <a class="nav-link {{ Route::is('fresns.profile.comments') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.comments', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('comment_name') }}</a>
        </li>
    @endif

    {{-- interaction --}}
    @if (fs_config('user_likers') && fs_config('user_dislikers') && fs_config('user_followers') && fs_config('user_blockers'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is([
                'fresns.profile.likers',
                'fresns.profile.dislikers',
                'fresns.profile.followers',
                'fresns.profile.blockers',
                'fresns.profile.followers.you.follow',
            ]) ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-users.png" loading="lazy" width="24" height="24">
            </a>
            <ul class="dropdown-menu">
                @if (fs_config('user_likers'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likers') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likers', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_likes') }}</a></li>
                @endif
                @if (fs_config('user_dislikers'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikers') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikers', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislikes') }}</a></li>
                @endif
                @if (fs_config('user_followers'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.followers') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.followers', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_followers') }}</a></li>
                @endif
                @if (fs_config('user_blockers'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blockers') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blockers', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_blockers') }}</a></li>
                @endif
                @if (fs_config('it_followers_you_follow'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.followers.you.follow') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.followers.you.follow', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_followers_you_follow') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- likes --}}
    @if (fs_config('it_like_users') && fs_config('it_like_groups') && fs_config('it_like_hashtags') && fs_config('it_like_posts') && fs_config('it_like_comments'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is('fresns.profile.likes.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-likes.png" loading="lazy" width="24" height="24">
            </a>
            <ul class="dropdown-menu">
                @if (fs_config('it_like_users'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likes.users') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likes.users', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_like_users') }}</a></li>
                @endif
                @if (fs_config('it_like_groups'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likes.groups') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likes.groups', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_like_groups') }}</a></li>
                @endif
                @if (fs_config('it_like_hashtags'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likes.hashtags') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likes.hashtags', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_like_hashtags') }}</a></li>
                @endif
                @if (fs_config('it_like_posts'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likes.posts') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likes.posts', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_like_posts') }}</a></li>
                @endif
                @if (fs_config('it_like_comments'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.likes.comments') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.likes.comments', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_like_comments') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- dislikes --}}
    @if (fs_config('it_dislike_users') && fs_config('it_dislike_groups') && fs_config('it_dislike_hashtags') && fs_config('it_dislike_posts') && fs_config('it_dislike_comments'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is('fresns.profile.dislikes.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-dislikes.png" loading="lazy" width="24" height="24">
            </a>
            <ul class="dropdown-menu">
                @if (fs_config('it_dislike_users'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikes.users') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikes.users', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislike_users') }}</a></li>
                @endif
                @if (fs_config('it_dislike_groups'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikes.groups') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikes.groups', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislike_groups') }}</a></li>
                @endif
                @if (fs_config('it_dislike_hashtags'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikes.hashtags') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikes.hashtags', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislike_hashtags') }}</a></li>
                @endif
                @if (fs_config('it_dislike_posts'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikes.posts') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikes.posts', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislike_posts') }}</a></li>
                @endif
                @if (fs_config('it_dislike_comments'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.dislikes.comments') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.dislikes.comments', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_dislike_comments') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- following --}}
    @if (fs_config('it_follow_users') && fs_config('it_follow_groups') && fs_config('it_follow_hashtags') && fs_config('it_follow_posts') && fs_config('it_follow_comments'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is('fresns.profile.following.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-following.png" loading="lazy" width="24" height="24">
            </a>
            <ul class="dropdown-menu">
                @if (fs_config('it_follow_users'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.following.users') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.following.users', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_follow_users') }}</a></li>
                @endif
                @if (fs_config('it_follow_groups'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.following.groups') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.following.groups', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_follow_groups') }}</a></li>
                @endif
                @if (fs_config('it_follow_hashtags'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.following.hashtags') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.following.hashtags', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_follow_hashtags') }}</a></li>
                @endif
                @if (fs_config('it_follow_posts'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.following.posts') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.following.posts', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_follow_posts') }}</a></li>
                @endif
                @if (fs_config('it_follow_comments'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.following.comments') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.following.comments', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_follow_comments') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- blocking --}}
    @if (fs_config('it_block_users') && fs_config('it_block_groups') && fs_config('it_block_hashtags') && fs_config('it_block_posts') && fs_config('it_block_comments'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is('fresns.profile.blocking.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-fluid" src="/assets/WebFrame/images/menu-blocking.png" loading="lazy" width="24" height="24">
            </a>
            <ul class="dropdown-menu">
                @if (fs_config('it_block_users'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blocking.users') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blocking.users', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_block_users') }}</a></li>
                @endif
                @if (fs_config('it_block_groups'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blocking.groups') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blocking.groups', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_block_groups') }}</a></li>
                @endif
                @if (fs_config('it_block_hashtags'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blocking.hashtags') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blocking.hashtags', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_block_hashtags') }}</a></li>
                @endif
                @if (fs_config('it_block_posts'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blocking.posts') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blocking.posts', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_block_posts') }}</a></li>
                @endif
                @if (fs_config('it_block_comments'))
                    <li><a class="dropdown-item {{ Route::is('fresns.profile.blocking.comments') ? 'active' : '' }}" href="{{ fs_route(route('fresns.profile.blocking.comments', ['uidOrUsername' => $profile['fsid']])) }}">{{ fs_config('menu_profile_block_comments') }}</a></li>
                @endif
            </ul>
        </li>
    @endif
</ul>
