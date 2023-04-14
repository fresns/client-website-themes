@extends('commons.fresns')

@section('title', fs_db_config('menu_group_list_title'))
@section('keywords', fs_db_config('menu_group_list_keywords'))
@section('description', fs_db_config('menu_group_list_description'))

@section('content')
    <div class="d-flex justify-content-between mx-3 mt-3">
        <h1 class="fs-5">{{ fs_db_config('menu_group_list_name') }}</h1>
    </div>

    {{-- Group List --}}
    <div class="clearfix border-top" @if (fs_db_config('menu_group_list_query_state') != 1) id="fresns-list-container" @endif>
        @foreach($groups ?? [] as $group)
            @component('components.group.list', compact('group'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    @if (fs_db_config('menu_group_list_query_state') != 1)
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $groups->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
