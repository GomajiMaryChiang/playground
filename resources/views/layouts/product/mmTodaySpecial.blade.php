<div class="product-card todayshoot border-r border-main-3">
    <a href="{{ $todaySpecial['link'] ?? '#' }}">
        <div class="product-img relative">
            <img class="img-fluid" src="{{ $todaySpecial['img'][0] ?? '' }}" alt="{{ $todaySpecial['store_name'] ?? '' }}">
            @switch ($todaySpecial['status'])
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
            <div class="m-i-point-label">
                <span class="t-085">{{ $todaySpecial['group_promo'] ?? '' }}</span>
            </div>
        </div>
        <div class="product-detail relative">
            @if (isset($todaySpecial['discount']) && $todaySpecial['discount'] > 0 && $todaySpecial['discount'] < 10)
                <div class="discount-label">{{ $todaySpecial['discount'] ?? '' }}折</div>
            @endif
            <h3 class="ellipsis">{{ $todaySpecial['store_name'] ?? '' }}</h3>
            <div class="product-price">
                <div class="sell t-main t-085">{{ $todaySpecial['display_desc'] ?? '' }}</div>
                <div class="price-card ml-auto d-flex">
                    <div class="original line-through ml-auto t-gray">
                        @if (!empty($todaySpecial['org_price']) && $todaySpecial['org_price'] > 0)
                            ${{ $todaySpecial['org_price'] }}
                        @endif
                    </div>
                    <div class="current t-danger">
                        ${{ $todaySpecial['price'] ?? '' }}
                        @if (!empty($todaySpecial['multi_price']) && $todaySpecial['multi_price'] > 1)
                            <span>起</span>
                        @endif
                    </div>                    
                </div>
            </div>
            <div class="btn btn-main" role="button">立即搶購</div>
        </div>
    </a>
</div>
