@extends('commons.fresns')

@php
    $title = $location['poi'] ? $location['poi'].' - ' : '';
@endphp

@section('title', $title.fs_db_config('menu_location_comments'))

@section('content')
    <div class="d-flex justify-content-between mx-3 mt-3">
        <h1 class="fs-5">{{ fs_db_config('menu_location_comments') }}</h1>
    </div>

    {{-- Location Info --}}
    <div class="alert alert-primary mx-3" role="alert">
        <i class="fa-solid fa-map-location-dot"></i> {{ $location['poi'] ?? $location['latitude'].' / '.$location['longitude'] }}
    </div>

    {{-- Comment List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($comments as $comment)
            @component('components.comment.list', [
                'comment' => $comment,
                'detailLink' => true,
                'sectionCreatorLiked' => false,
            ])@endcomponent
        @endforeach
    </div>

    @if ($comments->isEmpty())
        {{-- No Comments --}}
        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-comment-dots"></i> {{ fs_lang('listEmpty') }}</div>
    @else
        {{-- Pagination --}}
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $comments->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
