@extends('commons.fresns')

@section('title', $items['title'] ?? $profile['nickname'])
@section('keywords', $items['keywords'])
@section('description', $items['description'] ?? $profile['bio'])

@section('content')
    <main class="row justify-content-md-center">
        <div class="col-md-6 card" style="margin-top: 88px">
            <header class="profile-header text-center">
                @component('components.user.detail', compact('profile'))@endcomponent
            </header>

            <div class="card-header" style="margin-left:-0.8rem;margin-right:-0.8rem">
                @include('profile.navbar')
            </div>

            <div class="profile-list">
                @yield('list')
            </div>
        </div>
    </main>
@endsection
