@extends('commons.fresns')

@section('title', fs_config('menu_dislike_users'))

@section('content')
    {{-- Navigation --}}
    @include('account.tabs-dislikes')

    {{-- List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($users as $user)
            @component('components.user.list', compact('user'))@endcomponent
        @endforeach
    </div>

    @if ($users->isEmpty())
        {{-- No User --}}
        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-user"></i> {{ fs_lang('listEmpty') }}</div>
    @else
        {{-- Pagination --}}
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $users->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
