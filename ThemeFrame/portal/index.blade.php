@extends('commons.fresns')

@section('title', fs_config('channel_portal_seo')['title'] ?: fs_config('channel_portal_name'))
@section('keywords', fs_config('channel_portal_seo')['keywords'])
@section('description', fs_config('channel_portal_seo')['description'])

@section('content')
    <div class="portal">
        {!! $content !!}
    </div>
@endsection
