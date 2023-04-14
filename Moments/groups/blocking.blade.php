@extends('commons.fresns')

@section('title', fs_db_config('menu_block_groups'))

@section('content')
    {{-- Navigation --}}
    @include('account.tabs-blocking')

    {{-- Group List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($groups as $group)
            @component('components.group.list', compact('group'))@endcomponent
        @endforeach
    </div>

    @if ($groups->isEmpty())
        {{-- No Group --}}
        <div class="text-center my-5 text-muted fs-7"><i class="fa-regular fa-newspaper"></i> {{ fs_lang('listEmpty') }}</div>
    @else
        {{-- Pagination --}}
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $groups->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
