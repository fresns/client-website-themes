@if (count($config['maps']) > 1)
    <div class="dropup me-auto">
        <button class="btn btn-outline-dark btn-sm" type="button" id="location" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-geo-alt-fill"></i> {{ fs_lang('editorLocation') }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="location">
            @foreach($config['maps'] as $map)
                <li>
                    <a class="dropdown-item" role="button" data-bs-toggle="modal" href="#fresnsModal"
                        data-type="editor"
                        data-scene="{{ $type.'Editor' }}"
                        data-post-message-key="fresnsLocation"
                        data-title="{{ $map['name'] }}"
                        data-url="{{ $map['url'] }}">
                        <img src="{{ $map['icon'] }}" loading="lazy" width="20" height="20">
                        {{ $map['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    @foreach($config['maps'] as $map)
        <button class="btn btn-outline-dark btn-sm" type="button" id="location" data-bs-toggle="modal" data-bs-target="#fresnsModal"
            data-type="editor"
            data-scene="{{ $type.'Editor' }}"
            data-post-message-key="fresnsLocation"
            data-title="{{ $map['name'] }}"
            data-url="{{ $map['url'] }}">
            <i class="bi bi-geo-alt-fill"></i> {{ fs_lang('editorLocation') }}
        </button>
    @endforeach
@endif
