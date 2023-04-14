@php
    use \App\Utilities\ArrUtility;

    $title = null;
    $decorate = null;
@endphp

@if ($sticky['operations']['diversifyImages'])
    @php
        $title = ArrUtility::pull($sticky['operations']['diversifyImages'], 'code', 'title');
        $decorate = ArrUtility::pull($sticky['operations']['diversifyImages'], 'code', 'decorate');
    @endphp
@endif

<a href="{{ fs_route(route('fresns.post.detail', ['pid' => $sticky['pid']])) }}" class="list-group-item list-group-item-action text-break px-3 py-2">
    <i class="fa-regular fa-circle-up me-1 text-danger"></i>
    @if ($title)
        <img src="{{ $title['imageUrl'] }}" loading="lazy" alt="{{ $title['name'] }}" style="height: 24px">
    @endif
    {{ $sticky['title'] ?? Str::limit(strip_tags($sticky['content']), 80) }}
</a>
