@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
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
    <div class="my-3">
        {{ $comments->links() }}
    </div>
@endsection
