@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
        @foreach($users as $user)
            @component('components.user.list', compact('user'))@endcomponent
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach
    </article>

    {{-- Pagination --}}
    <div class="my-3">
        {{ $users->links() }}
    </div>
@endsection
