@foreach ($recommendList as $recommend)
    @if ($recommend['product_kind'] == 4)
        @include('layouts.product.recommendBanner')
    @else
        @include('layouts.product.recommendProduct')
    @endif
@endforeach