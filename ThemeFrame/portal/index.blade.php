@extends('commons.fresns')

@section('title', fs_config('menu_portal_title'))
@section('keywords', fs_config('menu_portal_keywords'))
@section('description', fs_config('menu_portal_description'))

@section('content')
    <div class="portal">
        {!! $content !!}
    </div>
@endsection
