@extends('commons.fresns')

@section('title', fs_db_config('menu_comment_title'))
@section('keywords', fs_db_config('menu_comment_keywords'))
@section('description', fs_db_config('menu_comment_description'))

@section('content')
    {{-- Navigation --}}
    @include('commons.discover-tabs')

    {{-- Comment List --}}
    <div class="clearfix border-top" @if (fs_db_config('menu_comment_query_state') != 1) id="fresns-list-container" @endif>
        @foreach($comments as $comment)
            @component('components.comment.list', [
                'comment' => $comment,
                'detailLink' => true,
                'sectionCreatorLiked' => false,
            ])@endcomponent
        @endforeach
    </div>

    {{-- Pagination --}}
    @if (fs_db_config('menu_comment_query_state') != 1)
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $comments->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
