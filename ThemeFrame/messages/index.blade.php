@extends('commons.fresns')

@section('title', fs_api_config('menu_conversations'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            <div class="col-sm-9">
                {{-- Notifications --}}
                <div class="row">
                    {{-- system notifications --}}
                    @if(in_array('systems', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 1])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_systems') }}
                                @if(fs_user_panel('unreadNotifications.systems') > 0)
                                    <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.systems') }}</span>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ fs_user_panel('unreadNotifications.systems') }}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- recommend notifications --}}
                    @if(in_array('recommends', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 2])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_recommends') }}
                                @if(fs_user_panel('unreadNotifications.recommends') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ fs_user_panel('unreadNotifications.recommends') }}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- like notifications --}}
                    @if(in_array('likes', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 3])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_likes') }}
                                @if(fs_user_panel('unreadNotifications.likes') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.likes')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- dislike notifications --}}
                    @if(in_array('dislikes', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 4])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_dislikes') }}
                                @if(fs_user_panel('unreadNotifications.dislikes') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.dislikes')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- follow notifications --}}
                    @if(in_array('follows', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 5])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_follows') }}
                                @if(fs_user_panel('unreadNotifications.follows') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.follows')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- block notifications --}}
                    @if(in_array('blocks', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 6])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_blocks') }}
                                @if(fs_user_panel('unreadNotifications.blocks') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.blocks')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- mention notifications --}}
                    @if(in_array('mentions', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 6])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_mentions') }}
                                @if(fs_user_panel('unreadNotifications.mentions') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.mentions')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    {{-- comment notifications --}}
                    @if(in_array('comments', fs_db_config('fs_theme_notifications', [])))
                        <div class="col mb-3">
                            <a href="{{ fs_route(route('fresns.message.notifications', ['types' => 6])) }}" class="btn btn-outline-secondary position-relative w-100" role="button">
                                {{ fs_api_config('menu_notifications_comments') }}
                                @if(fs_user_panel('unreadNotifications.comments') > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{fs_user_panel('unreadNotifications.comments')}}</span>
                                @endif
                            </a>
                        </div>
                    @endif
                </div>

                <hr>
                {{-- Conversation List --}}
                <div class="list-group mt-4 mx-auto" style="max-width:500px;">
                    @foreach($conversations as $conversation)
                        @component('components.message.conversation', compact('conversation'))@endcomponent
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center my-3">
                    {{ $conversations->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
