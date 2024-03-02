@extends('commons.fresns')

@section('title', fs_config('channel_search_name'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('search.sidebar')
            </div>

            {{-- Middle --}}
            <div class="col-sm-6">
                {{-- List --}}
                <article class="card clearfix">
                </article>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
