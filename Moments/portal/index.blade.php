@extends('commons.fresns')

@section('title', fs_db_config('menu_portal_title'))
@section('keywords', fs_db_config('menu_portal_keywords'))
@section('description', fs_db_config('menu_portal_description'))

@section('content')
    <div class="portal">
        {!! $content !!}
    </div>
@endsection

@push('script')
    <script src="/static/js/masonry.pkgd.min.js?v={{ $themeVersion }}"></script>
@endpush
