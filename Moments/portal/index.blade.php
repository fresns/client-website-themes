@extends('commons.fresns')

@section('title', fs_config('channel_portal_seo')['title'])
@section('keywords', fs_config('channel_portal_seo')['keywords'])
@section('description', fs_config('channel_portal_seo')['description'])

@section('content')
    {{-- widget --}}
    <div>
        {!! fs_config('moments_widget_portal') !!}
    </div>

    {{-- portal --}}
    <div class="portal">
        {!! $content !!}
    </div>
@endsection
