@extends('commons.fresns')

@section('title', fs_lang('userExtcreditsLogs'))

@section('content')
    <div class="card rounded-0">
        <div class="card-header">
            @desktop
                <span class="me-2">
                    <a class="btn btn-outline-secondary border-0 rounded-circle" href="javascript:goBack()" role="button"><i class="fa-solid fa-arrow-left"></i></a>
                </span>
            @enddesktop

            @if ($extcreditsId)
                {{ fs_config("extcredits{$extcreditsId}_name") }}
            @else
                {{ fs_lang('userExtcreditsLogs') }}
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead>
                        <tr class="table-info">
                            @empty($extcreditsId)
                                <th scope="col">{{ fs_lang('userExtcreditsLogName') }}</th>
                            @endempty
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
                                @empty($extcreditsId)
                                    <th scope="row">{{ fs_config("extcredits{$log['extcreditsId']}_name") }}</th>
                                @endempty
                                <td title="{{ $log['type'] }}">{{ $log['type'] == 'increment' ? '+' : '-' }}{{ $log['amount'] }}</td>
                                <td>{{ $log['openingAmount'] }}</td>
                                <td>{{ $log['closingAmount'] }}</td>
                                <td>{{ $log['fskey'] }}</td>
                                <td>{{ $log['remark'] }}</td>
                                <td>
                                    <time class="text-secondary" datetime="{{ $log['datetime'] }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $log['datetime'] }}">
                                        {{ $log['timeAgo'] }}
                                    </time>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="my-3 table-responsive">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
