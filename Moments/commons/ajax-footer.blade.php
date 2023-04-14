{{-- Auto-Loading Prompt --}}
<div class="clearfix my-5">
    {{-- Swipe up to refresh tip --}}
    <div id="fresns-list-tip" class="text-secondary text-center">
        <div class="mb-3">
            <i class="fa-solid fa-angles-up"></i>
            {{ fs_lang('scrollUpToLoadMore') }}
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-outline-secondary" id="fresns-list-loading-btn">{{ fs_lang('clickToLoadMore') }}</button>
        </div>
    </div>

    {{-- Loading tip --}}
    <div id="fresns-list-loading" class="text-secondary text-center me-2" style="display: none;">
        <div class="spinner-border spinner-border-sm text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        {{ fs_lang('loading') }}
    </div>

    {{-- Last page tip --}}
    <div id="fresns-list-no-more" class="text-secondary text-center" style="display: none;">
        <i class="fa-solid fa-signs-post"></i>
        {{ fs_lang('listWithoutPage') }}
    </div>
</div>
