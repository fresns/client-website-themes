@extends('commons.fresns')

@section('title', fs_lang('accountPolicies'))

@section('content')
    <div class="portal">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="d-flex justify-content-between mx-3 mt-3">
                    <h1 class="fs-5">{{ fs_lang('accountPolicies') }}</h1>
                </div>
    
                @if (fs_api_config('account_terms_status'))
                    <button class="nav-link text-start rounded-0 py-3 active" id="v-pills-terms-tab" data-bs-toggle="pill" data-bs-target="#v-pills-terms" type="button" role="tab" aria-controls="v-pills-terms" aria-selected="true">{{ fs_lang('accountPoliciesTerms') }}</button>
                @endif

                @if (fs_api_config('account_privacy_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="v-pills-privacy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy" aria-selected="false">{{ fs_lang('accountPoliciesPrivacy') }}</button>
                @endif

                @if (fs_api_config('account_cookies_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="v-pills-cookies-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cookies" type="button" role="tab" aria-controls="v-pills-cookies" aria-selected="false">{{ fs_lang('accountPoliciescookies') }}</button>
                @endif

                @if (fs_api_config('account_delete_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="v-pills-delete-tab" data-bs-toggle="pill" data-bs-target="#v-pills-delete" type="button" role="tab" aria-controls="v-pills-delete" aria-selected="false">{{ fs_lang('accountDelete') }}</button>
                @endif
            </div>

            <div class="tab-content border-start ps-lg-5 pb-5 account-settings" id="v-pills-tabContent">
                {{-- terms --}}
                <div class="tab-pane fade show active" id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab" tabindex="0">
                    {!! Str::markdown(fs_api_config('account_terms')) !!}
                </div>

                {{-- privacy --}}
                <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab" tabindex="0">
                    {!! Str::markdown(fs_api_config('account_privacy')) !!}
                </div>

                {{-- cookies --}}
                <div class="tab-pane fade" id="v-pills-cookies" role="tabpanel" aria-labelledby="v-pills-cookies-tab" tabindex="0">
                    {!! Str::markdown(fs_api_config('account_cookies')) !!}
                </div>

                {{-- delete account --}}
                <div class="tab-pane fade" id="v-pills-delete" role="tabpanel" aria-labelledby="v-pills-delete-tab" tabindex="0">
                    {!! Str::markdown(fs_api_config('account_delete')) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
