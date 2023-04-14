<footer class="text-muted mb-3 fs-8 fs-text-decoration">
    <p class="mb-0">
        <a href="{{ fs_route(route('fresns.policies')).'#terms-tab' }}" class="link-secondary">{{ fs_lang('accountPoliciesTerms') }}</a>
        <a href="{{ fs_route(route('fresns.policies')).'#privacy-tab' }}" class="link-secondary ms-2">{{ fs_lang('accountPoliciesPrivacy') }}</a>
        <a href="{{ fs_route(route('fresns.policies')).'#cookies-tab' }}" class="link-secondary ms-2">{{ fs_lang('accountPoliciesCookies') }}</a>
    </p>

    <p class="mb-2">&copy; {{fs_db_config('site_copyright_years')}} {{fs_db_config('site_copyright')}} | Powered by <a href="https://fresns.cn" target="_blank" class="link-secondary">Fresns</a></p>

    @if (fs_db_config('site_china_mode'))
        @if (fs_db_config('china_icp_filing'))
            <p class="mb-0">
                <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow" class="link-secondary">{{fs_db_config('china_icp_filing')}}</a>
            </p>
        @endif

        @if (fs_db_config('china_psb_filing'))
            <p class="mb-0">
                <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode={{ Str::of(fs_db_config('china_psb_filing'))->match('/\d+/') }}" target="_blank" rel="nofollow" class="link-secondary">{{ fs_db_config('china_psb_filing') }}</a>
            </p>
        @endif

        @if (fs_db_config('china_icp_license'))
            <p class="mb-0">{{ fs_db_config('china_icp_license') }}</p>
        @endif
    @endif

    @if (fs_db_config('china_broadcasting_license'))
        <p class="mb-0">{{ fs_db_config('china_broadcasting_license') }}</p>
    @endif
</footer>
