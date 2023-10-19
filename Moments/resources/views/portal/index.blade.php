@extends('commons.fresns')

@section('title', fs_db_config('menu_portal_title'))
@section('keywords', fs_db_config('menu_portal_keywords'))
@section('description', fs_db_config('menu_portal_description'))

@section('content')
    {{-- widget --}}
    <div>
        {!! fs_db_config('moments_widget_portal') !!}
    </div>

    {{-- portal --}}
    <div class="portal">
        {!! $content !!}
    </div>
@endsection
