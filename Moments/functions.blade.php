@extends('FsView::commons.functionLayout')

@section('body')
    <main>
        <div class="container-lg p-0 p-lg-3">
            <div class="bg-white shadow-sm mt-4 mt-lg-2 p-3 p-lg-5">
                <div class="row mb-2">
                    <div class="col-7">
                        <h3>{{ $lang['name'] }}</h3>
                        <p class="text-secondary">{{ $lang['description'] }}</p>
                    </div>
                    <div class="col-5 text-end"></div>
                </div>
                {{-- Theme template settings: Start --}}
                <form class="mt-4" action="{{route('panel.theme.functions.update', ['theme' => 'Moments'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    {{-- Loading dynamic effects --}}
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['loadingConfig'] }}</label>
                        <div class="col-lg-6 mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fs_theme_loading" id="loading_true" value="true" {{ ($params['fs_theme_loading']['value'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="loading_true">{{ __('FsLang::panel.option_activate') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fs_theme_loading" id="loading_false" value="false" {{ ! ($params['fs_theme_loading']['value'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="loading_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                            </div>
                        </div>
                    </div>

                    {{-- Is the message page displayed --}}
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label text-lg-end">{{ $lang['notificationConfig'] }}</label>
                        <div class="col-lg-10 mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_systems" name="fs_theme_notifications[]" value="systems" {{ in_array('systems', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_systems">{{ $lang['notification_systems'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_recommends" name="fs_theme_notifications[]" value="recommends" {{ in_array('recommends', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_recommends">{{ $lang['notification_recommends'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_likes" name="fs_theme_notifications[]" value="likes" {{ in_array('likes', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_likes">{{ $lang['notification_likes'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_dislikes" name="fs_theme_notifications[]" value="dislikes" {{ in_array('dislikes', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_dislikes">{{ $lang['notification_dislikes'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_follows" name="fs_theme_notifications[]" value="follows" {{ in_array('follows', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_follows">{{ $lang['notification_follows'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_blocks" name="fs_theme_notifications[]" value="blocks" {{ in_array('blocks', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_blocks">{{ $lang['notification_blocks'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_mentions" name="fs_theme_notifications[]" value="mentions" {{ in_array('mentions', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_mentions">{{ $lang['notification_mentions'] }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notification_comments" name="fs_theme_notifications[]" value="comments" {{ in_array('comments', $params['fs_theme_notifications']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_comments">{{ $lang['notification_comments'] }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10"><button type="submit" class="btn btn-primary">{{ $lang['save'] }}</button></div>
                    </div>
                </form>
                {{-- Theme template settings: End --}}
            </div>
        </div>
    </main>
@endsection
