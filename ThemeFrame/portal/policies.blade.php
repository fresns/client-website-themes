@extends('commons.fresns')

@section('title', fs_lang('accountPolicies'))

@section('content')
    <main class="container">
        <div class="d-flex align-items-start mt-5 pt-5">
            <div class="nav flex-column nav-pills w-25" id="policies-tabs" role="tablist" aria-orientation="vertical">
                <div class="d-flex justify-content-between mx-3 mt-3">
                    <h1 class="fs-5">{{ fs_lang('accountPolicies') }}</h1>
                </div>
    
                @if (fs_config('account_terms_status'))
                    <button class="nav-link text-start rounded-0 py-3 active" id="terms-tab" data-bs-toggle="pill" data-bs-target="#account-terms" type="button" role="tab" aria-controls="terms" aria-selected="true">{{ fs_lang('accountPoliciesTerms') }}</button>
                @endif

                @if (fs_config('account_privacy_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#account-privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">{{ fs_lang('accountPoliciesPrivacy') }}</button>
                @endif

                @if (fs_config('account_cookie_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="cookies-tab" data-bs-toggle="pill" data-bs-target="#account-cookies" type="button" role="tab" aria-controls="cookies" aria-selected="false">{{ fs_lang('accountPoliciesCookie') }}</button>
                @endif

                @if (fs_config('account_delete_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="delete-tab" data-bs-toggle="pill" data-bs-target="#account-delete" type="button" role="tab" aria-controls="delete" aria-selected="false">{{ fs_lang('accountPoliciesDelete') }}</button>
                @endif
            </div>

            <div class="tab-content border-start ps-lg-5 pb-5 account-settings" id="policies-tab-content">
                {{-- Terms --}}
                <div class="tab-pane fade show active" id="account-terms" role="tabpanel" aria-labelledby="terms-tab" tabindex="0">
                    {!! fs_config('account_terms_policy') ? Str::markdown(fs_config('account_terms_policy')) : '' !!}
                </div>

                {{-- Privacy --}}
                <div class="tab-pane fade" id="account-privacy" role="tabpanel" aria-labelledby="privacy-tab" tabindex="0">
                    {!! fs_config('account_privacy_policy') ? Str::markdown(fs_config('account_privacy_policy')) : '' !!}
                </div>

                {{-- Cookies --}}
                <div class="tab-pane fade" id="account-cookies" role="tabpanel" aria-labelledby="cookies-tab" tabindex="0">
                    {!! fs_config('account_cookie_policy') ? Str::markdown(fs_config('account_cookie_policy')) : '' !!}
                </div>

                {{-- Delete Account --}}
                <div class="tab-pane fade" id="account-delete" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                    {!! fs_config('account_delete_policy') ? Str::markdown(fs_config('account_delete_policy')) : '' !!}
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var activeTab = window.location.hash.substring(1);
            if (!activeTab) {
                activeTab = 'terms-tab';
            }
            $('#' + activeTab).tab('show');
            document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

            $('#policies-tabs button').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
@endpush
