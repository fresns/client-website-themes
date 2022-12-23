@extends('commons.fresns')

@section('title', $items['title'] ?? $post['title'] ?? Str::limit(strip_tags($post['content']), 40))
@section('keywords', $items['keywords'])
@section('description', $items['description'] ?? Str::limit(strip_tags($post['content']), 140))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('posts.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                <div class="card shadow-sm mb-4">
                    @component('components.post.detail', compact('post'))@endcomponent
                </div>

                <article class="card clearfix">
                    <div class="card-header">
                        <h5 class="mb-0">{{ fs_db_config('comment_name') }}</h5>
                    </div>

                    {{-- Sticky Comment List --}}
                    @if (fs_sticky_comments($post['pid']))
                        <div class="card-body bg-primary bg-opacity-10 mb-4">
                            @foreach(fs_sticky_comments($post['pid']) as $sticky)
                                @component('components.comment.sticky', [
                                    'sticky' => $sticky,
                                    'detailLink' => true,
                                    'sectionCreatorLiked' => true,
                                ])@endcomponent
                            @endforeach
                        </div>
                    @endif

                    {{-- Empty List --}}
                    @if ($comments->isEmpty())
                        <div class="text-center my-5 text-muted fs-7"><i class="bi bi-chat-square-text"></i> {{ fs_lang('listEmpty') }}</div>
                    @endif

                    {{-- Comment List --}}
                    @foreach($comments as $comment)
                        @component('components.comment.list', [
                            'comment' => $comment,
                            'detailLink' => true,
                            'sectionCreatorLiked' => true,
                        ])@endcomponent

                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach

                    {{-- Pagination --}}
                    <div class="my-3">
                        {{ $comments->links() }}
                    </div>
                </article>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
