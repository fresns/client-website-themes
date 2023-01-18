@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
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
    </article>

    {{-- Pagination --}}
    <div class="my-3 table-responsive">
        {{ $comments->links() }}
    </div>
@endsection
