@if ($location['latitude'] ?? null && $location['longitude'] ?? null)
    <div class="dropup me-auto" id="location-info">
        <button class="btn btn-outline-dark btn-sm" type="button" id="editorLocation" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-geo-alt-fill"></i> {{ $location['poi'] }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="location">
            <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $config['map'] ? '' : fs_lang('errorUnavailable') }}">
                <a class="dropdown-item py-2 {{ $config['map'] ? '' : 'disabled' }}" role="button" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    data-post-message-key="fresnsEditorLocation"
                    @if ($type == 'post')
                        data-plid="{{ $plid }}"
                    @else
                        data-clid="{{ $clid }}"
                    @endif
                    data-title="{{ fs_lang('editorLocation') }}"
                    data-location-info="{{ ($location['latitude'] && $location['longitude']) ? $location['mapId'].','.$location['latitude'].','.$location['longitude'].','.$location['scale'] : '' }}"
                    data-url="{{ $config['map'] }}">
                    {{ fs_lang('reselect') }}
                </a>
            </li>
            <li><a class="dropdown-item link-danger py-2" role="button" href="#" onclick="deleteMap(this)">{{ fs_lang('delete') }}</a></li>
        </ul>
    </div>
@endif

@if ($config['map'])
    <button class="btn btn-outline-dark btn-sm" type="button" id="location-btn"
        {{ ($location['latitude'] ?? null && $location['longitude'] ?? null) ? 'style="display:none"' : '' }}
        data-bs-toggle="modal"
        data-bs-target="#fresnsModal"
        data-type="editor"
        data-scene="{{ $type.'Editor' }}"
        data-post-message-key="fresnsEditorLocation"
        @if ($type == 'post')
            data-plid="{{ $plid }}"
        @else
            data-clid="{{ $clid }}"
        @endif
        data-title="{{ fs_lang('editorLocation') }}"
        data-location-info=""
        data-url="{{ $config['map'] }}">
        <i class="bi bi-geo-alt-fill"></i> {{ fs_lang('editorLocation') }}
    </button>
@endif
