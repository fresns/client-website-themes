@extends('commons.fresns')

@section('title', fs_api_config('menu_account'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Account Content --}}
            <div class="col-sm-9">

            </div>
        </div>
    </main>
@endsection
