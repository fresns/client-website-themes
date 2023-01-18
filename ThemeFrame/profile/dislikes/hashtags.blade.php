@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
        @foreach($hashtags as $hashtag)
            @component('components.hashtag.list', compact('hashtag'))@endcomponent
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach
    </article>

    {{-- Pagination --}}
    <div class="my-3 table-responsive">
        {{ $hashtags->links() }}
    </div>
@endsection
