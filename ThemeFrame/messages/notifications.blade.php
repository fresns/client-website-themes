@extends('commons.fresns')

@section('title', fs_api_config('menu_notifications'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Notification List --}}
            <div class="col-sm-9">
                <div class="card">
                    {{-- Menus --}}
                    @if(fs_db_config('fs_theme_notifications', []))
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                {{-- all notifications --}}
                                <li class="nav-item">
                                    <a class="nav-link @if(empty($types)) active @endif" href="{{ fs_route(route('fresns.message.notifications')) }}">
                                        {{ fs_api_config('menu_notifications_all') }}
                                        @if(array_sum($userPanel['unreadNotifications']) > 0)
                                            <span class="badge bg-danger">{{ array_sum($userPanel['unreadNotifications']) }}</span>
                                        @endif
                                    </a>
                                </li>

                                {{-- system notifications --}}
                                @if(in_array('systems', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 1) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 1])) }}">
                                            {{ fs_api_config('menu_notifications_systems') }}
                                            @if($userPanel['unreadNotifications']['systems'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['systems'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- recommend notifications --}}
                                @if(in_array('recommends', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 2) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 2])) }}">
                                            {{ fs_api_config('menu_notifications_recommends') }}
                                            @if($userPanel['unreadNotifications']['recommends'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['recommends'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- like notifications --}}
                                @if(in_array('likes', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 3) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 3])) }}">
                                            {{ fs_api_config('menu_notifications_likes') }}
                                            @if($userPanel['unreadNotifications']['likes'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['likes'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- dislike notifications --}}
                                @if(in_array('dislikes', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 4) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 4])) }}">
                                            {{ fs_api_config('menu_notifications_dislikes') }}
                                            @if($userPanel['unreadNotifications']['dislikes'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['dislikes'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- follow notifications --}}
                                @if(in_array('follows', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 5) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 5])) }}">
                                            {{ fs_api_config('menu_notifications_follows') }}
                                            @if($userPanel['unreadNotifications']['follows'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['follows'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- block notifications --}}
                                @if(in_array('blocks', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 6) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 6])) }}">
                                            {{ fs_api_config('menu_notifications_blocks') }}
                                            @if($userPanel['unreadNotifications']['blocks'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['blocks'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- mention notifications --}}
                                @if(in_array('mentions', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 7) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 7])) }}">
                                            {{ fs_api_config('menu_notifications_mentions') }}
                                            @if($userPanel['unreadNotifications']['mentions'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['mentions'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- comment notifications --}}
                                @if(in_array('comments', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 8) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 8])) }}">
                                            {{ fs_api_config('menu_notifications_comments') }}
                                            @if($userPanel['unreadNotifications']['comments'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['unreadNotifications']['comments'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    {{-- Notifications --}}
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            {{-- No Notification --}}
                            @if ($notifications->isEmpty())
                                <li class="list-group-item text-center my-5 text-muted fs-7"><i class="bi bi-chat-square"></i> {{ fs_lang('notificationEmpty') }}</li>
                            @endif

                            {{-- Mark all as read --}}
                            @if ($notifications->isNotEmpty() && $types)
                                <li class="list-group-item d-flex justify-content-center align-items-center pb-3">
                                    <form action="{{ route('fresns.api.message.mark.as.read', ['type' => 'notification']) }}" method="put">
                                        @csrf
                                        <input type="hidden" name="type" value="all"/>
                                        <input type="hidden" name="notificationType" value="{{ $types }}"/>
                                        <input type="hidden" name="notificationIds" value=""/>
                                        <button class="btn btn-success btn-sm api-request-form" type="button">{{ fs_lang('notificationMarkAllAsRead') }}</button>
                                    </form>
                                </li>
                            @endif

                            {{-- Notification List --}}
                            @foreach($notifications as $notification)
                                @component('components.message.notification', compact('notification'))@endcomponent
                            @endforeach
                        </ul>

                        <div class="my-3">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
