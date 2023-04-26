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
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ fs_db_config('site_name') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ fs_db_config('site_icon') }}">
    <link rel="icon" href="{{ fs_db_config('site_icon') }}">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css?v={{ $fresnsVersion }}">
    <link rel="stylesheet" href="/static/css/fontawesome.min.css?v={{ $fresnsVersion }}">
    <link rel="stylesheet" href="/static/css/select2.min.css?v={{ $fresnsVersion }}">
    <link rel="stylesheet" href="/assets/themes/Moments/css/atwho.min.css?v={{ $themeVersion }}">
    <link rel="stylesheet" href="/assets/themes/Moments/css/prism.min.css?v={{ $themeVersion }}">
    <link rel="stylesheet" href="/assets/themes/Moments/css/fancybox.min.css?v={{ $themeVersion }}">
    <link rel="stylesheet" href="/assets/themes/Moments/css/fresns.css?v={{ $themeVersion }}">
    <script src="/static/js/jquery.min.js"></script>
    @stack('style')
    @if (fs_db_config('website_stat_position') == 'head')
        {!! fs_db_config('website_stat_code') !!}
    @endif
</head>

<body>
    {{-- Header --}}
    <header class="fs-header">
        @include('commons.header')
    </header>

    @if (Route::is(['fresns.account.*', 'fresns.editor.*', 'fresns.policies']))
        {{-- Main --}}
        <main class="fs-account-main ms-25 pt-4 mt-lg-0 pt-lg-0">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="ms-25 py-4 text-center text-muted border-top">
            <p class="mb-1">Copyright &copy; {{fs_db_config('site_copyright_years')}} {{fs_db_config('site_copyright')}}. All Rights Reserved</p>

            @if (fs_db_config('site_china_mode'))
                <p class="mb-1" style="font-size:15px;">
                    @if (fs_db_config('china_icp_filing'))
                        <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow" class="text-decoration-none link-secondary">{{fs_db_config('china_icp_filing')}}</a>
                    @endif
                    @if (fs_db_config('china_icp_filing') && fs_db_config('china_psb_filing'))
                        <span class="mx-1">|</span>
                    @endif
                    @if (fs_db_config('china_psb_filing'))
                        <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode={{ Str::of(fs_db_config('china_psb_filing'))->match('/\d+/') }}" target="_blank" rel="nofollow" class="text-decoration-none link-secondary">{{ fs_db_config('china_psb_filing') }}</a>
                    @endif
                </p>

                @if (fs_db_config('china_icp_license'))
                    <p class="mb-1" style="font-size:15px;">{{ fs_db_config('china_icp_license') }}</p>
                @endif

                @if (fs_db_config('china_broadcasting_license'))
                    <p class="mb-1" style="font-size:15px;">{{ fs_db_config('china_broadcasting_license') }}</p>
                @endif
            @endif

            <p class="mb-0">Powered by <a href="https://fresns.cn" target="_blank" class="text-decoration-none link-secondary">Fresns</a></p>
        </footer>
    @else
        {{-- Main --}}
        <main class="fs-main pt-4 mt-lg-0 pt-lg-0">
            {{-- Private mode user status handling --}}
            @if (fs_user()->check() && fs_user('detail.expired'))
                <div class="alert alert-warning m-3" role="alert">
                    <i class="fa-solid fa-circle-info"></i>
                    @if (fs_api_config('site_private_end_after') == 1)
                        {{ fs_lang('privateContentHide') }}
                    @else
                        {{ fs_lang('privateContentShowOld') }}
                    @endif

                    <button class="btn btn-primary btn-sm ms-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                        data-type="account"
                        data-scene="renewal"
                        data-post-message-key="fresnsRenewal"
                        data-title="{{ fs_lang('renewal') }}"
                        data-url="{{ fs_api_config('site_public_service') }}">
                        {{ fs_lang('renewal') }}
                    </button>
                </div>
            @endif

            {{-- content --}}
            @yield('content')
        </main>

        {{-- Sidebar --}}
        <div class="fs-sidebar d-none d-sm-block">
            {{-- Sidebar --}}
            <section>
                @include('commons.sidebar')
            </section>

            {{-- Footer --}}
            @include('commons.footer')
        </div>
    @endif

    {{-- Mobile Tabbar --}}
    @if (Route::is([
        'fresns.home',
        'fresns.*.index',
        'fresns.user.list',
        'fresns.hashtag.list',
        'fresns.post.list',
        'fresns.comment.list',
        'fresns.notifications.index',
        'fresns.account.login',
        'fresns.account.register',
        'fresns.account.reset.password',
    ]) && ! Route::is('fresns.messages.index'))
        @include('commons.tabbar')
    @endif

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

    {{-- Loading --}}
    @if (fs_db_config('fs_theme_loading'))
        <div id="loading" class="position-fixed top-50 start-50 translate-middle bg-light bg-opacity-75 rounded pt-4 pb-5 px-5" style="z-index:2048;display:none;">
            <div class="loader"></div>
        </div>
    @endif

    {{-- Switching Languages Modal --}}
    @if (fs_api_config('language_status'))
        <div class="modal fade" id="translate" tabindex="-1" aria-labelledby="translateModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
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

    {{-- No login comment tip --}}
    @if (fs_user()->guest())
        <div class="modal fade" id="commentTipModal" tabindex="-1" aria-labelledby="commentTipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="commentTipModalLabel">{{ fs_db_config('publish_comment_name') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-5 text-center">
                        <p class="mt-2 mb-4 text-secondary">{{ fs_lang('errorNoLogin') }}</p>
            
                        <a class="btn btn-outline-success me-3" href="{{ fs_route(route('fresns.account.login', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountLogin') }}</a>
            
                        @if (fs_api_config('site_public_status'))
                            @if (fs_api_config('site_public_service'))
                                <button class="btn btn-success me-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                    data-type="account"
                                    data-scene="join"
                                    data-post-message-key="fresnsJoin"
                                    data-title="{{ fs_lang('accountRegister') }}"
                                    data-url="{{ fs_api_config('site_public_service') }}">
                                    {{ fs_lang('accountRegister') }}
                                </button>
                            @else
                                <a class="btn btn-success me-3" href="{{ fs_route(route('fresns.account.register', ['redirectURL' => request()->fullUrl()])) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Stat Code --}}
    @if (fs_db_config('website_stat_position') == 'body')
        <div style="display:none;">{!! fs_db_config('website_stat_code') !!}</div>
    @endif
    <script src="/static/js/base64.js?v={{ $fresnsVersion }}"></script>
    <script src="/static/js/bootstrap.bundle.min.js?v={{ $fresnsVersion }}"></script>
    <script src="/static/js/select2.min.js?v={{ $fresnsVersion }}"></script>
    <script src="/static/js/iframeResizer.min.js?v={{ $fresnsVersion }}"></script>
    <script>
        window.ajaxGetList = true;
        window.siteName = "{{ fs_db_config('site_name') }}";
        window.siteIcon = "{{ fs_db_config('site_icon') }}";
        window.langTag = "{{ current_lang_tag() }}";
        window.userIdentifier = "{{ fs_api_config('user_identifier') }}";
        window.mentionStatus = {{ fs_api_config('mention_status') ? 1 : 0 }};
        window.hashtagStatus = {{ fs_api_config('hashtag_status') ? 1 : 0 }};
        window.hashtagFormat = {{ fs_api_config('hashtag_format') }};

        // back
        function goBack() {
            if (history.length <= 1) {
                window.location.href = "{{ fs_route(route('fresns.home')) }}";
            } else {
                history.go(-1);
            }
        };
    </script>
    <script src="/assets/plugins/{{ $engineUnikey }}/js/fresns-iframe.js?v={{ $engineVersion }}"></script>
    <script src="/assets/themes/Moments/js/jquery.caret.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/Moments/js/atwho.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/Moments/js/prism.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/Moments/js/fancybox.umd.min.js?v={{ $themeVersion }}"></script>
    <script src="/assets/themes/Moments/js/fresns.js?v={{ $themeVersion }}"></script>
    @stack('script')
</body>

</html>
