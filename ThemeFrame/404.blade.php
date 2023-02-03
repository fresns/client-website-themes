@extends('commons.fresns')

@section('title', '404 - Page Not Found')

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    <h3 class="card-title">404 <span class="fs-8 ms-2">Page Not Found</span></h3>
                    <p><img src="/assets/themes/ThemeFrame/images/robot.png" loading="lazy" alt="404" style="max-width: 100%;"></p>
                </div>
            </div>
        </div>
    </main>
@endsection
