@extends('commons.fresns')

@section('title', fs_db_config('menu_comment_title'))
@section('keywords', fs_db_config('menu_comment_keywords'))
@section('description', fs_db_config('menu_comment_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('comments.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Comment List --}}
                <article class="card clearfix">
                    @foreach($comments as $comment)
                        @component('components.comment.list', [
                            'comment' => $comment,
                            'detailLink' => true,
                            'sectionPost' => true,
                            'sectionPreview' => false,
                            'sectionCreatorLiked' => false,
                        ])@endcomponent

                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                @if (fs_db_config('menu_comment_query_state') != 1)
                    <div class="my-3">
                        {{ $comments->links() }}
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
