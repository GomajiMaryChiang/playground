@if (!empty($hotKeywordList))
    <div class="top-hot-category">
        <h3 class="t-gray">熱門關鍵字</h3>
        <ul class="clearfix">
            @foreach ($hotKeywordList as $hotKeyword)
                @if (!empty($hotKeyword['keyword']) && !empty($hotKeyword['display_name']))
                    <li class="hot-category-item">
                        <a href="{{ url('/search?keyword=' . urlencode($hotKeyword['keyword'])) }}">{{ $hotKeyword['display_name'] }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
