@extends('commons.fresns')

@section('title', fs_db_config('menu_search').': '.fs_db_config('hashtag_name'))

@section('content')
    <div class="d-flex justify-content-between mx-3 mt-3">
        <h1 class="fs-5">
            {{ fs_db_config('menu_search') }}: {{ fs_db_config('hashtag_name') }}
            <span class="badge bg-secondary ms-3">{{ request('searchKey') }}</span>
        </h1>
    </div>

    {{-- Search Results --}}
    <div class="clearfix border-top">
        @foreach($hashtags as $hashtag)
            @component('components.hashtag.list', compact('hashtag'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
        {{ $hashtags->links() }}
    </div>
@endsection
