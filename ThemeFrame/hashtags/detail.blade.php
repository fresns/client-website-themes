@extends('commons.fresns')

@section('title', $items['title'] ?? $hashtag['hname'])
@section('keywords', $items['keywords'])
@section('description', $items['description'] ?? $hashtag['description'])

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('hashtags.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                <div class="card shadow-sm mb-3">
                    @component('components.hashtag.detail', compact('hashtag'))@endcomponent
                </div>

                {{-- Post List --}}
                <article class="card clearfix" id="fresns-list-container">
                    @foreach($posts as $post)
                        @component('components.post.list', compact('post'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                <div class="my-3 table-responsive">
                    {{ $posts->links() }}
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
