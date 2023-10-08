@extends('commons.fresns')

@section('title', $code)

@php
    use App\Helpers\ConfigHelper;

    $email = ConfigHelper::fresnsConfigByItemKey('site_email');
@endphp

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">Fresns {{ $code }}</h3>
                    <p>{{ $message }}</p>
                    @if ($email)
                        <p class="mt-4">Administrator Email: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
