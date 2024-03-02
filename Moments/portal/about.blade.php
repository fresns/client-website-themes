@extends('commons.fresns')

@section('title', fs_lang('accountLoginOrRegister'))

@section('content')
    <div class="m-lg-5 ps-lg-5 pb-lg-5" style="max-width:800px;">
        <div class="card-body p-5">
            {!! Str::markdown(fs_config('site_intro')) !!}
        </div>
    </div>
@endsection
