@extends('commons.fresns')

@section('title', fs_api_config('menu_account_register'))

@section('content')
    <div class="container-fluid">
        <div class="row mt-5 pt-5 m-auto" style="max-width:500px;">
            <h1 class="h3 my-3 fw-normal text-center">{{ fs_lang('accountRegister') }}</h1>

            @if (fs_api_config('site_public_status'))
                {{-- Open Registration --}}

                {{-- Quick Login --}}
                @if (fs_api_config('account_connect_services'))
                    <div class="card mx-2 p-0">
                        <div class="card-header">{{ fs_lang('accountLoginByConnects') }}</div>
                        <div class="card-body">
                            @foreach(fs_api_config('account_connect_services') as $item)
                                <a class="btn btn-outline-primary mx-2" data-bs-toggle="modal" href="#fresnsModal"
                                    data-lang-tag="{{ current_lang_tag() }}"
                                    data-type="account"
                                    data-scene="join"
                                    data-post-message-key="fresnsJoin"
                                    data-title="{{ fs_lang('accountLogin') }}"
                                    data-url="{{ $item['url'] }}">
                                    <img src="/assets/themes/ThemeFrame/images/connects/{{ $item['code'] }}.png" height="32">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center my-4">
                        <span class="badge text-bg-secondary">{{ fs_lang('modifierOr') }}</span>
                    </div>
                @endif

                {{-- Register --}}
                <form class="py-3" id="accordionCodeAccount" method="post" novalidate action="{{ route("fresns.api.account.register") }}">
                    @csrf
                    {{-- Register Type Switch --}}
                    @if (fs_api_config('site_register_email') && fs_api_config('site_register_phone'))
                        <div class="input-group mb-3 mt-2">
                            <span class="input-group-text">{{ fs_lang('accountType') }}</span>
                            <div class="form-control">
                                {{-- E-Mail --}}
                                @if (fs_api_config('site_register_email'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="code_account_email" value="email" data-bs-toggle="collapse" data-bs-target="#code_account_email:not(.show)" aria-expanded="@if (empty(old('type')) || old('type') == 'email') true @else false @endif" aria-controls="code_account_email" @if (empty(old('type')) || old('type') == 'email') checked @endif>
                                        <label class="form-check-label" for="code_account_email">{{ fs_lang('email') }}</label>
                                    </div>
                                @endif

                                {{-- Phone --}}
                                @if (fs_api_config('site_register_phone'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="code_account_phone" value="phone" data-bs-toggle="collapse" data-bs-target="#code_account_phone:not(.show)" aria-expanded="@if (old('type') == 'phone') true @else false @endif" aria-controls="code_account_phone" @if (old('type') == 'phone') checked @endif>
                                        <label class="form-check-label" for="code_account_phone">{{ fs_lang('phone') }}</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif (fs_api_config('site_register_email'))
                        <input type="radio" name="type" value="email" class="d-none" checked>
                    @elseif (fs_api_config('site_register_phone'))
                        <input type="radio" name="type" value="phone" class="d-none" checked>
                    @endif

                    {{-- Switching Accordion --}}
                    <div>
                        <input type="hidden" name="useType" value="1">
                        <input type="hidden" name="templateId" value="2">
                        {{-- E-Mail --}}
                        @if (fs_api_config('site_register_email'))
                            <div class="collapse @if (empty(old('type')) || old('type') == 'email') show @endif" id="code_account_email" aria-labelledby="code_account_email" data-bs-parent="#accordionCodeAccount">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ fs_lang('email') }}</span>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">

                                    {{-- Get email verify code --}}
                                    <button class="btn btn-outline-secondary send-verify-code" type="button" data-action="{{ route("fresns.api.send.verify.code") }}">{{ fs_lang('sendVerifyCode') }}</button>
                                </div>
                            </div>
                        @endif

                        {{-- Cell Phone Number --}}
                        @if (fs_api_config('site_register_phone'))
                            <div class="collapse @if (old('type') == 'phone' || ! fs_api_config('site_register_email')) show @endif" id="code_account_phone" aria-labelledby="code_account_phone" data-bs-parent="#accordionCodeAccount">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{ fs_lang('phone') }}</span>
                                    @if (count(fs_api_config('send_sms_supported_codes')) > 1)
                                        {{-- List of country calling codes --}}
                                        <select class="form-select" name="countryCode" value="{{ old('countryCode') }}">
                                            <option disabled>{{ fs_lang('countryCode') }}</option>
                                            @foreach(fs_api_config('send_sms_supported_codes') as $countryCode)
                                                <option value="{{ $countryCode }}" @if (fs_api_config('send_sms_default_code') == $countryCode) selected @endif>{{ $countryCode }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{-- Default Country Calling Code --}}
                                        <select class="form-select d-none" name="countryCode">
                                            <option value="{{ fs_api_config('send_sms_default_code') }}" selected>{{ fs_api_config('send_sms_default_code') }}</option>
                                        </select>
                                    @endif

                                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" style="width:40%">

                                    {{-- Get cell phone verify code --}}
                                    <button class="btn btn-outline-secondary send-verify-code" type="button" data-action="{{ route("fresns.api.send.verify.code") }}">{{ fs_lang('sendVerifyCode') }}</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Verify Code --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('verifyCode') }}</span>
                        <input type="text" class="form-control" name="verifyCode" value="{{ old('verifyCode') }}" required>
                    </div>

                    {{-- Nickname --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_api_config('user_nickname_name') }}</span>
                        <input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}" required>
                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('password') }}</span>
                        <input type="password" class="form-control" minlength="{{ fs_api_config('password_length') }}" maxlength="32" name="password" required>
                    </div>

                    {{-- Enter the password again --}}
                    <div class="input-group">
                        <span class="input-group-text">{{ fs_lang('passwordAgain') }}</span>
                        <input type="password" class="form-control" minlength="{{ fs_api_config('password_length') }}" maxlength="32" name="password_confirmation" required>
                    </div>

                    {{-- Password requirement hint --}}
                    <div class="form-text mb-3">
                        {{ fs_lang('passwordInfo') }}:

                        @if (in_array('number', fs_api_config('password_strength')))
                            <span class="badge rounded-pill bg-secondary">{{ fs_lang('passwordInfoNumbers') }}</span>
                        @endif
                        @if (in_array('lowercase', fs_api_config('password_strength')))
                            <span class="badge rounded-pill bg-secondary">{{ fs_lang('passwordInfoLowercaseLetters') }}</span>
                        @endif
                        @if (in_array('uppercase', fs_api_config('password_strength')))
                            <span class="badge rounded-pill bg-secondary">{{ fs_lang('passwordInfoUppercaseLetters') }}</span>
                        @endif
                        @if (in_array('symbols', fs_api_config('password_strength')))
                            <span class="badge rounded-pill bg-secondary">{{ fs_lang('passwordInfoSymbols') }}</span>
                        @endif

                        {{ fs_lang('modifierLength') }}:
                        <span class="badge rounded-pill bg-secondary">{{ fs_api_config('password_length') }}~32</span>
                    </div>

                    {{-- Terms of Service --}}
                    <label class="form-label fs-6 mt-2">
                        <i class="bi bi-check-circle-fill"></i> {{ fs_lang('accountInfo') }}
                        @if (fs_api_config('account_terms_status'))
                            <a class="badge rounded-pill bg-success link-light text-decoration-none" data-bs-toggle="modal" href="#termsModal">{{ fs_lang('accountPoliciesTerms') }}</a>
                        @endif
                        @if (fs_api_config('account_privacy_status'))
                            <a class="badge rounded-pill bg-success link-light text-decoration-none" data-bs-toggle="modal" href="#privacyModal">{{ fs_lang('accountPoliciesPrivacy') }}</a>
                        @endif
                        @if (fs_api_config('account_cookie_status'))
                            <a class="badge rounded-pill bg-success link-light text-decoration-none" data-bs-toggle="modal" href="#cookieModal">{{ fs_lang('accountPoliciesCookie') }}</a>
                        @endif
                    </label>

                    {{-- Button --}}
                    <div class="clearfix mt-4">
                        {{-- Register Button --}}
                        <div class="float-start w-65">
                            <button class="w-100 btn btn-lg btn-primary" type="submit">{{ fs_lang('accountRegister') }}</button>
                        </div>
                        {{-- Login Link --}}
                        <div class="float-start w-35 ps-4">
                            <a class="w-100 btn btn-lg btn-outline-success" href="{{ fs_route(route('fresns.account.login')) }}" role="button">{{ fs_lang('accountLogin') }}</a>
                        </div>
                    </div>
                </form>
            @else
                {{-- Close Registration --}}
                <div class="alert alert-danger" role="alert">
                    {{ fs_code_message(34201) }}
                </div>
                <div class="mt-3 text-center">
                    <a class="btn btn-lg btn-outline-success" href="{{ fs_route(route('fresns.account.login')) }}" role="button">{{ fs_lang('accountLogin') }}</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Terms Modal --}}
    @if (fs_api_config('account_terms_status'))
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel">{{ fs_lang('accountPoliciesTerms') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! Str::markdown(fs_api_config('account_terms')) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ fs_lang('close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Privacy Policy Modal --}}
    @if (fs_api_config('account_privacy_status'))
        <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="privacyModalLabel">{{ fs_lang('accountPoliciesPrivacy') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! Str::markdown(fs_api_config('account_privacy')) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ fs_lang('close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Cookie Modal --}}
    @if (fs_api_config('account_cookie_status'))
        <div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cookieModalLabel">{{ fs_lang('accountPoliciesCookie') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! Str::markdown(fs_api_config('account_cookie')) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ fs_lang('close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
