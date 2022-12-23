@extends('commons.fresns')

@php
    $title = $archive['location']['poi'] ? $archive['location']['poi'].' - ' : '';
@endphp

@if ($type == 'posts')
    @section('title', $title.fs_db_config('menu_location_posts'))
@else
    @section('title', $title.fs_db_config('menu_location_comments'))
@endif

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Location Info --}}
                <div class="alert alert-primary" role="alert">
                    <i class="bi bi-geo-alt-fill"></i> {{ $archive['location']['poi'] ?? $archive['location']['latitude'].' / '.$archive['location']['longitude'] }}
                </div>

                {{-- List --}}
                <article class="card clearfix">
                    @if ($type == 'posts')
                        {{-- Post List --}}
                        @foreach($posts as $post)
                            @component('components.post.list', compact('post'))@endcomponent
                            @if (! $loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @else
                        {{-- Comment List --}}
                        @foreach($comments as $comment)
                            @component('components.comment.list', [
                                'comment' => $comment,
                                'detailLink' => true,
                                'sectionCreatorLiked' => false,
                            ])@endcomponent

                            @if (! $loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @endif
                </article>

                {{-- Pagination --}}
                <div class="my-3">
                    @if ($type == 'posts')
                        {{ $posts->links() }}
                    @else
                        {{ $comments->links() }}
                    @endif
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
