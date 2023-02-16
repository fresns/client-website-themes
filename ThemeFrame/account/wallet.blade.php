@extends('commons.fresns')

@section('title', fs_db_config('menu_account_wallet'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Account Content --}}
            <div class="col-sm-9">
                <div class="card hstack p-3 mb-3">
                    <div class="">{{ fs_account('detail.wallet.currencyCode') }} {{ fs_account('detail.wallet.balance') }}</div>
                    <div class="vr mx-3"></div>
                    <div class="btn-group">
                        @if (fs_account('items.walletRecharges'))
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ fs_lang('walletRecharge') }}</button>
                            <ul class="dropdown-menu">
                                @foreach(fs_account('items.walletRecharges') as $item)
                                    <li>
                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                            data-type="account"
                                            data-scene="walletRecharge"
                                            data-post-message-key="fresnsWalletRecharge"
                                            data-aid="{{ fs_account('detail.aid') }}"
                                            data-uid="{{ fs_user('detail.uid') }}"
                                            data-title="{{ $item['name'] }}"
                                            data-url="{{ $item['url'] }}">
                                            {{ $item['name'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <button type="button" class="btn btn-primary" disabled>{{ fs_lang('walletRecharge') }}</button>
                        @endif
                    </div>
                    <div class="vr mx-3"></div>
                    <div class="btn-group">
                        @if (fs_account('items.walletWithdraws'))
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ fs_lang('walletWithdraw') }}</button>
                            <ul class="dropdown-menu">
                                @foreach(fs_account('items.walletWithdraws') as $item)
                                    <li>
                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                            data-type="account"
                                            data-scene="walletWithdraw"
                                            data-post-message-key="fresnsWalletWithdraw"
                                            data-aid="{{ fs_account('detail.aid') }}"
                                            data-uid="{{ fs_user('detail.uid') }}"
                                            data-title="{{ $item['name'] }}"
                                            data-url="{{ $item['url'] }}">
                                            {{ $item['name'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <button type="button" class="btn btn-primary" disabled>{{ fs_lang('walletWithdraw') }}</button>
                        @endif
                    </div>
                </div>

                {{-- Transaction History --}}
                <div class="card">
                    <div class="card-header">
                        {{ fs_lang('walletLogs') }}
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </main>
@endsection
