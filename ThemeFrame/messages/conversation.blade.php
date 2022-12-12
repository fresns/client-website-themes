@extends('commons.fresns')

@section('title', fs_db_config('menu_conversations').' - '.$conversation['user']['nickname'])

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Conversation --}}
            <div class="col-sm-9">
                <div class="card">
                    {{-- User who conversation to me --}}
                    <div class="card-header">
                        @if ($conversation['userIsDeactivate'])
                            <img src="{{ fs_db_config('deactivate_avatar') }}" alt="{{ fs_lang('contentCreatorDeactivate') }}" class="rounded-circle conversation-avatar">
                            {{ fs_lang('contentCreatorDeactivate') }}
                        @else
                            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $conversation['user']['fsid']])) }}" target="_blank" class="text-decoration-none">
                                <img src="{{ $conversation['user']['avatar'] }}" alt="{{ $conversation['user']['nickname'] }}" class="rounded-circle conversation-avatar">
                                <span class="ms-2 fs-5">{{ $conversation['user']['nickname'] }}</span>
                                <span class="ms-2 conversation-user-name text-secondary">{{ '@'.$conversation['user']['username'] }}</span>
                            </a>
                        @endif
                    </div>

                    {{-- Message List --}}
                    <div class="card-body">
                        @php
                            $newMessages = array_reverse($messages->items());
                        @endphp

                        @foreach($newMessages as $message)
                            @component('components.message.message', compact('message'))@endcomponent
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $messages->links() }}
                        </div>
                    </div>

                    {{-- Send Box --}}
                    <div class="card-footer">
                        @component('components.message.send', [
                            'user' => $conversation['user'],
                        ])@endcomponent
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
