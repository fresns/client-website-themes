<!doctype html>
<html lang="{{ current_lang_tag() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Fresns" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ fs_db_config('site_name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/atwho.min.css?v=9c26d1a06118c93e">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/prism.min.css?v=9c26d1a06118c93e">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/fresns.css?v=9c26d1a06118c93e">
    @stack('style')
    @if (fs_db_config('website_stat_position') == 'head')
        {!! fs_db_config('website_stat_code') !!}
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
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="mx-auto text-center">
                <img class="img-fluid">
            </div>
        </div>
    </div>

    {{-- Quick Post Box --}}
    @if (fs_user()->check())
        @component('components.editor.post-box', [
            'group' => $group ?? null
        ])@endcomponent
    @endif

    {{-- Tip Toasts --}}
    <div class="fresns-tips">
        @include('commons.tips')
    </div>

    {{-- Footer --}}
    @include('commons.footer')

    {{-- Switching Languages Modal --}}
    @if (fs_api_config('language_status'))
        <div class="modal fade" id="translate" tabindex="-1" aria-labelledby="translateModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ fs_lang('optionLanguage') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            @foreach(fs_api_config('language_menus') as $lang)
                                @if ($lang['isEnable'])
                                    <a class="list-group-item list-group-item-action @if (current_lang_tag() == $lang['langTag']) active @endif" hreflang="{{ $lang['langTag'] }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang['langTag'], null, [], true) }}">
                                        {{ $lang['langName'] }}
                                        @if ($lang['areaName'])
                                            {{ '('.$lang['areaName'].')' }}
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- User Auth --}}
    @include('commons.user-auth')

    {{-- Stat Code --}}
    @if (fs_db_config('website_stat_position') == 'body')
        <div style="display:none;">{!! fs_db_config('website_stat_code') !!}</div>
    @endif
    <script src="/static/js/base64.js"></script>
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.bundle.min.js"></script>
    <script src="/static/js/select2.min.js"></script>
    <script src="/static/js/js.cookie.min.js"></script>
    <script src="/static/js/iframeResizer.min.js"></script>
    <script>
        window.hashtag_show = {{ fs_api_config('hashtag_show') }};

        // video play
        var videos = document.getElementsByTagName('video'); 
        for (var i = videos.length - 1; i >= 0; i--) {
            (function(){
                var p = i;
                videos[p].addEventListener('play',function(){
                    pauseAll(p);
                })
            })()
        };
        function pauseAll(index){
            for (var j = videos.length - 1; j >= 0; j--) {
                if (j!=index) videos[j].pause();
            }
        };
    </script>
    <script src="{{ "/assets/plugins/{$engineUnikey}/js/fresns-iframe.js?v=9c26d1a06118c93e" }}"></script>
    <script src="/assets/themes/ThemeFrame/js/jquery.caret.min.js?v=9c26d1a06118c93e"></script>
    <script src="/assets/themes/ThemeFrame/js/atwho.min.js?v=9c26d1a06118c93e"></script>
    <script src="/assets/themes/ThemeFrame/js/prism.min.js?v=9c26d1a06118c93e"></script>
    <script src="/assets/themes/ThemeFrame/js/sendVerifyCode.js?v=9c26d1a06118c93e"></script>
    <script src="/assets/themes/ThemeFrame/js/fresns.js?v=9c26d1a06118c93e"></script>
    @stack('script')
</body>

</html>
