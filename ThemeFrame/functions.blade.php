@extends('ThemeFunctions::layout')

@section('body')
    <header class="border-bottom mb-3 pt-5 ps-5 pb-3">
        <h3>{{ $lang['name'] }}</h3>
        <p class="text-secondary"><i class="bi bi-palette"></i> {{ $lang['description'] }}</p>
    </header>

    <main class="my-5">
        <form action="{{ route('fresns.api.functions', ['fskey' => 'ThemeFrame']) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            {{-- Loading dynamic effects --}}
            <div class="row mb-4">
                <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['loadingConfig'] }}</label>
                <div class="col-lg-6 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fs_theme_loading" id="loading_true" value="true" {{ $params['fs_theme_loading'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="loading_true">{{ __('FsLang::panel.option_activate') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fs_theme_loading" id="loading_false" value="false" {{ ! $params['fs_theme_loading'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="loading_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                    </div>
                </div>
            </div>

            {{-- Quick publish post --}}
            <div class="row mb-4">
                <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['quickPublishConfig'] }}</label>
                <div class="col-lg-6 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fs_theme_quick_publish" id="quick_publish_true" value="true" {{ $params['fs_theme_quick_publish'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="quick_publish_true">{{ __('FsLang::panel.option_activate') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fs_theme_quick_publish" id="quick_publish_false" value="false" {{ ! $params['fs_theme_quick_publish'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="quick_publish_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                    </div>
                </div>
            </div>

            {{-- Is the message page displayed --}}
            <div class="row mb-4">
                <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['notificationConfig'] }}</label>
                <div class="col-lg-10 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_systems" name="fs_theme_notifications[]" value="systems" {{ in_array('systems', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_systems">{{ $lang['notification_systems'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_recommends" name="fs_theme_notifications[]" value="recommends" {{ in_array('recommends', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_recommends">{{ $lang['notification_recommends'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_likes" name="fs_theme_notifications[]" value="likes" {{ in_array('likes', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_likes">{{ $lang['notification_likes'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_dislikes" name="fs_theme_notifications[]" value="dislikes" {{ in_array('dislikes', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_dislikes">{{ $lang['notification_dislikes'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_follows" name="fs_theme_notifications[]" value="follows" {{ in_array('follows', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_follows">{{ $lang['notification_follows'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_blocks" name="fs_theme_notifications[]" value="blocks" {{ in_array('blocks', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_blocks">{{ $lang['notification_blocks'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_mentions" name="fs_theme_notifications[]" value="mentions" {{ in_array('mentions', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_mentions">{{ $lang['notification_mentions'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_comments" name="fs_theme_notifications[]" value="comments" {{ in_array('comments', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_comments">{{ $lang['notification_comments'] }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="notification_quotes" name="fs_theme_notifications[]" value="quotes" {{ in_array('quotes', $params['fs_theme_notifications']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notification_quotes">{{ $lang['notification_quotes'] }}</label>
                    </div>
                </div>
            </div>

            {{-- Company Name --}}
            <div class="row mb-4">
                <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['company_name'] }}</label>
                <div class="col-lg-6">
                    <button type="button" class="btn btn-outline-secondary btn-modal w-100 text-start" data-bs-toggle="modal" data-bs-target="#companyNameModal">{{ $params['fs_company_name'][$defaultLanguage] ?? reset($params['fs_company_name']) ?: $lang['company_name'] }}</button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-2"></div>
                <div class="col-lg-10"><button type="submit" class="btn btn-primary">{{ $lang['save'] }}</button></div>
            </div>
        </form>
    </main>

    <footer class="copyright text-center">
        <p class="my-5 text-muted">&copy; <span class="copyright-year"></span> Fresns</p>
    </footer>

    <!-- Language Modal -->
    <div class="modal fade" id="companyNameModal" tabindex="-1" aria-labelledby="companyNameModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('FsLang::panel.button_setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fresns.api.functions', ['fskey' => 'ThemeFrame']) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="table-info">
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_tag') }}</th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_name') }}</th>
                                        <th scope="col" class="w-50">{{ __('FsLang::panel.table_content') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languageMenus as $langMenu)
                                        <tr>
                                            <td>
                                                {{ $langMenu['langTag'] }}
                                                @if ($langMenu['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}" data-bs-original-title="{{ __('FsLang::panel.default_language') }}" aria-label="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $langMenu['langName'] }}
                                                @if ($langMenu['areaName'])
                                                    {{ '('.$langMenu['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><input type="text" name="fs_company_name[{{ $langMenu['langTag'] }}]" class="form-control" value="{{ $params['fs_company_name'][$langMenu['langTag']] ?? '' }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--button_save-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">{{ $lang['save'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
