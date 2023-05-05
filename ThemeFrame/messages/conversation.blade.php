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
                    {{-- Conversation User --}}
                    <div class="card-header">
                        @if ($conversation['user'])
                            <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $conversation['user']['fsid']])) }}" target="_blank" class="text-decoration-none">
                                <img src="{{ $conversation['user']['avatar'] }}" loading="lazy" alt="{{ $conversation['user']['nickname'] }}" class="rounded-circle conversation-avatar">
                                <span class="ms-2 fs-5">{{ $conversation['user']['nickname'] }}</span>
                                <span class="ms-2 conversation-user-name text-secondary">{{ '@'.$conversation['user']['fsid'] }}</span>
                            </a>
                        @else
                            <img src="{{ fs_db_config('deactivate_avatar') }}" loading="lazy" alt="{{ fs_lang('userDeactivate') }}" class="rounded-circle conversation-avatar">
                            {{ fs_lang('userDeactivate') }}
                        @endif
                    </div>

                    {{-- Messages --}}
                    <div class="card-body">
                        @foreach($messages as $message)
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
