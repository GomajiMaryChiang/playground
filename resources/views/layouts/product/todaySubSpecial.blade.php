<div class="product-card border border-r relative">
    <a href="{{ $todaySubSpecial['link'] ?? '#' }}">
        <div class="product-img relative">
            <img class="img-fluid owl-lazy" data-src="{{ $todaySubSpecial['img'][0] ?? '' }}" alt="{{ $todaySubSpecial['store_name'] ?? '' }}">
            @switch ($todaySubSpecial['status'])
                @case('END_SOLDOUT')
                    <div class="sold-out-label">
                        <img class="d-block w-100" src="{{ url('/images/soldout_label.png') }}" alt="搶購一空">
                    </div>
                    @break
                @case('END_TIMEOUT')
                    <div class="sold-out-label">
                        <img class="d-block w-100" src="{{ url('images/close_label.png') }}" alt="已結束">
                    </div>
                    @break
                @case('END_CHARITY')
                    <div class="sold-out-label">
                        <img class="d-block w-100" src="{{ url('images/raise_label.png') }}" alt="募集成功">
                    </div>
                    @break
            @endswitch
        </div>
        <div class="product-detail">
            @if (isset($todaySubSpecial['discount']) && $todaySubSpecial['discount'] > 0 && $todaySubSpecial['discount'] < 10)
                <div class="discount-label">{{ $todaySubSpecial['discount'] ?? '' }}折</div>
            @endif
            <h3>{{ $todaySubSpecial['store_name'] ?? '' }}</h3>
            <div class="product-price">
                <div class="price-card d-flex">
                    <div class="original line-through ml-auto t-gray">
                        @if (!empty($todaySubSpecial['org_price']) && $todaySubSpecial['org_price'] > 0)
                            ${{ $todaySubSpecial['org_price'] }}
                        @endif
                    </div>
                    <div class="current t-danger">
                        ${{ $todaySubSpecial['price'] ?? '' }}
                        @if (!empty($todaySubSpecial['multi_price']) && $todaySubSpecial['multi_price'] > 1)
                            <span>起</span>
                        @endif
                    </div>
                </div>
                <div class="sell t-main t-085 text-right">{{ $todaySubSpecial['display_desc'] ?? '' }}</div>
            </div>
            <div class="btn btn-main" role="button">立即搶購</div>
        </div>
    </a>
</div>
