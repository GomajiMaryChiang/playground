@if ($totalItems >= 1)
    @foreach ($products as $key => $product)
        @if ($product['product_kind'] == Config::get('product.kindId.rsPid') || $product['product_kind'] == Config::get('product.kindId.buy123') || $product['product_kind'] == Config::get('product.kindId.coffee') || $product['product_kind'] == Config::get('product.kindId.esMarket') || $product['product_kind'] == Config::get('product.kindId.shopify'))
        <!-- Start:產品列表 -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 padding-0">
                @if ($product['available_info']['enable'] == 1)
                    <div class="product-card mm-product-card border border-r bg-white border-available">
                @else
                    <div class="product-card mm-product-card border border-r bg-white">
                @endif
                        <a href="{{ $product['link'] }}" data-page="{{ $page ?? 1 }}">
                        <div class="row no-gutters">
                            @if ($product['product_kind'] == Config::get('product.kindId.buy123') || $product['product_kind'] == Config('product.kindId.esMarket') || $product['product_kind'] == Config('product.kindId.shopify'))
                                <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-img buy123Mask relative">
                            @else
                                <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-img relative">
                            @endif
                            <div class="productImage relative">
                                <div class="location-tag d-flex">
                                    @if ($product['extra_labels'] == '紙本票券寄送')
                                        <div class="i-coupon">
                                            <span class="t-085 t-yellow">{{ $product['extra_labels'] }}</span>
                                        </div>
                                    @else
                                        @if ($product['city_id'] == 19)
                                            <div class="label-icon i-map">
                                                <span class="t-085 t-white">公益</span>
                                            </div>
                                        @elseif ($product['spot_name'])
                                            <div class="label-icon i-map">
                                                <span class="t-085 t-white">{{ $product['spot_name'] }}</span>
                                            </div>
                                        @endif
                                        <div class="i-coupon">
                                            <span class="t-085 t-yellow">{{ $product['extra_labels'] }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="pr relative">
                                    <img class="img-fluid lazyload" title="{{ $product['store_name'] }}" src="{{ url('/images/loading-540x359.jpg') }}" data-original="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                </div>
                                @if (isset($product['available_info']['enable']) && $product['available_info']['enable'] == 1)
                                    <!-- tag 現有空 -->
                                    <div class="tag-available">
                                        <div class="i-available">
                                            <span>
                                                {{ $product['available_info']['label'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <!-- End:tag 現有空 -->
                                @endif
                                @if (isset($product['micro_order_status']) || isset($product['order_status']) )
                                    @if (isset($product['order_status']) && $product['order_status'] == 'END')
                                        <div class="sold-out-label">
                                            <img class="d-block w-100 azyload" src="{{ url('/images/snapped_label.png') }}" alt="搶購一空">
                                        </div>
                                    @endif
                                    @if (isset($product['micro_order_status']) && $product['micro_order_status'] == 'END_TIMEOUT')
                                        <div class="sold-out-label">
                                            ·<img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_label.png') }}" alt="已結束">
                                        </div>
                                    @endif
                                    @if (isset($product['micro_order_status']) && $product['micro_order_status'] == 'END_CHARITY')
                                        <div class="sold-out-label">
                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_label.png') }}" alt="募集成功">
                                        </div>
                                    @endif
                                @endisset
                                @isset($product['rank'])
                                    @if ($product['rank'] && !isset($noHotBage))
                                        <i class="hotBage">{{ $product['rank'] }}</i>
                                    @endif
                                @endisset
                                    </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-detail">
                            <h3 class="ellipsis">
                                @if ($product['product_kind'] == 2 && $product['city_id'] != 19)
                                    {{ $product['group_name'] }}
                                @elseif ($product['product_kind'] == 6)
                                    【{{ $product['store_name'] }}】{{ $product['product_name'] }}
                                @else
                                    {{ $product['store_name'] }}
                                @endif
                            </h3>
                            <h4 class="ellipsis t-gray">
                                @if (isset($product['app_sub_product_name']))
                                    {{ $product['app_sub_product_name'] }}
                                @elseif (isset($product['rs_data']))
                                    {{ $product['rs_data']['group_buy'] }}
                                @else
                                    {{ $product['product_name'] }}
                                @endif
                            </h4>
                                <div class="labelBox">
                                    <div class="label-list d-flex">
                                        @if ($product['city_id'] != 19 && $product['store_rating_people'] > 0)
                                            <div class="label-icon i-smile t-main">
                                                <span class="t-11 number">{{ $product['store_rating_int'] ?? 0 }}</span><span class="t-085">{{ $product['store_rating_dot'] ?? 0 }}</span>
                                                <span class="t-07 sm-number">
                                                    ({{ $product['store_rating_people'] }})
                                                </span>
                                            </div>
                                        @endif
                                        @if (!empty($product['bt_no_sale']))
                                            <div class="label-icon i-nosale t-pink">
                                                <span class="t-085">{{ $product['bt_no_sale'] }}</span>
                                            </div>
                                        @endif
                                        @if ($product['group_promo'] != '')
                                            <div class="label-icon i-point mt-1 ml-1">
                                                <span class="t-085 t-darkdanger">{{ $product['group_promo'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tagBox d-flex flex-wrap">
                                    @if ($product['order_no'] >= 10000)
                                        <div class="tag" style="color:#FF8800;border: 1px solid #FF8800;">
                                            破萬
                                        </div>
                                    @elseif ($product['order_no'] >= 1000)
                                        <div class="tag" style="color:#FF8800;border: 1px solid #FF8800;">
                                            破千
                                        </div>
                                    @endif
                                    @if ($product['icon_display_state'] > 0 && $product['order_no'] < 1000)
                                        <div class="tag" style="color: #446CB3;border: 1px solid #446CB3;">
                                            最新
                                        </div>
                                    @endif
                                    @foreach ($product['sale_flag'] as $flag)
                                        <div class="tag" style="border: 1px solid {{ $flag['color'] }}; color: {{ $flag['color'] }};">
                                            {{ $flag['title'] }}
                                        </div>
                                    @endforeach
                                    </div>
                                    @if (isset($product['until_ts']))
                                        <div class="tagBox">
                                            <div class="label-icon i-clock ml-1">
                                                <span class="t-085 t-gray until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- PC 上的 金額＋售價 -->
                        <div class="product-price d-flex">
                            <div class="sell t-main t-085">
                                @if ($product['city_id'] == 19)
                                    {{ $product['order_no'] }}人響應
                                @elseif ($product['display_flag'] == 1)
                                    售{{ $product['order_no'] }}份
                                @elseif ($product['display_flag'] == 2)
                                    剩{{ $product['remain_no'] }}份
                                @endif
                            </div>
                            <div class="price-card d-flex ml-auto">
                                @if ($product['org_price'] > 0)
                                    <div class="original line-through ml-auto t-gray">
                                        ${{ $product['org_price'] }}
                                    </div>
                                @endif
                                <div class="current t-danger">
                                    ${{ $product['price'] }}
                                    @if ($product['multi_price'] > 1)
                                        <span>起</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End:PC 上的 金額＋售價 -->
                        <!-- 手機 mm 上會出現 標籤和金額 -->
                        <div class="mm-countdown d-flex bd-highlight">
                            <div class="flex-fill bd-highlight">
                                <div class="label-icon i-point">
                                @if (!empty($product['group_promo']))
                                    <span class="t-085 t-darkdanger">{{ $product['group_promo'] }}</span>
                                @endif
                                </div>
                                @if (isset($product['until_ts']) && $product['until_ts'] != 0)
                                    <div class="label-icon i-clock ml-1">
                                        <span class="t-085 t-gray until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-fill bd-highlight">
                                <div class="product-price">
                                    <div class="price-card d-flex ml-auto">
                                        @if ($product['org_price'] > 0)
                                            <div class="original line-through ml-auto t-gray">
                                                ${{ $product['org_price'] }}
                                            </div>
                                        @endif
                                        <div class="current t-danger">
                                            ${{ $product['price'] }}
                                            @if ($product['multi_price'] > 1)
                                                <span>起</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="sell t-main t-085 text-right">
                                        @if ($product['city_id'] == 19)
                                            {{ $product['order_no'] }}人響應
                                        @elseif ($product['display_flag'] == 1)
                                            售{{ $product['order_no'] }}份
                                        @elseif ($product['display_flag'] == 2)
                                            剩{{ $product['remain_no'] }}份
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End:手機 mm 上會出現 標籤和金額 -->
                    </a>
                </div>
            </div>
            <!-- End:產品列表 -->
        @endif
        @if ($product['product_kind'] == Config::get('product.kindId.ad'))
        <!-- Start:活動Banner -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 padding-0">
                <div class="activity-banner border border-r bg-white">
                    <a href="{{ $product['link'] }}"><img class="img-fluid lazyload" src="{{ $product['promo_data']['img'] }}"
                            alt="{{ $product['promo_data']['subject'] }}"></a>
                </div>
            </div>
            <!-- End:活動Banner -->
        @endif
        @if ($product['product_kind'] == Config::get('product.kindId.carousel') && count($product['promo_list']) >= 3)
        <!-- Start:特別企劃 -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding-0">
                <div class="row no-gutters channel-special">
                    <div class="col-md-12 section-head relative padding-0">
                        <h2>特別企劃</h2>
                        <div class="more">
                            <a href="{{ url('special') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="special-carouel owl-carousel owl-theme">
                            @foreach ($product['promo_list'] as $key => $value)
                                <div class="item">
                                    <a href="{{ url('special' . '/' . $value['id'] . '?city='. $value['city_id']) }}">
                                        <img class="img-fluid border border-r lazyload" src="{{ $value['image'] }}" alt="{{ $value['name'] }}">
                                        <div class="subject-tag">
                                            <span class="subject ellipsis">{{ $value['name'] }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:特別企劃 -->
        @endif
    @endforeach
@else
    <div class="col-md-12">
        <h3 class="text-center py-3 no-product">目前無任何檔次！</h3>
    </div>
@endif
