@if (fs_api_config('conversation_status'))
    @if ($user['conversation']['status'])
        <form action="{{ route('fresns.api.message.send') }}" method="post">
            @csrf
            <input type="hidden" name="uidOrUsername" value="{{ $user['fsid'] }}"/>

            <div id="send-box" class="input-group">
                {{-- Send File --}}
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ fs_lang('file') }}</button>

                <input type="hidden" name="fid"/>

                <ul class="dropdown-menu">
                    @if(in_array('image', fs_api_config('conversation_files', [])))
                        <li><label class="dropdown-item" for="messageImage" style="cursor:pointer;"><i class="bi bi-image"></i> {{ fs_lang('image') }}</label></li>
                        <input id="messageImage" hidden="hidden" type="file"
                            name="messageImage"
                            accept="{{ $userPanel['fileAccept']['images'] }}"
                            data-upload-action="{{ route('fresns.api.upload.file') }}"
                            data-send-action="{{ route('fresns.api.message.send') }}"
                            data-type="image"
                            data-usagetype="6"
                            data-tablename="conversation_messages"
                            data-tablecolumn="message_file_id"
                            data-tablekey="{{ $user['fsid'] }}"
                            data-uploadmode="file">
                    @endif

                    @if(in_array('video', fs_api_config('conversation_files', [])))
                        <li><label class="dropdown-item" for="messageVideo" style="cursor:pointer;"><i class="bi bi-film"></i> {{ fs_lang('video') }}</label></li>
                        <input id="messageVideo" hidden="hidden" type="file"
                            name="messageVideo"
                            accept="{{ $userPanel['fileAccept']['videos'] }}"
                            data-upload-action="{{ route('fresns.api.upload.file') }}"
                            data-send-action="{{ route('fresns.api.message.send') }}"
                            data-type="video"
                            data-usagetype="6"
                            data-tablename="conversation_messages"
                            data-tablecolumn="message_file_id"
                            data-tablekey="{{ $user['fsid'] }}"
                            data-uploadmode="file">
                    @endif

                    @if(in_array('audio', fs_api_config('conversation_files', [])))
                        <li><label class="dropdown-item" for="messageAudio" style="cursor:pointer;"><i class="bi bi-music-note-beamed"></i> {{ fs_lang('audio') }}</label></li>
                        <input id="messageAudio" hidden="hidden" type="file"
                            name="messageAudio"
                            accept="{{ $userPanel['fileAccept']['audios'] }}"
                            data-upload-action="{{ route('fresns.api.upload.file') }}"
                            data-send-action="{{ route('fresns.api.message.send') }}"
                            data-type="audio"
                            data-usagetype="6"
                            data-tablename="conversation_messages"
                            data-tablecolumn="message_file_id"
                            data-tablekey="{{ $user['fsid'] }}"
                            data-uploadmode="file">
                    @endif

                    @if(in_array('document', fs_api_config('conversation_files', [])))
                        <li><label class="dropdown-item" for="messageDocument" style="cursor:pointer;"><i class="bi bi-file-earmark-text"></i> {{ fs_lang('document') }}</label></li>
                        <input id="messageDocument" hidden="hidden" type="file"
                            name="messageDocument"
                            accept="{{ $userPanel['fileAccept']['documents'] }}"
                            data-upload-action="{{ route('fresns.api.upload.file') }}"
                            data-send-action="{{ route('fresns.api.message.send') }}"
                            data-type="document"
                            data-usagetype="6"
                            data-tablename="conversation_messages"
                            data-tablecolumn="message_file_id"
                            data-tablekey="{{ $user['fsid'] }}"
                            data-uploadmode="file">
                    @endif
                </ul>

                {{-- Send Text --}}
                <textarea name="message" class="form-control"></textarea>
                <button class="btn btn-outline-secondary api-request-form" type="button">{{ fs_lang('send') }}</button>
            </div>
        </form>
    @else
        <div class="input-group">
            <textarea name="message" class="form-control pt-4" disabled>{{ $user['conversation']['message'] }}</textarea>
            <button class="btn btn-outline-secondary" type="button" disabled>{{ fs_lang('send') }}</button>
        </div>
    @endif
@else
    <div class="input-group">
        <textarea name="message" class="form-control pt-4" disabled>{{ fs_code_message(36600) }}</textarea>
        <button class="btn btn-outline-secondary" type="button" disabled>{{ fs_lang('send') }}</button>
    </div>
@endif
