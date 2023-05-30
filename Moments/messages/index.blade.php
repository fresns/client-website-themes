@extends('commons.fresns')

@section('title', fs_db_config('menu_conversations'))

@section('content')
    <div class="d-flex mx-3">
        <h1 class="fs-5 my-3">{{ fs_db_config('menu_conversations') }}</h1>
    </div>

    {{-- Conversation List --}}
    <div class="list-group rounded-0">
        @foreach($conversations as $conversation)
            @component('components.message.conversation', compact('conversation'))@endcomponent
        @endforeach
    </div>

    {{-- No Conversation --}}
    @if ($conversations->isEmpty())
        <div class="text-center my-5 text-muted fs-7" style="max-width:500px;">
            <i class="fa-regular fa-envelope-open"></i> {{ fs_lang('listEmpty') }}
        </div>
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center my-3">
        {{ $conversations->links() }}
    </div>
@endsection
