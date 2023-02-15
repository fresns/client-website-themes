<!doctype html>
<html lang="{{ current_lang_tag() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Fresns" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title') - {{ fs_db_config('site_name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ fs_db_config('site_name') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ fs_db_config('site_icon') }}">
    <link rel="icon" href="{{ fs_db_config('site_icon') }}">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/atwho.min.css?v={{ $themeVersion }}">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/prism.min.css?v={{ $themeVersion }}">
    <link rel="stylesheet" href="/assets/themes/ThemeFrame/css/fresns.css?v={{ $themeVersion }}">
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
                <img class="img-fluid" loading="lazy">
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

    {{-- Loading --}}
    <div id="loading" class="position-fixed top-50 start-50 translate-middle bg-secondary bg-opacity-75 rounded p-4" style="z-index:2048;display:none;">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

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
        window.siteName = "{{ fs_db_config('site_name') }}";
        window.siteIcon = "{{ fs_db_config('site_icon') }}";
        window.langTag = "{{ current_lang_tag() }}";
        window.mentionStatus = {{ fs_api_config('mention_status') ? 1 : 0 }};
        window.hashtagStatus = {{ fs_api_config('hashtag_status') ? 1 : 0 }};
        window.hashtagFormat = {{ fs_api_config('hashtag_format') }};

        // loading
        $(document).on("click", "a", function(e) {
            var href = $(this).attr("href");
            if (href && !href.startsWith("javascript:") && href !== "#") {
                if ((href.indexOf(location.hostname) !== -1 || href[0] === "/") && $(this).attr("target") !== "_blank") {
                    $("#loading").show();
                }
            }
        });
        $(window).on("load", function() {
            $("#loading").hide();
        });
        window.addEventListener('pageshow', function () {
            $("#loading").hide();
        });
        window.addEventListener("visibilitychange", function() {
            // android compatible
            $("#loading").hide();
        });

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
    <script src="/assets/plugins/{{ $engineUnikey }}/js/fresns-iframe.js?v={{ $engineVersion }}"></script>
    <script src="/assets/themes/ThemeFrame/js/jquery.caret.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/ThemeFrame/js/atwho.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/ThemeFrame/js/prism.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/ThemeFrame/js/sendVerifyCode.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/ThemeFrame/js/fresns.js?v={{ $themeVersion }}"></script>
    @stack('script')
</body>

</html>
