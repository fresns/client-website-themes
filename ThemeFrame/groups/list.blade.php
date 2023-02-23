@extends('commons.fresns')

@section('title', fs_db_config('menu_group_list_title'))
@section('keywords', fs_db_config('menu_group_list_keywords'))
@section('description', fs_db_config('menu_group_list_description'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('groups.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Group List --}}
                <article class="card clearfix py-4" @if (fs_db_config('menu_group_list_query_state') != 1) id="fresns-list-container" @endif>
                    @foreach($groups as $group)
                        @component('components.group.list', compact('group'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                @if (fs_db_config('menu_group_list_query_state') != 1)
                    <div class="my-3 table-responsive">
                        {{ $groups->links() }}
                    </div>
                @endif
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
