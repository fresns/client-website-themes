{{-- Reply Box --}}
@if (fs_user()->check())
    @php
        $cid = $cid ?? '';
    @endphp
    <div class="card order-5 mt-3 fresns-reply @if(empty($show)) hide @else show @endif" @if(empty($show)) style="display: none" @endif>
        <div class="card-header d-flex">
            <div class="flex-grow-1">{{ fs_db_config('publish_comment_name') }} {{ $nickname }}</div>
            <button type="button" class="btn-close"></button>
        </div>
        <div class="card-body">
            <form class="form-comment-box" action="{{ route('fresns.api.editor.quick.publish', ['type' => 'comment']) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="editor-content">
                    <input type="hidden" name="commentPid" value="{{ $pid }}">
                    <input type="hidden" name="commentCid" value="{{ $cid }}">

                    <textarea class="form-control rounded-0 border-0 fresns-content" name="content" id="{{ 'quick-publish-comment-content'.$pid.$cid }}" rows="3" placeholder="{{ fs_lang('editorContent') }}"></textarea>

                    <div class="d-flex mt-2">
                        @if (fs_api_config('comment_editor_sticker'))
                            <div class="me-2">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="bi bi-emoji-smile"></i>
                                </button>
                                {{-- Sticker List --}}
                                <div class="dropdown-menu pt-0" aria-labelledby="stickers">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach(fs_stickers() as $sticker)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link @if ($loop->first) active @endif" id="sticker-{{ $loop->index }}-tab" data-bs-toggle="tab" data-bs-target="#sticker-{{ $loop->index }}" type="button" role="tab" aria-controls="sticker-{{ $loop->index }}" aria-selected="{{ $loop->first }}">{{ $sticker['name'] }}</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content p-2" id="sticker">
                                        @foreach(fs_stickers() as $sticker)
                                            <div class="tab-pane fade @if ($loop->first) show active @endif" id="sticker-{{ $loop->index }}" role="tabpanel" aria-labelledby="sticker-{{ $loop->index }}-tab">
                                                @foreach($sticker['stickers'] ?? [] as $value)
                                                    <a class="{{ 'fresns-comment-sticker'.$pid.$cid }} btn btn-outline-secondary border-0" href="javascript:;" value="{{ $value['code'] }}" title="{{ $value['code'] }}" >
                                                        <img src="{{ $value['image'] }}" alt="{{ $value['code'] }}" title="{{ $value['code'] }}">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Sticker List End --}}
                            </div>
                        @endif

                        @if(fs_api_config('comment_editor_image'))
                            <div class="input-group">
                                <label class="input-group-text" for="file">{{ fs_lang('editorImages') }}</label>
                                <input type="file" class="form-control" accept="{{ fs_user_panel('fileAccept.images') }}" name="file" id="file">
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="d-flex bd-highlight align-items-center">
                        {{-- comment button --}}
                        <div class="bd-highlight me-auto">
                            <button type="submit" class="btn btn-success">{{ fs_db_config('publish_comment_name') }}</button>
                        </div>

                        {{-- anonymous checkbox --}}
                        @if(fs_api_config('comment_editor_anonymous'))
                            <div class="bd-highlight">
                                <div class="form-check">
                                    <input class="form-check-input" name="isAnonymous" type="checkbox" value="1" id="isAnonymous">
                                    <label class="form-check-label" for="isAnonymous">{{ fs_lang('editorAnonymous') }}</label>
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
            <div class="flex-grow-1">{{ fs_db_config('publish_comment_name') }} {{ $nickname }}</div>
            <button type="button" class="btn-close"></button>
        </div>
        <div class="card-body py-5 text-center">
            <p class="mb-4 text-secondary">{{ fs_lang('errorNoLogin') }}</p>

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
@endif

@push('script')
    <script>
        $("{{ '.fresns-comment-sticker'.$pid.$cid }}").on('click',function (){
            $("{{ '#quick-publish-comment-content'.$pid.$cid }}").trigger('click').insertAtCaret("[" + $(this).attr('value') + "]");
        });
    </script>
@endpush
