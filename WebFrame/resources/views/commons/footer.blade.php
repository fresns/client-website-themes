<footer class="container-fluid pt-4 my-4 text-center text-muted border-top">
    <p class="mb-1">Copyright &copy; {{fs_db_config('site_copyright_years')}} {{fs_db_config('site_copyright')}}. All Rights Reserved</p>

    <p class="mb-1" style="font-size:15px;">
        @if (fs_db_config('site_china_mode'))
            @if (fs_db_config('china_icp_filing'))
                <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow" class="text-decoration-none link-secondary">{{fs_db_config('china_icp_filing')}}</a>
            @endif
            @if (fs_db_config('china_icp_filing') && fs_db_config('china_mps_filing'))
                <span class="mx-1">|</span>
            @endif
            @if (fs_db_config('china_mps_filing'))
                <a href="https://beian.mps.gov.cn/#/query/webSearch?code={{ Str::of(fs_db_config('china_mps_filing'))->match('/\d+/') }}" target="_blank" rel="nofollow" class="text-decoration-none link-secondary">{{ fs_db_config('china_mps_filing') }}</a>
            @endif
        @endif
    </p>

    @if (fs_db_config('china_icp_license'))
        <p class="mb-1" style="font-size:15px;">{{ fs_db_config('china_icp_license') }}</p>
    @endif

    @if (fs_db_config('china_broadcasting_license'))
        <p class="mb-1" style="font-size:15px;">{{ fs_db_config('china_broadcasting_license') }}</p>
    @endif

    <p class="mb-0">Powered by <a href="https://fresns.org" target="_blank" class="text-decoration-none link-secondary">Fresns</a></p>
</footer>
