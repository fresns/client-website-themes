@extends('commons.fresns')

@section('title', fs_config('menu_conversations').' - '.$conversation['user']['nickname'])

@section('content')
    @desktop
        <div class="d-flex mx-3">
                <span class="me-2" style="margin-top:11px;">
                    <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
                </span>
                <h1 class="fs-5 my-3">{{ fs_config('menu_conversations') }}</h1>
        </div>
    @enddesktop

    <div class="card border-0">
        {{-- Conversation User --}}
        <div class="card-header">
            @if ($conversation['user']['status'])
                <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $conversation['user']['fsid']])) }}" target="_blank" class="text-decoration-none">
                    <img src="{{ $conversation['user']['avatar'] }}" loading="lazy" alt="{{ $conversation['user']['nickname'] }}" class="rounded-circle conversation-avatar">
                    <span class="ms-2 fs-5">{{ $conversation['user']['nickname'] }}</span>
                    <span class="ms-2 conversation-user-name text-secondary">{{ '@'.$conversation['user']['username'] }}</span>
                </a>
            @else
                <img src="{{ fs_config('deactivate_avatar') }}" loading="lazy" alt="{{ fs_lang('userDeactivate') }}" class="rounded-circle conversation-avatar">
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
@endsection
