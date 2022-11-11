{{-- Reply Box --}}
@if (fs_user()->check())
    <div class="card order-5 mt-3 fresns-reply @if(empty($show)) hide @else show @endif" @if(empty($show)) style="display: none" @endif>
        <div class="card-header d-flex">
            <div class="flex-grow-1">{{ fs_api_config('publish_comment_name') }} {{ $nickname }}</div>
            <button type="button" class="btn-close"></button>
        </div>
        <div class="card-body">
            <form class="form-comment-box" action="{{ route('fresns.api.editor.quick.publish', ['type' => 'comment']) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="editor-content">
                    <input type="hidden" name="commentPid" value="{{ $pid ?? "" }}">
                    <input type="hidden" name="commentCid" value="{{ $cid ?? "" }}">
                    <textarea class="form-control rounded-0 border-0 fresns-content" name="content" id="content" rows="3" placeholder="{{ fs_lang('editorContent') }}"></textarea>
                    @if(fs_api_config('comment_editor_image'))
                        <div class="input-group mt-2">
                            <label class="input-group-text" for="file">{{ fs_lang('editorImages') }}</label>
                            <input type="file" class="form-control" accept="{{ $userPanel['fileAccept']['images'] }}" name="file" id="file">
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex bd-highlight align-items-center">
                        {{-- comment button --}}
                        <div class="bd-highlight me-auto">
                            <button type="submit" class="btn btn-success">{{ fs_api_config('publish_comment_name') }}</button>
                        </div>

                        {{-- anonymous checkbox --}}
                        @if(fs_api_config('comment_editor_anonymous'))
                            <div class="bd-highlight">
                                <div class="form-check">
                                    <input class="form-check-input" name="anonymous" type="checkbox" value="1" id="anonymous">
                                    <label class="form-check-label" for="anonymous">{{ fs_lang('editorAnonymous') }}</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="card order-5 mt-3 fresns-reply @if(empty($show)) hide @else show @endif" @if(empty($show)) style="display: none" @endif>
        <div class="card-header d-flex">
            <div class="flex-grow-1">{{ fs_api_config('publish_comment_name') }} {{ $nickname }}</div>
            <button type="button" class="btn-close"></button>
        </div>
        <div class="card-body py-5 text-center">
            <p class="mb-4 text-secondary">{{ fs_lang('errorNoLogin') }}</p>

            <a class="btn btn-outline-success me-3" href="{{ fs_route(route('fresns.account.login')) }}" role="button">{{ fs_lang('accountLogin') }}</a>

            @if (fs_api_config('site_public_status'))
                @if (fs_api_config('site_public_service'))
                    <button class="btn btn-success me-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                        data-lang-tag="{{ current_lang_tag() }}"
                        data-type="account"
                        data-scene="join"
                        data-post-message-key="fresnsJoin"
                        data-title="{{ fs_lang('accountRegister') }}"
                        data-url="{{ fs_api_config('site_public_service') }}">
                        {{ fs_lang('accountRegister') }}
                    </button>
                @else
                    <a class="btn btn-success me-3" href="{{ fs_route(route('fresns.account.register')) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                @endif
            @endif
        </div>
    </div>
@endif
