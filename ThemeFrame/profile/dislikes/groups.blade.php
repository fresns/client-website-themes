@extends('profile.profile')

@section('list')
    {{-- List --}}
    <article class="py-4">
        @foreach($groups as $group)
            @component('components.group.list', compact('group'))@endcomponent
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach
    </article>

    {{-- Pagination --}}
    <div class="my-3">
        {{ $groups->links() }}
    </div>
@endsection
