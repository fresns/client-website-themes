@extends('commons.fresns')

@section('title', fs_db_config('menu_follow_users'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('users.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- User List --}}
                <article class="card clearfix">
                    @foreach($users as $user)
                        @component('components.user.list', compact('user'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                <div class="my-3 table-responsive">
                    {{ $users->links() }}
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
