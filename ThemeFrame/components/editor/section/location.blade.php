@if ($geotag || $locationInfo)
    @php
        $name = ($geotag['name'] ?: '') ?? $locationInfo['name'];
    @endphp

    <div class="dropup me-auto" id="location-info">
        <button class="btn btn-outline-dark btn-sm" type="button" id="editorLocation" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-geo-alt-fill"></i> {{ $name }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="location">
            <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $locationConfig['mapUrl'] ? '' : fs_lang('errorUnavailable') }}">
                <a class="dropdown-item py-2 {{ $locationConfig['mapUrl'] ? '' : 'disabled' }}" role="button" data-bs-toggle="modal" href="#fresnsModal"
                    data-type="editor"
                    data-scene="{{ $type.'Editor' }}"
                    data-post-message-key="fresnsEditorLocation"
                    data-did="{{ $did }}"
                    data-title="{{ fs_lang('editorLocation') }}"
                    data-location-info="{{ ($geotag['latitude'] && $geotag['longitude']) ? $geotag['mapId'].','.$geotag['latitude'].','.$geotag['longitude'].','.$geotag['scale'] : '' }}"
                    data-url="{{ $locationConfig['mapUrl'] }}">
                    {{ fs_lang('reselect') }}
                </a>
            </li>
            <li><a class="dropdown-item link-danger py-2" role="button" href="#" onclick="deleteLocation(this)">{{ fs_lang('delete') }}</a></li>
        </ul>
    </div>
@else
    @if ($locationConfig['mapUrl'])
        <button class="btn btn-outline-dark btn-sm" type="button" id="location-btn"
            data-bs-toggle="modal"
            data-bs-target="#fresnsModal"
            data-type="editor"
            data-scene="{{ $type.'Editor' }}"
            data-post-message-key="fresnsEditorLocation"
            data-did="{{ $did }}"
            data-title="{{ fs_lang('editorLocation') }}"
            data-location-info=""
            data-url="{{ $locationConfig['mapUrl'] }}">
            <i class="bi bi-geo-alt-fill"></i> {{ fs_lang('editorLocation') }}
        </button>
    @endif
@endif
