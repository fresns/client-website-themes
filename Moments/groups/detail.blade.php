@extends('commons.fresns')

@section('title', $items['title'] ?? $group['gname'])
@section('keywords', $items['keywords'])
@section('description', $items['description'] ?? $group['description'])

@section('content')
    <div class="bg-light shadow-sm py-3">
        @component('components.group.detail', compact('group'))@endcomponent
    </div>

    {{-- Sticky Posts --}}
    @if (fs_sticky_posts($group['gid']))
        <div class="list-group rounded-0 mb-3">
            @foreach(fs_sticky_posts($group['gid']) as $sticky)
                @component('components.post.sticky', compact('sticky'))@endcomponent
            @endforeach
        </div>
    @endif

    {{-- Post List --}}
    <div class="clearfix border-top">
        {{-- Can View Content --}}
        @if ($group['canViewContent'])
            {{-- List --}}
            @switch($type)
                {{-- Post List --}}
                @case('posts')
                    <div class="clearfix" id="fresns-list-container">
                        @foreach($posts as $post)
                            @component('components.post.list', compact('post'))@endcomponent
                        @endforeach
                    </div>

                    @if ($posts->isEmpty())
                        {{-- No Post --}}
                        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-rectangle-list"></i> {{ fs_lang('listEmpty') }}</div>
                    @else
                        {{-- Pagination --}}
                        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
                            {{ $posts->links() }}
                        </div>

                        {{-- Ajax Footer --}}
                        @include('commons.ajax-footer')
                    @endif
                @break

                {{-- Comment List --}}
                @case('comments')
                    <div class="clearfix" id="fresns-list-container">
                        @foreach($comments as $comment)
                            @component('components.comment.list', [
                                'comment' => $comment,
                                'detailLink' => true,
                                'sectionCreatorLiked' => false,
                            ])@endcomponent
                        @endforeach
                    </div>

                    @if ($comments->isEmpty())
                        {{-- No Comments --}}
                        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-comment-dots"></i> {{ fs_lang('listEmpty') }}</div>
                    @else
                        {{-- Pagination --}}
                        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
                            {{ $comments->links() }}
                        </div>

                        {{-- Ajax Footer --}}
                        @include('commons.ajax-footer')
                    @endif
                @break

                @default
                    <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-rectangle-list"></i> {{ fs_lang('listEmpty') }}</div>
            @endswitch
        @else
            <div class="text-center py-5 text-danger">
                <i class="fa-solid fa-circle-info"></i> {{ fs_code_message('37103') }}
            </div>
        @endif
    </div>
@endsection
