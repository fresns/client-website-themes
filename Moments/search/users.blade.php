@extends('commons.fresns')

@section('title', fs_db_config('menu_search').': '.fs_db_config('user_name'))

@section('content')
    <div class="d-flex mx-3">
        @desktop
            <span class="me-2" style="margin-top:11px;">
                <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
            </span>
        @enddesktop
        <h1 class="fs-5 my-3">
            {{ fs_db_config('menu_search') }}: {{ fs_db_config('user_name') }}
            <span class="badge bg-secondary ms-3">{{ request('searchKey') }}</span>
        </h1>
    </div>

    {{-- Search Results --}}
    <div class="clearfix border-top">
        @foreach($users as $user)
            @component('components.user.list', compact('user'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
        {{ $users->links() }}
    </div>
@endsection
