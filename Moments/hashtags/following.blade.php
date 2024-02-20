@extends('commons.fresns')

@section('title', fs_config('menu_follow_hashtags'))

@section('content')
    {{-- Navigation --}}
    @include('account.tabs-following')

    {{-- Hashtag List --}}
    <div class="clearfix border-top" id="fresns-list-container">
        @foreach($hashtags as $hashtag)
            @component('components.hashtag.list', compact('hashtag'))@endcomponent
        @endforeach
    </div>

    @if ($hashtags->isEmpty())
        {{-- No Hashtag --}}
        <div class="text-center my-5 text-muted fs-7"><i class="fa-solid fa-hashtag"></i> {{ fs_lang('listEmpty') }}</div>
    @else
        {{-- Pagination --}}
        <div class="px-3 me-3 me-lg-0 mt-4 table-responsive d-none">
            {{ $hashtags->links() }}
        </div>

        {{-- Ajax Footer --}}
        @include('commons.ajax-footer')
    @endif
@endsection
