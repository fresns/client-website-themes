@extends('commons.fresns')

@section('title', fs_db_config('menu_account_settings'))

@php
    use App\Helpers\ConfigHelper;

    $dateFormat = ConfigHelper::fresnsConfigDateFormat(current_lang_tag());
@endphp

@section('content')
    <div class="d-lg-flex align-items-lg-start">
        <div class="nav nav-pills flex-lg-column @desktop w-25 @else border-bottom mb-4 @enddesktop" id="settings-tabs" role="tablist" aria-orientation="vertical">
            <div class="mx-3 mt-3 d-none d-lg-block">
                <h1 class="fs-5">{{ fs_db_config('menu_account_settings') }}</h1>
            </div>
            <button class="nav-link text-start rounded-0 py-3 px-2 px-lg-3 active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">{{ fs_lang('settingGeneral') }}</button>
            <button class="nav-link text-start rounded-0 py-3 px-2 px-lg-3" id="preference-tab" data-bs-toggle="pill" data-bs-target="#preference" type="button" role="tab" aria-controls="preference" aria-selected="false">{{ fs_lang('settingPreference') }}</button>
            <button class="nav-link text-start rounded-0 py-3 px-2 px-lg-3" id="account-tab" data-bs-toggle="pill" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">{{ fs_lang('settingAccount') }}</button>
            @if (fs_api_config('account_delete_status'))
                <button class="nav-link text-start rounded-0 py-3 px-2 px-lg-3" id="delete-tab" data-bs-toggle="pill" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">{{ fs_lang('accountDelete') }}</button>
            @endif
            {{-- Recall Delete --}}
            @if (fs_account('detail.waitDelete'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">{{ fs_lang('accountWaitDelete') }}</h4>
                    <p>{{ fs_lang('executionDate') }}: {{ fs_account('detail.waitDeleteDateTime') }}</p>
                    <hr>
                    <form class="api-request-form" action="{{ route('fresns.api.account.recall.delete') }}" method="post">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit">{{ fs_lang('accountRecallDelete') }}</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="tab-content border-start ps-lg-5 pb-5 account-settings px-3" id="settings-tab-content">
            {{-- Profile --}}
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="my-3 d-none d-lg-block">
                    <h1 class="fs-5">{{ fs_lang('settingGeneral') }}</h1>
                </div>
                {{-- Avatar --}}
                <div class="input-group mb-3">
                    <div class="position-relative m-auto">
                        <img src="{{ fs_user('detail.avatar') }}" loading="lazy" class="rounded-circle" style="width:8rem;height:8rem;">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <label class="btn btn-light" type="button" for="uploadAvatar"><i class="fa-solid fa-camera"></i></label>
                            <input type="file"
                                id="uploadAvatar"
                                name="uploadAvatar"
                                hidden="hidden"
                                accept="{{ fs_user_panel('fileAccept.images') }}"
                                data-upload-action="{{ route('fresns.api.upload.file') }}"
                                data-edit-action="{{ route('fresns.api.user.edit') }}"
                                data-type="image"
                                data-usageType="5"
                                data-tableName="users"
                                data-tableColumn="avatar_file_id"
                                data-tableKey="{{ fs_user('detail.uid') }}"
                                data-uploadMode="file"
                            >
                        </div>
                    </div>
                </div>
                {{-- User Number --}}
                {{-- <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('user_uid_name') }}</span>
                    <span class="form-control">{{ fs_user('detail.uid') }}</span>
                </div> --}}
                {{-- Nickname --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('user_nickname_name') }}</span>
                    <span class="form-control" id="input-nickname">{{ fs_user('detail.nickname') }}</span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_db_config('user_nickname_name') }}"
                        data-desc="{{ fs_lang('settingIntervalDays') }}: {{ fs_api_config('nickname_edit') }} {{ fs_lang('modifierDays') }} | {{ fs_lang('settingLastTime') }}: {{ fs_user('detail.lastEditNickname') }}"
                        data-name="nickname"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.nickname') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">{{ fs_lang('modify') }}</button>
                </div>
                {{-- Username --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('user_username_name') }}</span>
                    <span class="form-control" id="input-username">{{ fs_user('detail.username') }}</span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_db_config('user_username_name') }}"
                        data-desc="{{ fs_lang('settingIntervalDays') }}: {{ fs_api_config('username_edit') }} {{ fs_lang('modifierDays') }} | {{ fs_lang('settingLastTime') }}: {{ fs_user('detail.lastEditUsername') }}<br>{{ fs_lang('modifierLength') }}: {{ fs_api_config('username_min') }} - {{ fs_api_config('username_max') }}<br>{{ fs_lang('settingNameWarning') }}"
                        data-name="username"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.username') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">{{ fs_lang('modify') }}</button>
                </div>
                {{-- Bio --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('user_bio_name') }}</span>
                    <span class="form-control" id="textarea-bio">{{ fs_user('detail.bio') }}</span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_db_config('user_bio_name') }}"
                        data-type="textarea"
                        @if (fs_api_config('bio_support_mention') || fs_api_config('bio_support_hashtag'))
                            data-input-tips="fresns-content"
                        @endif
                        data-name="bio"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.bio') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">{{ fs_lang('modify') }}</button>
                </div>
                {{-- Gender --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('userGender') }}</span>
                    <span class="form-control" id="select-gender">
                        @if (fs_user('detail.gender') === 1)
                            {{ fs_lang('settingGenderNull') }}
                        @elseif(fs_user('detail.gender') === 2)
                            {{ fs_lang('settingGenderMale') }}
                        @elseif(fs_user('detail.gender') === 3)
                            {{ fs_lang('settingGenderFemale') }}
                        @endif
                    </span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_lang('userGender') }}"
                        data-type="select"
                        data-option='[{"id":1,"text":"{{ fs_lang('settingGenderNull') }}"},{"id":2,"text":"{{ fs_lang('settingGenderMale') }}"},{"id":3,"text":"{{ fs_lang('settingGenderFemale') }}"}]'
                        data-name="gender"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.gender') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">{{ fs_lang('modify') }}</button>
                </div>
                {{-- Birthday --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('userBirthday') }}</span>
                    <span class="form-control" id="input-birthday">{{ date($dateFormat, strtotime(fs_user('detail.birthday'))) }}</span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_lang('userBirthday') }}"
                        data-type="date"
                        data-name="birthday"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.birthday') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">{{ fs_lang('modify') }}</button>
                </div>
            </div>

            {{-- Preference --}}
            <div class="tab-pane fade" id="preference" role="tabpanel" aria-labelledby="preference-tab" tabindex="0">
                <div class="my-3 d-none d-lg-block">
                    <h1 class="fs-5">{{ fs_lang('settingPreference') }}</h1>
                </div>
                {{-- Conversation --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('menu_conversations') }}</span>
                    <span class="form-control" id="select-conversationLimit">
                        @if (fs_user('detail.conversationLimit') == 1)
                            {{ fs_lang('settingAllowAll') }}
                        @elseif(fs_user('detail.conversationLimit') == 2)
                            {{ fs_lang('settingAllowMyFollow') }}
                        @elseif(fs_user('detail.conversationLimit') == 3)
                            {{ fs_lang('settingAllowMyFollowAndVerified') }}
                        @elseif(fs_user('detail.conversationLimit') == 4)
                            {{ fs_lang('settingAllowNotAll') }}
                        @endif
                    </span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_db_config('menu_conversations') }}"
                        data-type="select"
                        data-option='[{"id":1,"text":"{{ fs_lang('settingAllowAll') }}"},{"id":2,"text":"{{ fs_lang('settingAllowMyFollow') }}"},{"id":3,"text":"{{ fs_lang('settingAllowMyFollowAndVerified') }}"},{"id":4,"text":"{{ fs_lang('settingAllowNotAll') }}"}]'
                        data-name="conversationLimit"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.conversationLimit') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                        {{ fs_lang('modify') }}
                    </button>
                </div>
                {{-- Comment --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_db_config('comment_name') }}</span>
                    <span class="form-control" id="select-commentLimit">
                        @if (fs_user('detail.commentLimit') == 1)
                            {{ fs_lang('settingAllowAll') }}
                        @elseif(fs_user('detail.commentLimit') == 2)
                            {{ fs_lang('settingAllowMyFollow') }}
                        @elseif(fs_user('detail.commentLimit') == 3)
                            {{ fs_lang('settingAllowMyFollowAndVerified') }}
                        @elseif(fs_user('detail.commentLimit') == 4)
                            {{ fs_lang('settingAllowNotAll') }}
                        @endif
                    </span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_db_config('comment_name') }}"
                        data-type="select"
                        data-option='[{"id":1,"text":"{{ fs_lang('settingAllowAll') }}"},{"id":2,"text":"{{ fs_lang('settingAllowMyFollow') }}"},{"id":3,"text":"{{ fs_lang('settingAllowMyFollowAndVerified') }}"},{"id":4,"text":"{{ fs_lang('settingAllowNotAll') }}"}]'
                        data-name="commentLimit"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.commentLimit') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                        {{ fs_lang('modify') }}
                    </button>
                </div>
                {{-- Timezone --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('userTimeZone') }}</span>
                    <span class="form-control" id="select-timezone">
                        UTC {{ fs_user('detail.timezone') }}
                    </span>
                    <button class="btn btn-outline-secondary"
                        data-lable="{{ fs_lang('userTimeZone') }}"
                        data-type="select"
                        data-option="{{ json_encode(array_map(function ($val){ return ['id' => $val['value'], 'text' => $val['name']]; }, fs_api_config('utc')), true) }}"
                        data-name="timezone"
                        data-action="{{ route('fresns.api.user.edit') }}"
                        data-value="{{ fs_user('detail.timezone') }}"
                        type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                        {{ fs_lang('modify') }}
                    </button>
                </div>
            </div>

            {{-- Account Settings --}}
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab" tabindex="0">
                <div class="my-3 d-none d-lg-block">
                    <h1 class="fs-5">{{ fs_lang('settingAccount') }}</h1>
                </div>
                {{-- Account ID --}}
                {{-- <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('account') }} ID</span>
                    <span class="form-control">{{ fs_account('detail.aid') }}</span>
                </div> --}}
                {{-- Real Name --}}
                @if (fs_api_config('account_real_name_service'))
                    <div class="input-group mb-3">
                        <span class="input-group-text">{{ fs_lang('accountRealName') }}</span>
                        <span class="form-control">{{ fs_account('detail.verifyStatus') ? fs_lang('success') : fs_lang('settingNot') }}</span>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                            data-type="account"
                            data-scene="realName"
                            data-post-message-key="fresnsRealName"
                            data-title="{{ fs_lang('accountRealName') }}"
                            data-url="{{ fs_api_config('account_real_name_service') }}">
                            {{ fs_lang('accountRealName') }}
                        </button>
                    </div>
                @endif
                {{-- Phone Number --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('phone') }}</span>
                    @if (fs_api_config('send_sms_service'))
                        @if (empty(fs_account('detail.phone')))
                            <span class="form-control" id="input-editPhone">{{ fs_lang('settingNot') }}</span>
                            <button class="btn btn-outline-secondary"
                                data-lable="{{ fs_lang('phone') }}"
                                data-sms-codes="{{ json_encode(fs_api_config('send_sms_supported_codes'), true) }}"
                                data-default-sms-code="{{ fs_account('detail.countryCode') ?: fs_api_config('send_sms_default_code') }}"
                                data-name="editPhone"
                                data-action="{{ route('fresns.api.account.edit') }}"
                                type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                                {{ fs_lang('setting') }}
                            </button>
                        @else
                            <span class="form-control" id="input-editPhone">+{{ fs_account('detail.countryCode') }} {{ fs_account('detail.purePhone') }}</span>
                            <button class="btn btn-outline-secondary"
                                data-lable="{{ fs_lang('phone') }}"
                                data-desc="{{ fs_lang('settingWarning') }}"
                                data-sms-codes="{{ json_encode(fs_api_config('send_sms_supported_codes'), true) }}"
                                data-default-sms-code="{{ fs_account('detail.countryCode') ?: fs_api_config('send_sms_default_code') }}"
                                data-name="editPhone"
                                data-action="{{ route('fresns.api.account.edit') }}"
                                data-value="{{ fs_account('detail.phone') }}"
                                type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                                {{ fs_lang('modify') }}
                            </button>
                        @endif
                    @endif
                </div>
                {{-- Email --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('email') }}</span>
                    @if (fs_api_config('send_email_service'))
                        @if (empty(fs_account('detail.email')))
                            <span class="form-control" id="input-editEmail">{{ fs_lang('settingNot') }}</span>
                            <button class="btn btn-outline-secondary"
                                data-lable="{{ fs_lang('email') }}"
                                data-name="editEmail"
                                data-action="{{ route('fresns.api.account.edit') }}"
                                type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                                {{ fs_lang('setting') }}
                            </button>
                        @else
                            <span class="form-control" id="input-editEmail">{{ fs_account('detail.email') }}</span>
                            <button class="btn btn-outline-secondary"
                                data-lable="{{ fs_lang('email') }}"
                                data-desc="{{ fs_lang('settingWarning') }}"
                                data-name="editEmail"
                                data-action="{{ route('fresns.api.account.edit') }}"
                                data-value="{{ fs_account('detail.email') }}"
                                type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                                {{ fs_lang('modify') }}
                            </button>
                        @endif
                    @endif
                </div>
                {{-- Account Password --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('accountPassword') }}</span>
                    @if (fs_account('detail.hasPassword'))
                        <span class="form-control" id="input-editPassword">{{ fs_lang('settingAlready') }}</span>
                        <button class="btn btn-outline-secondary"
                            data-lable="{{ fs_lang('accountPassword') }}"
                            data-name="editPassword"
                            data-type="input"
                            data-email="{{ fs_account('detail.email') }}"
                            data-value="{{ fs_account('detail.password') }}"
                            data-phone="{{ fs_account('detail.phone') }}"
                            data-action="{{ route('fresns.api.account.edit') }}"
                            type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                            {{ fs_lang('modify') }}
                        </button>
                    @else
                        <span class="form-control" id="input-editPassword">{{ fs_lang('settingNot') }}</span>
                        <button class="btn btn-outline-secondary"
                            data-lable="{{ fs_lang('accountPassword') }}"
                            data-name="editPassword"
                            data-value="{{ fs_account('detail.password') }}"
                            data-type="input"
                            data-email="{{ fs_account('detail.email') }}"
                            data-phone="{{ fs_account('detail.phone') }}"
                            data-action="{{ route('fresns.api.account.edit') }}"
                            type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                            {{ fs_lang('setting') }}
                        </button>
                    @endif
                </div>
                {{-- Wallet Password --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ fs_lang('walletPassword') }}</span>
                    @if (fs_account('detail.wallet.hasPassword'))
                        <span class="form-control" id="input-editWalletPassword">{{ fs_lang('settingAlready') }}</span>
                        <button class="btn btn-outline-secondary"
                            data-lable="{{ fs_lang('walletPassword') }}"
                            data-name="editWalletPassword"
                            data-value="{{ fs_account('detail.wallet.password') }}"
                            data-type="input"
                            data-email="{{ fs_account('detail.email') }}"
                            data-phone="{{ fs_account('detail.phone') }}"
                            data-action="{{ route('fresns.api.account.edit') }}"
                            type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                            {{ fs_lang('modify') }}
                        </button>
                    @else
                        <span class="form-control" id="input-editWalletPassword">{{ fs_lang('settingNot') }}</span>
                        <button class="btn btn-outline-secondary"
                            data-lable="{{ fs_lang('walletPassword') }}"
                            data-name="editWalletPassword"
                            data-value="{{ fs_account('detail.wallet.password') }}"
                            data-type="input"
                            data-email="{{ fs_account('detail.email') }}"
                            data-phone="{{ fs_account('detail.phone') }}"
                            data-action="{{ route('fresns.api.account.edit') }}"
                            type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                            {{ fs_lang('setting') }}
                        </button>
                    @endif
                </div>

                {{-- Account Connects --}}
                @if (fs_api_config('account_connect_services'))
                    <div class="card mb-3">
                        <div class="card-header">{{ fs_lang('settingConnect') }}</div>

                        <ul class="list-group list-group-flush">
                            @foreach(fs_api_config('account_connect_services') as $service)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <img src="/assets/themes/Moments/images/connects/{{ $service['code'] }}.png" loading="lazy" height="32">

                                    @if (fs_account('detail.connects'))
                                        @foreach(fs_account('detail.connects') as $item)
                                            @if ($item['connectId'] === intval($service['code']))
                                                {{ $item['nickname'] }}
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                                    data-type="account"
                                                    data-scene="connect"
                                                    data-post-message-key="fresnsConnect"
                                                    data-aid="{{ fs_account('detail.aid') }}"
                                                    data-uid="{{ fs_user('detail.uid') }}"
                                                    data-title="{{ fs_lang('settingConnect') }}: {{ $service['code'] }}"
                                                    data-url="{{ $service['url'] }}">
                                                    {{ fs_lang('settingConnectRemove') }}
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                                    data-type="account"
                                                    data-scene="connect"
                                                    data-post-message-key="fresnsConnect"
                                                    data-aid="{{ fs_account('detail.aid') }}"
                                                    data-uid="{{ fs_user('detail.uid') }}"
                                                    data-title="{{ fs_lang('settingConnect') }}: {{ $service['code'] }}"
                                                    data-url="{{ $service['url'] }}">
                                                    {{ fs_lang('settingConnectAdd') }}
                                                </button>
                                            @endif
                                        @endforeach
                                    @else
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                            data-type="account"
                                            data-scene="connect"
                                            data-post-message-key="fresnsConnect"
                                            data-aid="{{ fs_account('detail.aid') }}"
                                            data-uid="{{ fs_user('detail.uid') }}"
                                            data-title="{{ fs_lang('settingConnect') }}: {{ $service['code'] }}"
                                            data-url="{{ $service['url'] }}">
                                            {{ fs_lang('settingConnectAdd') }}
                                        </button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @endif
            </div>

            {{-- Delete Account --}}
            <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab" tabindex="0">
                <div class="my-3 d-none d-lg-block">
                    <h1 class="fs-5">{{ fs_lang('accountDelete') }}</h1>
                </div>
                <div>
                    {!! fs_api_config('account_delete') ? Str::markdown(fs_api_config('account_delete')) : '' !!}
                </div>
                @if (! fs_account('detail.waitDelete') && fs_api_config('delete_account_type') != 1)
                    <hr>
                    <form class="api-request-form" action="{{ route('fresns.api.account.apply.delete') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header">{{ fs_lang('accountApplyDelete') }}</div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-end-rounded-0">{{ fs_lang('type') }}</span>
                                    <div class="form-control">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input collapse show" type="radio" name="codeType" id="email_code_apply" value="email" data-bs-toggle="collapse" data-bs-target=".email_code_apply:not(.show)" aria-expanded="true" checked>
                                            <label class="form-check-label" for="email_code_apply">{{ fs_lang('emailVerifyCode') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input collapse show collapsed" type="radio" name="codeType" id="phone_code_apply" value="sms" data-bs-toggle="collapse" data-bs-target=".phone_code_apply:not(.show)" aria-expanded="false">
                                            <label class="form-check-label" for="phone_code_apply">{{ fs_lang('smsVerifyCode') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="apply_delete_mode">
                                    <div class="collapse email_code_apply show" aria-labelledby="email_code_apply" data-bs-parent="#apply_delete_mode">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text border-end-rounded-0">{{ fs_lang('email') }}</span>
                                            <input class="form-control" type="text" placeholder="{{ fs_account('detail.email') }}" value="{{ fs_account('detail.email') }}" disabled>
                                            <button class="btn btn-outline-secondary send-verify-code"
                                                data-type="email"
                                                data-use-type="4"
                                                data-template-id="8"
                                                data-action="{{ route('fresns.api.send.verify.code') }}"
                                                onclick="sendVerifyCode(this)"
                                                @empty(fs_account('detail.email')) disabled @endempty
                                                type="button">
                                                {{ fs_lang('sendVerifyCode') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="collapse phone_code_apply" aria-labelledby="phone_code_apply" data-bs-parent="#apply_delete_mode">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text border-end-rounded-0">{{ fs_lang('phone') }}</span>
                                            <input class="form-control" type="text" placeholder="{{ fs_account('detail.phone') }}" value="{{ fs_account('detail.phone') }}" disabled>
                                            <button class="btn btn-outline-secondary send-verify-code"
                                                data-type="sms"
                                                data-use-type="4"
                                                data-template-id="8"
                                                data-action="{{ route('fresns.api.send.verify.code') }}"
                                                onclick="sendVerifyCode(this)"
                                                @empty(fs_account('detail.phone')) disabled @endempty
                                                type="button">
                                                {{ fs_lang('sendVerifyCode') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-end-rounded-0">{{ fs_lang('verifyCode') }}</span>
                                    <input type="text" class="form-control" name="verifyCode">
                                </div>

                                {{-- button --}}
                                <div class="text-center">
                                    <button class="btn btn-outline-danger" type="submit">{{ fs_lang('submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade user-edit" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">{{ fs_lang('errorUnavailable') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center my-4"><a class="btn btn-outline-primary btn-sm" href="javascript:location.reload();" role="button">{{ fs_lang('refresh') }}</a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ fs_lang('close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ fs_lang('confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var activeTab = window.location.hash.substring(1);
            if (!activeTab) {
                activeTab = 'profile-tab';
            }
            $('#' + activeTab).tab('show');
            document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

            $('#settings-tabs button').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
@endpush