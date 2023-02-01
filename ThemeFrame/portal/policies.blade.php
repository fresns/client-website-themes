@extends('commons.fresns')

@section('title', fs_lang('accountPolicies'))

@section('content')
    <main class="container">
        <div class="d-flex align-items-start mt-5 pt-5">
            <div class="nav flex-column nav-pills w-25" id="policies-tabs" role="tablist" aria-orientation="vertical">
                <div class="d-flex justify-content-between mx-3 mt-3">
                    <h1 class="fs-5">{{ fs_lang('accountPolicies') }}</h1>
                </div>
    
                @if (fs_api_config('account_terms_status'))
                    <button class="nav-link text-start rounded-0 py-3 active" id="terms-tab" data-bs-toggle="pill" data-bs-target="#terms" type="button" role="tab" aria-controls="terms" aria-selected="true">{{ fs_lang('accountPoliciesTerms') }}</button>
                @endif

                @if (fs_api_config('account_privacy_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">{{ fs_lang('accountPoliciesPrivacy') }}</button>
                @endif

                @if (fs_api_config('account_cookies_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="cookies-tab" data-bs-toggle="pill" data-bs-target="#cookies" type="button" role="tab" aria-controls="cookies" aria-selected="false">{{ fs_lang('accountPoliciesCookies') }}</button>
                @endif

                @if (fs_api_config('account_delete_status'))
                    <button class="nav-link text-start rounded-0 py-3" id="delete-tab" data-bs-toggle="pill" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">{{ fs_lang('accountDelete') }}</button>
                @endif
            </div>

            <div class="tab-content border-start ps-lg-5 pb-5 account-settings" id="policies-tab-content">
                {{-- terms --}}
                <div class="tab-pane fade show active" id="terms" role="tabpanel" aria-labelledby="terms-tab" tabindex="0">
                    {!! fs_api_config('account_terms') ? Str::markdown(fs_api_config('account_terms')) : '' !!}
                </div>

                {{-- privacy --}}
                <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab" tabindex="0">
                    {!! fs_api_config('account_privacy') ? Str::markdown(fs_api_config('account_privacy')) : '' !!}
                </div>

                {{-- cookies --}}
                <div class="tab-pane fade" id="cookies" role="tabpanel" aria-labelledby="cookies-tab" tabindex="0">
                    {!! fs_api_config('account_cookies') ? Str::markdown(fs_api_config('account_cookies')) : '' !!}
                </div>

                {{-- delete account --}}
                <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                    {!! fs_api_config('account_delete') ? Str::markdown(fs_api_config('account_delete')) : '' !!}
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
