@extends('commons.fresns')

@section('title', fs_db_config('menu_hashtag_title'))
@section('keywords', fs_db_config('menu_hashtag_keywords'))
@section('description', fs_db_config('menu_hashtag_description'))

@section('content')
    {{-- Navigation --}}
    @include('commons.discover-tabs')

    {{-- Hashtag List --}}
    <div class="clearfix border-top" @if (fs_db_config('menu_hashtag_query_state') != 1) id="fresns-list-container" @endif>
        @foreach($hashtags as $hashtag)
            @component('components.hashtag.list', compact('hashtag'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    @if (fs_db_config('menu_hashtag_query_state') != 1)
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $hashtags->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
