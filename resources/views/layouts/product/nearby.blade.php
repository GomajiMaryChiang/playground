<div class="product-card mm-product-card mm-store-product-card border border-r bg-white mb-3">
    <a href="{{ $product['link'] ?? '#' }}">
        <div class="row no-gutters">
            <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-img relative">
                <img class="img-fluid lazyload" title="{{ $product['group_name'] ?? '' }}" data-original="{{ $product['img'] ?? '' }}" alt="{{ $product['group_name'] ?? '' }}">
                <div class="location-tag d-flex">
                    @if (!empty($product['spot_name']))
                        <div class="label-icon i-map">
                            <span class="t-085 t-white">{{ $product['spot_name'] }}</span>
                        </div>
                    @endif

                    @if (!empty($product['extra_labels']))
                        <div class="i-coupon">
                            <span class="t-085 t-yellow">{{ $product['extra_labels'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-detail">
                <h3 class="ellipsis">{{ $product['group_name'] ?? '' }}</h3>
                <h4 class="ellipsis t-gray">{{ $product['app_sub_product_name'] ?? '' }}</h4>
                @if (!empty($product['store_rating_people']) && $product['store_rating_people'] > 0)
                    <div class="labelBox">
                        <div class="label-list d-flex">
                            <div class="label-icon i-smile t-main">
                                <span class="t-12 number">{{ $product['store_rating_int'] ?? '' }}</span><span class="t-09">{{ $product['store_rating_dot'] ?? '' }}</span>
                                <span class="t-085 sm-number">
                                    ({{ $product['store_rating_people'] }})
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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
    </a>
</div>