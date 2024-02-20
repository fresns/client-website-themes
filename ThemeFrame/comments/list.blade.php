@extends('commons.fresns')

@section('title', fs_config('menu_comment_list_title'))
@section('keywords', fs_config('menu_comment_list_keywords'))
@section('description', fs_config('menu_comment_list_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('comments.sidebar')
            </div>

            {{-- Middle --}}
            <div class="col-sm-6">
                {{-- Comment List --}}
                <article class="card clearfix" @if (fs_config('menu_comment_list_query_state') != 1) id="fresns-list-container" @endif>
                    @foreach($comments as $comment)
                        @component('components.comment.list', [
                            'comment' => $comment,
                            'detailLink' => true,
                            'sectionAuthorLiked' => false,
                        ])@endcomponent

                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                @if (fs_config('menu_comment_list_query_state') != 1)
                    <div class="my-3 table-responsive">
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
