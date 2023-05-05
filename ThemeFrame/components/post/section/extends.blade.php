{{-- Text Box --}}
@if ($extends['textBox'])
    @foreach($extends['textBox'] as $extend)
        <div class="position-relative frame-box-text">
            <div class="frame-text-content">
                {{ $extend['content'] }}
            </div>
            {{-- Page Type --}}
            @if ($extend['accessUrl'])
                <a class="text-decoration-none stretched-link" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="post"
                    data-scene="extendBox"
                    data-post-message-key="fresnsPostExtendBox"
                    data-pid="{{ $pid }}"
                    data-uid="{{ $author['uid'] }}"
                    data-title="{{ $extend['title'] }}"
                    data-url="{{ $extend['accessUrl'] }}">
                </a>
            @endif
        </div>
    @endforeach
@endif

{{-- Info Box --}}
@if ($extends['infoBox'])
    @foreach($extends['infoBox'] as $extend)
        <div class="position-relative frame-box-info mb-3">
            <div class="d-flex align-items-center">
                {{-- Cover Image --}}
                <div class="flex-shrink-0">
                    <img src="{{ $extend['cover'] }}" loading="lazy" class="frame-image-{{ $extend['infoTypeString'] }}">
                </div>

                <div class="flex-grow-1 px-3">
                    <div class="d-flex flex-column frame-box-{{ $extend['infoTypeString'] }}">
                        <div class="frame-title" style="color:{{ $extend['titleColor'] }}">{{ $extend['title'] }}</div>

                        @if ($extend['descPrimary'])
                            <div class="frame-desc mt-auto" style="color:{{ $extend['descPrimaryColor'] }}">{{ $extend['descPrimary'] }}</div>
                        @endif
                        @if ($extend['descSecondary'])
                            <div class="frame-desc mt-auto" style="color:{{ $extend['descSecondaryColor'] }}">{{ $extend['descSecondary'] }}</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Button --}}
            @if ($extend['btnName'])
                <div class="position-absolute top-50 end-0 translate-middle-y">
                    <a href="#" role="button" class="btn btn-info btn-sm me-3" style="background-color:{{ $extend['btnColor'] }};border-color:{{ $extend['btnColor'] }}">{{ $extend['btnName'] }}</a>
                </div>
            @endif

            @if ($extend['accessUrl'])
                <a class="text-decoration-none stretched-link" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="post"
                    data-scene="extendBox"
                    data-post-message-key="fresnsPostExtendBox"
                    data-pid="{{ $pid }}"
                    data-uid="{{ $author['uid'] }}"
                    data-title="{{ $extend['title'] }}"
                    data-url="{{ $extend['accessUrl'] }}">
                </a>
            @endif
        </div>
    @endforeach
@endif
