@extends('FsView::commons.functionLayout')

@section('body')
    <main>
        <div class="container-lg p-0 p-lg-3">
            <div class="bg-white shadow-sm mt-4 mt-lg-2 p-3 p-lg-5">
                <div class="row mb-2">
                    <div class="col-7">
                        <h3>Fresns Theme Frame</h3>
                        <p class="text-secondary">Fresns theme framework settings</p>
                    </div>
                    <div class="col-5 text-end"></div>
                </div>
                {{-- Theme template settings Start --}}
                <form class="mt-4" action="{{route('panel.theme.functions.update', ['theme' => 'ThemeFrame'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    {{-- Whether to support email verification code --}}
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label text-lg-end">是否支持邮件验证码</label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select class="form-select" name="fs_theme_is_email">
                                    <option selected disabled>请选择...</option>
                                    <option value="true" @if($themeParams['fs_theme_is_email']['value'] ?? null) selected @endif>支持</option>
                                    <option value="false" @if(! $themeParams['fs_theme_is_email']['value'] ?? null) selected @endif>不支持</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Whether to support SMS verification code --}}
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label text-lg-end">是否支持短信验证码</label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <select class="form-select" name="fs_theme_is_sms">
                                    <option selected disabled>请选择...</option>
                                    <option value="true" @if($themeParams['fs_theme_is_sms']['value'] ?? null) selected @endif>支持</option>
                                    <option value="false" @if(! $themeParams['fs_theme_is_sms']['value'] ?? null) selected @endif>不支持</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Does the message page display --}}
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label text-lg-end">消息页是否显示</label>
                        <div class="col-lg-10 mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_systems" name="fs_theme_notifies[]" value="systems" {{ in_array('systems', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_systems">系统通知</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_recommends" name="fs_theme_notifies[]" value="recommends" {{ in_array('recommends', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_recommends">推荐</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_likes" name="fs_theme_notifies[]" value="likes" {{ in_array('likes', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_likes">点赞</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_dislikes" name="fs_theme_notifies[]" value="dislikes" {{ in_array('dislikes', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_dislikes">踩</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_follows" name="fs_theme_notifies[]" value="follows" {{ in_array('follows', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_follows">关注</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_blocks" name="fs_theme_notifies[]" value="blocks" {{ in_array('blocks', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_blocks">屏蔽</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_mentions" name="fs_theme_notifies[]" value="mentions" {{ in_array('mentions', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_mentions">提及</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="notify_comments" name="fs_theme_notifies[]" value="comments" {{ in_array('comments', $themeParams['fs_theme_notifies']['value'] ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notify_comments">评论</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10"><button type="submit" class="btn btn-primary">保存</button></div>
                    </div>
                </form>
                {{-- Theme template settings End --}}
            </div>
        </div>
    </main>
@endsection
