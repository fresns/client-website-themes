@extends('commons.fresns')

@section('title', $code)

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">Fresns {{ $code }}</h3>
                    <p>{{ $message }}</p>
                    @if (fs_config('site_email'))
                        <p class="mt-4">Administrator Email: <a href="mailto:{{ fs_config('site_email') }}">{{ fs_config('site_email') }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
