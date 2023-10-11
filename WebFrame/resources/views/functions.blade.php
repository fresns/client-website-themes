@extends('WebEngine::layout')

@section('body')
    <form action="{{ route('web-frame.admin.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Loading dynamic effects --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('WebFrame::fresns.loadingConfig') }}</label>
            <div class="col-lg-6 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="webframe_loading" id="loading_true" value="true" {{ ($params['webframe_loading']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="loading_true">{{ __('FsLang::panel.option_activate') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="webframe_loading" id="loading_false" value="false" {{ ! ($params['webframe_loading']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="loading_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                </div>
            </div>
        </div>

        {{-- Quick publish post --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('WebFrame::fresns.quickPublishConfig') }}</label>
            <div class="col-lg-6 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="webframe_quick_publish" id="quick_publish_true" value="true" {{ ($params['webframe_quick_publish']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="quick_publish_true">{{ __('FsLang::panel.option_activate') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="webframe_quick_publish" id="quick_publish_false" value="false" {{ ! ($params['webframe_quick_publish']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="quick_publish_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                </div>
            </div>
        </div>

        {{-- Is the message page displayed --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('WebFrame::fresns.notificationConfig') }}</label>
            <div class="col-lg-10 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_systems" name="webframe_notifications[]" value="systems" {{ in_array('systems', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_systems">{{ __('WebFrame::fresns.notification_systems') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_recommends" name="webframe_notifications[]" value="recommends" {{ in_array('recommends', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_recommends">{{ __('WebFrame::fresns.notification_recommends') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_likes" name="webframe_notifications[]" value="likes" {{ in_array('likes', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_likes">{{ __('WebFrame::fresns.notification_likes') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_dislikes" name="webframe_notifications[]" value="dislikes" {{ in_array('dislikes', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_dislikes">{{ __('WebFrame::fresns.notification_dislikes') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_follows" name="webframe_notifications[]" value="follows" {{ in_array('follows', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_follows">{{ __('WebFrame::fresns.notification_follows') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_blocks" name="webframe_notifications[]" value="blocks" {{ in_array('blocks', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_blocks">{{ __('WebFrame::fresns.notification_blocks') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_mentions" name="webframe_notifications[]" value="mentions" {{ in_array('mentions', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_mentions">{{ __('WebFrame::fresns.notification_mentions') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_comments" name="webframe_notifications[]" value="comments" {{ in_array('comments', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_comments">{{ __('WebFrame::fresns.notification_comments') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_quotes" name="webframe_notifications[]" value="quotes" {{ in_array('quotes', $params['webframe_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_quotes">{{ __('WebFrame::fresns.notification_quotes') }}</label>
                </div>
            </div>
        </div>

        {{-- Company Name --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('WebFrame::fresns.company_name') }}</label>
            <div class="col-lg-6">
                <button type="button" class="btn btn-outline-secondary btn-modal w-100 text-start" data-bs-toggle="modal" data-bs-target="#companyNameModal">{{ $params['fs_company_name']['value'] ?? '' }}</button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-2"></div>
            <div class="col-lg-10"><button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button></div>
        </div>
    </form>

    <!-- Language Modal -->
    <div class="modal fade" id="companyNameModal" tabindex="-1" aria-labelledby="companyNameModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('FsLang::panel.button_setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('web-frame.admin.update.languages') }}" method="post">
                        @csrf
                        @method('put')

                        <input type="hidden" name="itemKey" value="fs_company_name">

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
                                    @foreach ($optionalLanguages as $lang)
                                        <tr>
                                            <td>
                                                {{ $lang['langTag'] }}
                                                @if ($lang['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}" data-bs-original-title="{{ __('FsLang::panel.default_language') }}" aria-label="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $lang['langName'] }}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><input type="text" name="languages[{{ $lang['langTag'] }}]" class="form-control" value="{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--button_save-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="/assets/WebFrame/js/functions.js"></script>
@endpush
