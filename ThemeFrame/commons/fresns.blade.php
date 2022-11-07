<!doctype html>
<html lang="{{ current_lang_tag() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Fresns" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title'){{ Route::is(['fresns.home']) ? '' : ' - '.fs_api_config('site_name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/atwho.min.css?v=46187dccd52da6dc">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/prism.css?v=46187dccd52da6dc">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/fresns.css?v=46187dccd52da6dc">
    @stack('style')
    @if (fs_db_config('website_stat_position') === 'head')
        {!! fs_db_config('website_stat_position') !!}
    @endif
</head>

<body>
    {{-- Header --}}
    @include('commons.header')

    {{-- Main --}}
    @yield('content')

    {{-- Fresns Extensions Modal --}}
    <div class="modal fade fresnsExtensions" id="fresnsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="fresnsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fresnsModalLabel">Extensions title</h5>
                    <button type="button" class="btn-close btn-done-extensions" id="done-extensions" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    {{-- Image Zoom Modal --}}
    <div class="modal fade image-zoom" id="imageZoom" tabindex="-1" aria-labelledby="imageZoomLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="mx-auto image-box">
                <img class="img-fluid">
            </div>
        </div>
    </div>

    {{-- Quick Post Box --}}
    @if (fs_user()->check())
        @component('components.editor.post-box', [
            'type' => 'post',
            'group' => $group ?? null
        ])@endcomponent
    @endif

    {{-- Tip Toasts --}}
    <div class="fresns-tips">
        @include('commons.tips')
    </div>

    {{-- Footer --}}
    @include('commons.footer')

    {{-- Stat Code --}}
    @if (fs_db_config('website_stat_code') === 'body')
        <div style="display:none;">{!! fs_db_config('website_stat_code') !!}</div>
    @endif

    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.bundle.min.js"></script>
    <script src="/static/js/select2.min.js"></script>
    <script src="/static/js/iframeResizer.min.js"></script>
    <script src="/static/js/fresns-iframe.js"></script>
    <script src="/assets/themes/ThemeFrame/js/jquery.caret.min.js"></script>
    <script src="/assets/themes/ThemeFrame/js/atwho.min.js?v=46187dccd52da6dc"></script>
    <script src="/assets/themes/ThemeFrame/js/sendVerifyCode.js?v=46187dccd52da6dc"></script>
    <script src="/assets/themes/ThemeFrame/js/fresns.js?v=46187dccd52da6dc"></script>
    <script>
        $(function () {
            window.hashtag_show = {{ fs_api_config('hashtag_show') }}
        })
    </script>
    @stack('script')
</body>

</html>
