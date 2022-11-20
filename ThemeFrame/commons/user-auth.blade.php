@if (fs_account()->check())
    {{-- After login: Select user --}}
    <div class="modal fade" id="userAuth" data-bs-backdrop="static" tabindex="-1"  aria-hidden="true" aria-labelledby="userAuthModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_lang('optionUser') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach(fs_account('detail.users') as $item)
                            <div class="col-sm-3 d-flex flex-column align-items-center">
                                <img src="{{ $item['avatar'] }}" class="auth-avatar rounded-circle">
                                <div class="auth-nickname mt-2">{{ $item['nickname'] }}</div>
                                <div class="text-secondary">{{ '@' . $item['username'] }}</div>
                                <form action="{{ route('fresns.api.user.auth') }}" id="#uid-{{ $item['uid'] }}" method="post">
                                    @csrf
                                    <input type="hidden" name="uidOrUsername" value="{{ $item['uid'] }}">
                                    @if ($item['hasPassword'])
                                        <a data-bs-target="#userPwdLogin" data-uid="{{ $item['uid'] }}" data-nickname="{{ $item['nickname'] }}" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-outline-secondary btn-sm my-2" onclick="$('#userPwdLoginLabel').text($(this).data('nickname'));$('#userPwdLogin input[name=uidOrUsername]').val($(this).data('uid'))">{{ fs_lang('userPassword') }}</a>
                                    @else
                                        <button type="submit" class="btn btn-outline-secondary btn-sm my-2">{{ fs_lang('choose') }}</button>
                                    @endif
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if (Route::is('fresns.account.login') || Route::is('fresns.account.register') || Route::is('fresns.account.reset.password'))
                    <div class="modal-footer">
                        <a class="btn btn-danger" role="button" href="{{ fs_route(route('fresns.account.logout')) }}"><i class="bi bi-power"></i> {{ fs_lang('accountLogout') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- After login: select user - enter password --}}
    <div class="modal fade" id="userPwdLogin" aria-hidden="true" aria-labelledby="userPwdLoginLabel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="user-password-auth">
                <form action="{{ route('fresns.api.user.auth') }}" method="post" onsubmit="var passwordInput = document.querySelector('#user-password-auth > form > div.modal-body > div.input-group > input'); passwordInput.value = Base64.encode(passwordInput.value)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userPwdLoginLabel">
                            @if (count(fs_account('detail.users')) == 1)
                                {{ fs_account('detail.users.0.nickname') }}
                            @else
                                User Password Login
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-target="#userAuth" data-bs-toggle="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @if (count(fs_account('detail.users')) == 1)
                            <input type="hidden" name="uidOrUsername" value="{{ fs_account('detail.users.0.uid') }}">
                        @else
                            <input type="hidden" name="uidOrUsername">
                        @endif
                        <div class="input-group">
                            <span class="input-group-text">{{ fs_lang('userAuthPassword') }}</span>
                            <input type="password" class="form-control" required name="password">
                        </div>
                        <div class="invalid-feedback" style="display: block"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ fs_lang('userAuth') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@push('script')
    @if (Route::is('fresns.account.login') || Route::is('fresns.account.register') || Route::is('fresns.account.reset.password'))
        @if (fs_account()->check() && fs_user()->guest())
            <script>
                $(function () {
                    var userCount = "{{ count(fs_account('detail.users')) }}";

                    switch (Number(userCount)) {
                        default:
                            new bootstrap.Modal('#userAuth').show();
                        break;
                        case 1:
                            var hasPassword = "{{ fs_account('detail.users.0.hasPassword') }}" || true;
                            if (hasPassword == "true") {
                                new bootstrap.Modal('#userPwdLogin').show()
                            } else {
                                $("#uid-{{ fs_account('detail.users.0.uid') }} button").click()
                            }
                        break;
                    }
                })
            </script>
        @endif
    @endif
@endpush
