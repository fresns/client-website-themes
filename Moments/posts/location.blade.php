@extends('commons.fresns')

@php
    $title = $location['poi'] ? $location['poi'].' - ' : '';
@endphp

@section('title', $title.fs_db_config('menu_location_posts'))

@section('content')
    <div class="d-flex justify-content-between mx-3 mt-3">
        <h1 class="fs-5">{{ fs_db_config('menu_location_posts') }}</h1>
    </div>

    {{-- Location Info --}}
    <div class="alert alert-primary mx-3" role="alert">
        <i class="fa-solid fa-map-location-dot"></i> {{ $location['poi'] ?? $location['latitude'].' / '.$location['longitude'] }}
    </div>

    {{-- Post List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($posts as $post)
            @component('components.post.list', compact('post'))@endcomponent
        @endforeach
    </div>

    @if ($posts->isEmpty())
        {{-- No Post --}}
        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-rectangle-list"></i> {{ fs_lang('listEmpty') }}</div>
    @else
        {{-- Pagination --}}
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $posts->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
