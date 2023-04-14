@extends('commons.fresns')

@section('title', fs_db_config('menu_hashtag_title'))
@section('keywords', fs_db_config('menu_hashtag_keywords'))
@section('description', fs_db_config('menu_hashtag_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('hashtags.sidebar')
            </div>

            {{-- Middle --}}
            <div class="col-sm-6">
                {{-- Hashtag List --}}
                <article class="card clearfix py-4" @if (fs_db_config('menu_hashtag_query_state') != 1) id="fresns-list-container" @endif>
                    @foreach($hashtags as $hashtag)
                        @component('components.hashtag.list', compact('hashtag'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                @if (fs_db_config('menu_hashtag_query_state') != 1)
                    <div class="my-3 table-responsive">
                        {{ $hashtags->links() }}
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
