@extends('commons.fresns')

@section('title', fs_lang('about'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            <div class="card mx-auto" style="max-width:800px;">
                <div class="card-body p-5">
                    {!! Str::markdown(fs_config('site_intro')) !!}
                </div>
            </div>
        </div>
    </main>
@endsection
