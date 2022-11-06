@extends('commons.fresns')

@section('title', fs_db_config('menu_group_title'))
@section('keywords', fs_db_config('menu_group_keywords'))
@section('description', fs_db_config('menu_group_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('groups.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                @if (fs_db_config('menu_group_type') == 'tree')
                    {{-- Group Tree Structure List --}}
                    @foreach($groupTree ?? [] as $tree)
                        <h3 class="fs-5">{{ $tree['gname'] }}</h3>
                        <div class="card mb-5 py-4">
                            @foreach($tree['groups'] ?? [] as $group)
                                @component('components.group.list', compact('group'))@endcomponent
                                @if (! $loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                @else
                    {{-- Group List --}}
                    <div class="card mb-5 py-4">
                        @foreach($groups ?? [] as $group)
                            @component('components.group.list', compact('group'))@endcomponent
                            @if (! $loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if (fs_api_config('menu_group_query_state') != 1)
                        <div class="my-3">
                            {{ $groups->links() }}
                        </div>
                    @endif
                @endif
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
