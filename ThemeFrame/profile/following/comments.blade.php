@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
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
@endsection
