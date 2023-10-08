@extends('commons.fresns')

@section('title', fs_lang('userExtcreditsLogs'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Account Main --}}
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">
                        {{ fs_lang('userExtcreditsLogs') }}
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle text-nowrap">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">{{ fs_lang('userExtcreditsLogName') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogType') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogAmount') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogOpeningAmount') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogClosingAmount') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogPlugin') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogRemark') }}</th>
                                    <th scope="col">{{ fs_lang('userExtcreditsLogTime') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <th scope="row">{{ $log['extcreditsId'] }}</th>
                                        <td>{{ $log['type'] }}</td>
                                        <td>{{ $log['type'] == 'increment' ? '+' : '-' }}{{ $log['amount'] }}</td>
                                        <td>{{ $log['openingAmount'] }}</td>
                                        <td>{{ $log['closingAmount'] }}</td>
                                        <td>{{ $log['fskey'] }}</td>
                                        <td>{{ $log['remark'] }}</td>
                                        <td>
                                            <time class="text-secondary" datetime="{{ $log['createdDatetime'] }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $log['createdDatetime'] }}">
                                                {{ $log['createdTimeAgo'] }}
                                            </time>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="my-3 table-responsive">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
