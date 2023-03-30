@if (!empty($hotKeywordList))
    <div class="keyword">
        @foreach ($hotKeywordList as $hotKeyword)
            @if (!empty($hotKeyword['keyword']) && !empty($hotKeyword['display_name']))
                <a class="keyword-link" href="{{ url('/search?keyword=' . urlencode($hotKeyword['keyword'])) }}">{{ $hotKeyword['display_name'] }}</a>
            @endif
        @endforeach
    </div>
@endif