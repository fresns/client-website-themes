@extends('commons.fresns')

@section('title', fs_db_config('menu_post_title'))
@section('keywords', fs_db_config('menu_post_keywords'))
@section('description', fs_db_config('menu_post_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Sticky Post List --}}
                <div class="list-group mb-4">
                    @foreach($stickies as $sticky)
                        @component('components.post.sticky', compact('sticky'))@endcomponent
                    @endforeach
                </div>

                {{-- Post List --}}
                <article class="card clearfix">
                    @foreach($posts as $post)
                        @component('components.post.list', compact('post'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                @if (fs_api_config('menu_post_query_state') != 1)
                    <div class="my-3">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
