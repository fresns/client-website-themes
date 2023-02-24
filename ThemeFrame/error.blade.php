@extends('commons.fresns')

@section('title', $code)

@php
    use App\Helpers\ConfigHelper;

    $email = ConfigHelper::fresnsConfigByItemKey('site_email');

    $codeArr = [31501, 31502, 31503, 31504, 31505, 31601, 31602, 31603];
@endphp

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">Fresns {{ $code }}</h3>
                    <p>{{ $message }}</p>
                    <p class="mt-4">Administrator Email: <a href="mailto:{{ $email }}">{{ $email }}</a></p>

                    @if (in_array($code, $codeArr))
                        <a class="btn btn-outline-success btn-sm mt-4 clear-cookie" href="#" data-method="DELETE" data-action="{{ route('panel.clear.web.cookie') }}">Clear Cookie</a>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        /* Fresns Token */
        $.ajaxSetup({
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $(document).ready(function () {
            $(document).on('click', '.clear-cookie', function (e) {
                e.preventDefault();
                $(this).prop('disabled', true);
                $(this).prepend(
                    '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
                );

                const url = $(this).data('action'),
                    type = $(this).data('method') || 'POST',
                    btn = $(this);

                $.ajax({
                    url,
                    type,
                    complete: function (e) {
                        location.reload();
                    },
                });
            });
        });
    </script>
@endpush
