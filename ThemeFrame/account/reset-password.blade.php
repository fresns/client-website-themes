@extends('commons.fresns')

@section('title', fs_api_config('menu_account_reset_password'))

@section('content')
    <div class="container-fluid">
        <div class="row mt-5 pt-5 m-auto" style="max-width:500px;">
            <h1 class="h3 my-3 fw-normal text-center">{{ fs_lang('accountReset') }}</h1>

            @if (! fs_api_config('fs_theme_is_email') && ! fs_api_config('fs_theme_is_sms'))
                {{-- Email and SMS not enabled --}}
                <div class="alert alert-danger" role="alert">
                    {{ fs_lang('errorUnavailable') }}
                </div>
            @else
                <form class="py-3" id="accordionCodeAccount" method="post" action="{{ route("fresns.api.account.reset.password")  }}">
                    @csrf
                    {{-- Type Switch --}}
                    @if (fs_api_config('fs_theme_is_email') && fs_api_config('fs_theme_is_sms'))
                        <div class="input-group mb-3 mt-2">
                            <span class="input-group-text">{{ fs_lang('accountType') }}</span>
                            <div class="form-control">
                                {{-- E-Mail --}}
                                @if (fs_api_config('fs_theme_is_email'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="code_account_email" value="email" data-bs-toggle="collapse" data-bs-target="#code_account_email:not(.show)" aria-expanded="@if (empty(old('type')) || old('type') == 'email') true @else false @endif" aria-controls="code_account_email" @if (empty(old('type')) || old('type') == 'email') checked @endif>
                                        <label class="form-check-label" for="code_account_email">{{ fs_lang('email') }}</label>
                                    </div>
                                @endif

                                {{-- Phone --}}
                                @if (fs_api_config('fs_theme_is_sms'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="code_account_phone" value="phone" data-bs-toggle="collapse" data-bs-target="#code_account_phone:not(.show)" aria-expanded="@if (old('type') == 'phone') true @else false @endif" aria-controls="code_account_phone" @if (old('type') == 'phone') checked @endif>
                                        <label class="form-check-label" for="code_account_phone">{{ fs_lang('phone') }}</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Switching Accordion --}}
                    <input type="hidden" name="useType" value="2">
                    <input type="hidden" name="templateId" value="5">
                    {{-- E-Mail --}}
                    @if (fs_api_config('fs_theme_is_email'))
                        <div class="collapse @if (empty(old('type')) || old('type') == 'email') show @endif" id="code_account_email" aria-labelledby="code_account_email" data-bs-parent="#accordionCodeAccount">
                            <div class="input-group mb-3">
                                <span class="input-group-text">{{ fs_lang('email') }}</span>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control">

                                {{-- Get email verify code --}}
                                <button data-action="{{ route("fresns.api.send.verify.code") }}"  class="btn btn-outline-secondary send-verify-code" type="button">{{ fs_lang('sendVerifyCode') }}</button>
                            </div>
                        </div>
                    @endif

                    {{-- Cell Phone Number --}}
                    @if (fs_api_config('fs_theme_is_sms'))
                        <div class="collapse @if (old('type') == 'phone' || ! fs_api_config('fs_theme_is_email')) show @endif" id="code_account_phone" aria-labelledby="code_account_phone" data-bs-parent="#accordionCodeAccount">
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
                                <button data-action="{{ route("fresns.api.send.verify.code") }}"  class="btn btn-outline-secondary send-verify-code" type="button">{{ fs_lang('sendVerifyCode') }}</button>
                            </div>
                        </div>
                    @endif

                    {{-- Verify Code --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('verifyCode') }}</span>
                        <input type="text" class="form-control" name="verifyCode" value="{{ old('verifyCode') }}" required>
                    </div>

                    {{-- New Password --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('passwordNew') }}</span>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    {{-- Enter the new password again --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('passwordAgain') }}</span>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

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

                    <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">{{ fs_lang('submit') }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection
