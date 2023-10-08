@extends('WebEngine::layout')

@section('body')
    <form action="{{ route('moments.admin.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- Loading dynamic effects --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('Moments::fresns.loadingConfig') }}</label>
            <div class="col-lg-6 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="moments_loading" id="loading_true" value="true" {{ ($params['moments_loading']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="loading_true">{{ __('FsLang::panel.option_activate') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="moments_loading" id="loading_false" value="false" {{ ! ($params['moments_loading']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="loading_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                </div>
            </div>
        </div>

        {{-- Quick publish post --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('Moments::fresns.quickPublishConfig') }}</label>
            <div class="col-lg-6 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="moments_quick_publish" id="quick_publish_true" value="true" {{ ($params['moments_quick_publish']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="quick_publish_true">{{ __('FsLang::panel.option_activate') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="moments_quick_publish" id="quick_publish_false" value="false" {{ ! ($params['moments_quick_publish']['value'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="quick_publish_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                </div>
            </div>
        </div>

        {{-- Content markdown config --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('Moments::fresns.ContentMarkdownConfig') }}</label>
            <div class="col-lg-10 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="option_quick_publish" name="moments_editor_markdown[quickPublish]" value="1" {{ ($params['moments_editor_markdown']['value']['quickPublish'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="option_quick_publish">{{ __('Moments::fresns.option_quick_publish') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="option_editor" name="moments_editor_markdown[editor]" value="1" {{ ($params['moments_editor_markdown']['value']['editor'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="option_editor">{{ __('Moments::fresns.option_editor') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="option_comment_box" name="moments_editor_markdown[commentBox]" value="1" {{ ($params['moments_editor_markdown']['value']['commentBox'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="option_comment_box">{{ __('Moments::fresns.option_comment_box') }}</label>
                </div>
            </div>
        </div>

        {{-- Is the message page displayed --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('Moments::fresns.notificationConfig') }}</label>
            <div class="col-lg-10 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_systems" name="moments_notifications[]" value="systems" {{ in_array('systems', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_systems">{{ __('Moments::fresns.notification_systems') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_recommends" name="moments_notifications[]" value="recommends" {{ in_array('recommends', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_recommends">{{ __('Moments::fresns.notification_recommends') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_likes" name="moments_notifications[]" value="likes" {{ in_array('likes', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_likes">{{ __('Moments::fresns.notification_likes') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_dislikes" name="moments_notifications[]" value="dislikes" {{ in_array('dislikes', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_dislikes">{{ __('Moments::fresns.notification_dislikes') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_follows" name="moments_notifications[]" value="follows" {{ in_array('follows', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_follows">{{ __('Moments::fresns.notification_follows') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_blocks" name="moments_notifications[]" value="blocks" {{ in_array('blocks', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_blocks">{{ __('Moments::fresns.notification_blocks') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_mentions" name="moments_notifications[]" value="mentions" {{ in_array('mentions', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_mentions">{{ __('Moments::fresns.notification_mentions') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_comments" name="moments_notifications[]" value="comments" {{ in_array('comments', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_comments">{{ __('Moments::fresns.notification_comments') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notification_quotes" name="moments_notifications[]" value="quotes" {{ in_array('quotes', $params['moments_notifications']['value'] ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notification_quotes">{{ __('Moments::fresns.notification_quotes') }}</label>
                </div>
            </div>
        </div>

        {{-- moments_search_method --}}
        <div class="row mb-4">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('Moments::fresns.search_method') }}</label>
            <div class="col-lg-6">
                <select class="form-select" name="moments_search_method">
                    <option value="" {{ !($params['moments_search_method']['value'] ?? '') ? 'selected' : '' }}>Site API</option>
                    <option value="google" {{ ($params['moments_search_method']['value'] ?? '') == 'google' ? 'selected' : '' }}>Google</option>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-2"></div>
            <div class="col-lg-10"><button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button></div>
        </div>
    </form>
@endsection

@push('script')
    <script src="/assets/Moments/js/functions.js"></script>
@endpush
