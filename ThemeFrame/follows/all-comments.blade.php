@extends('commons.fresns')

@section('title', fs_db_config('menu_follow_all_comments'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Comment List --}}
                <article class="card clearfix">
                    @foreach($comments as $comment)
                        @component('components.comment.list', [
                            'detailLink' => true,
                            'sectionPost' => true,
                            'sectionPreviews' => false,
                            'sectionCreatorLiked' => false,
                            'comment' => $comment,
                        ])@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                <div class="my-3">
                    {{ $comments->links() }}
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
