{{-- Text Box --}}
@if ($extends['textBox'] ?? null)
    <div class="mt-3 clearfix">
        @foreach($extends['textBox'] as $textBox)
            <div class="position-relative">
                <div class="editor-frame-text">
                    {{ $textBox['textContent'] }}
                </div>

                {{-- Delete --}}
                <div class="position-absolute top-0 start-0 editor-btn-delete">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('delete') }}">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Info Box --}}
@if ($extends['infoBox'] ?? null)
    <div class="mt-3 clearfix">
        @foreach($extends['infoBox'] as $infoBox)
            <div class="position-relative">
                <div class="editor-frame-info clearfix editor-info-{{ $infoBox['infoBoxTypeString'] }}">
                    <div class="editor-info-img"><img src="{{ $infoBox['cover'] }}" loading="lazy"></div>
                    <div class="editor-info-body">
                        <div class="editor-info-title" @if ($infoBox['titleColor']) style="color:{{ $infoBox['titleColor'] }};" @endif>{{ $infoBox['title'] }}</div>
                        @if ($infoBox['descPrimary'])
                            <div class="editor-info-desc" @if ($infoBox['descPrimaryColor']) style="color:{{ $infoBox['descPrimaryColor'] }};" @endif>{{ $infoBox['descPrimary'] }}</div>
                        @endif
                        @if ($infoBox['descSecondary'])
                            <div class="editor-info-desc" @if ($infoBox['descSecondaryColor']) style="color:{{ $infoBox['descSecondaryColor'] }};" @endif>{{ $infoBox['descSecondary'] }}</div>
                        @endif
                    </div>
                    @if ($infoBox['buttonName'])
                        <div class="editor-info-btn">
                            <a class="btn btn-info btn-sm text-nowrap disabled" href="#" role="button" @if ($infoBox['buttonColor']) style="background-color:{{ $infoBox['buttonColor'] }};border-color:{{ $infoBox['buttonColor'] }};" @endif>{{ $infoBox['buttonName'] }}</a>
                        </div>
                    @endif
                </div>

                {{-- Delete --}}
                <div class="position-absolute top-0 start-0 editor-btn-delete">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-0 border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ fs_lang('delete') }}">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
