@extends('commons.fresns')

@php
    $title = $geotag['name'] ? $geotag['name'].' - ' : '';
@endphp

@section('title', $title.fs_config('menu_location_comments'))

@section('content')
    <div class="d-flex mx-3">
        @desktop
            <span class="me-2" style="margin-top:11px;">
                <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
            </span>
        @enddesktop
        <h1 class="fs-5 my-3">{{ fs_config('menu_location_comments') }}</h1>
    </div>

    {{-- Location Info --}}
    <div class="alert alert-primary mx-3" role="alert">
        <i class="fa-solid fa-map-location-dot"></i> {{ $geotag['name'] ?? $geotag['latitude'].' / '.$geotag['longitude'] }}
    </div>

    {{-- Comment List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($comments as $comment)
            @component('components.comment.list', [
                'comment' => $comment,
                'detailLink' => true,
                'sectionAuthorLiked' => false,
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
