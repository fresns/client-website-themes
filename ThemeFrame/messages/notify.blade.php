@extends('commons.fresns')

@section('title', fs_api_config('menu_notifies'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- notifies --}}
            <div class="col-sm-9">
                <div class="card">
                    {{-- Menus --}}
                    @if(fs_db_config('fs_theme_notifies', []))
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                {{-- system notify --}}
                                @if(in_array('systems', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 1) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 1])) }}">
                                            {{ fs_api_config('menu_notify_systems') }}
                                            @if($userPanel['notifyUnread']['systems'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['systems'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- recommend notify --}}
                                @if(in_array('recommends', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 2) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 2])) }}">
                                            {{ fs_api_config('menu_notify_recommends') }}
                                            @if($userPanel['notifyUnread']['recommends'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['recommends'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- like notify --}}
                                @if(in_array('likes', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 3) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 3])) }}">
                                            {{ fs_api_config('menu_notify_likes') }}
                                            @if($userPanel['notifyUnread']['likes'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['likes'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- dislike notify --}}
                                @if(in_array('dislikes', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 4) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 4])) }}">
                                            {{ fs_api_config('menu_notify_dislikes') }}
                                            @if($userPanel['notifyUnread']['dislikes'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['dislikes'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- follow notify --}}
                                @if(in_array('follows', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 5) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 5])) }}">
                                            {{ fs_api_config('menu_notify_follows') }}
                                            @if($userPanel['notifyUnread']['follows'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['follows'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- block notify --}}
                                @if(in_array('blocks', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 6) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 6])) }}">
                                            {{ fs_api_config('menu_notify_blocks') }}
                                            @if($userPanel['notifyUnread']['blocks'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['blocks'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- mention notify --}}
                                @if(in_array('mentions', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 7) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 7])) }}">
                                            {{ fs_api_config('menu_notify_mentions') }}
                                            @if($userPanel['notifyUnread']['mentions'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['mentions'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- comment notify --}}
                                @if(in_array('comments', fs_db_config('fs_theme_notifies', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 8) active @endif" href="{{ fs_route(route('fresns.message.notify', ['types' => 8])) }}">
                                            {{ fs_api_config('menu_notify_comments') }}
                                            @if($userPanel['notifyUnread']['comments'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['notifyUnread']['comments'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    {{-- Notify Content List --}}
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            {{-- Mark all as read --}}
                            @if ($notifies->isNotEmpty())
                                <li class="list-group-item d-flex justify-content-center align-items-center pb-3">
                                    <form action="{{ route('fresns.api.message.mark.as.read', ['type' => 'notify']) }}" method="put">
                                        @csrf
                                        <input type="hidden" name="type" value="all"/>
                                        <input type="hidden" name="notifyType" value="{{ $types }}"/>
                                        <input type="hidden" name="notifyIds" value=""/>
                                        <a class="btn btn-success btn-sm api-request-form" href="#">{{ fs_lang('notifyMarkAllAsRead') }}</a>
                                    </form>
                                </li>
                            @endif

                            {{-- List --}}
                            @foreach($notifies as $notify)
                                @component('components.message.notify', compact('notify'))@endcomponent
                            @endforeach
                        </ul>

                        <div class="my-3">
                            {{ $notifies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
