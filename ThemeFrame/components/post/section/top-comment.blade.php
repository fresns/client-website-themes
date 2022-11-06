<section class="post-top-comment order-5 mx-3 mt-3 position-relative">
    {{-- Title --}}
    <div class="clearfix">
        <span class="badge bg-warning text-dark fs-7">{{ fs_lang('contentTopComment') }}</span>
        <span class="float-end text-secondary">{{ $topComment['likeCount'] }} {{ fs_api_config('like_post_name') }}</span>
    </div>

    {{-- Content --}}
    <div class="mt-2">
        <a href="{{ fs_route(route('fresns.profile.index', ['uidOrUsername' => $topComment['creator']['fsid']])) }}" class="fresns_link">{{ $topComment['creator']['nickname'] }}</a>:
        <a href="{{ fs_route(route('fresns.post.detail', ['pid' => $pid])) }}" class="text-decoration-none link-dark stretched-link">{{ $topComment['content'] }}</a>
    </div>

    {{-- Files Images --}}
    @if ($topComment['files']['images'])
        <div class="d-flex align-content-start flex-wrap comment-image-{{ $topComment['fileCount']['images'] }}">
            @foreach($topComment['files']['images'] as $image)
                <img src="{{ $image['imageSquareUrl'] }}" class="img-fluid">
            @endforeach
        </div>
    @endif
</section>
