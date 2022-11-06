@extends('commons.fresns')

@section('title', fs_api_config('menu_messages'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Dialog List --}}
            <div class="col-sm-9">

            </div>
        </div>
    </main>
@endsection
