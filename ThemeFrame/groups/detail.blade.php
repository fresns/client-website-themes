@extends('commons.fresns')

@section('title', $items['title'] ?? $group['gname'])
@section('keywords', $items['keywords'])
@section('description', $items['description'] ?? $group['description'])

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('groups.sidebar')
            </div>

            {{-- Middle --}}
            <div class="col-sm-6">
                <div class="card shadow-sm mb-3">
                    @component('components.group.detail', compact('group'))@endcomponent
                </div>

                {{-- Sticky Posts --}}
                @if (fs_sticky_posts($group['gid']))
                    <div class="list-group mb-3">
                        @foreach(fs_sticky_posts($group['gid']) as $sticky)
                            @component('components.post.sticky', compact('sticky'))@endcomponent
                        @endforeach
                    </div>
                @endif

                {{-- Post List --}}
                <div class="card clearfix">
                    {{-- Can View Content --}}
                    @if ($group['canViewContent'])
                        {{-- List --}}
                        @switch($type)
                            {{-- Post List --}}
                            @case('posts')
                                <div class="clearfix" id="fresns-list-container">
                                    @foreach($posts as $post)
                                        @component('components.post.list', compact('post'))@endcomponent

                                        @if (! $loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Pagination --}}
                                <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
                                    {{ $posts->links() }}
                                </div>
                            @break

                            {{-- Comment List --}}
                            @case('comments')
                                <div class="clearfix" id="fresns-list-container">
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
                                </div>

                                {{-- Pagination --}}
                                <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
                                    {{ $comments->links() }}
                                </div>
                            @break

                            @default
                                <div class="text-center my-5 text-muted fs-7">{{ fs_lang('listEmpty') }}</div>
                        @endswitch
                    @else
                        <div class="text-center py-5 text-danger">
                            <i class="bi bi-info-circle"></i> {{ fs_code_message('37103') }}
                        </div>
                    @endif
                </div>

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
