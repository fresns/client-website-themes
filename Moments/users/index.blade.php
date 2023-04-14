@extends('commons.fresns')

@section('title', fs_db_config('menu_user_title'))
@section('keywords', fs_db_config('menu_user_keywords'))
@section('description', fs_db_config('menu_user_description'))

@section('content')
    {{-- Navigation --}}
    @include('commons.discover-tabs')

    {{-- User List --}}
    <div class="clearfix border-top" @if (fs_db_config('menu_user_query_state') != 1) id="fresns-list-container" @endif>
        @foreach($users as $user)
            @component('components.user.list', compact('user'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    @if (fs_db_config('menu_user_query_state') != 1)
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $users->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
