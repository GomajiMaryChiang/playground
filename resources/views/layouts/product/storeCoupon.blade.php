<div class="store-product-item border border-r relative">
    <div class="row">
        <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12">
            <img class="img-fluid border-r lazyload" data-original="{{ $product['img'] }}" alt="{{ $product['product_name'] }}">
            @if ($product['status'] == 'END_SOLDOUT')
                <div class="sold-out-label">
                    <img class="d-block w-100 lazyload" data-original="{{ url('/images/soldout_label.png') }}" alt="搶購一空">
                </div>
            @endif
        </div>
        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 mt-2">
            <h3>{{ $product['product_name'] }}</h3>
            <div class="store-product-price">
                <div class="product-price d-flex">
                    <div class="sell t-main t-085">{{ $product['display_desc'] ?? '' }}</div>
                    <div class="price-card d-flex ml-auto">
                        @if (!empty($product['org_price']) && $product['org_price'] > 0)
                            <div class="original line-through ml-auto t-gray">
                                ${{ $product['org_price'] }}
                            </div>
                        @endif
                        <div class="current t-danger">
                            ${{ $product['price'] ?? '' }}
                            @if (!empty($product['multi_price']) && $product['multi_price'] > 1)
                                <span>起</span>
                            @endif
                        </div>
                    </div>
                </div>
                <a class="btn btn-main" href="{{ $product['link'] ?? '#' }}" role="button">
                    立即搶購
                </a>
            </div>
        </div>
    </div>
</div>