@extends('commons.fresns')

@section('title', fs_db_config('menu_post_title'))
@section('keywords', fs_db_config('menu_post_keywords'))
@section('description', fs_db_config('menu_post_description'))

@section('content')
    {{-- Navigation --}}
    @include('posts.tabs')

    {{-- Post List --}}
    <div class="clearfix border-top" @if (fs_db_config('menu_post_query_state') != 1) id="fresns-list-container" @endif>
        @foreach($posts as $post)
            @component('components.post.list', compact('post'))@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    @if (fs_db_config('menu_post_query_state') != 1)
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $posts->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
