@extends('commons.fresns')

@section('title', $code)

@section('content')
    <div class="card m-3">
        <div class="card-body p-5">
            <h3 class="card-title">Fresns {{ $code }}</h3>
            <p>{{ $message }}</p>
            @if (fs_config('site_email'))
                <p class="mt-4">Administrator Email: <a href="mailto:{{ fs_config('site_email') }}">{{ fs_config('site_email') }}</a></p>
            @endif
        </div>
    </div>
@endsection
