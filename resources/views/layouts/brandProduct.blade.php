@if ($totalItems == 0)
    <div class="col-md-12 mb-5">
        <p class="text-center no-product">目前無任何檔次！</p>
    </div>
@else
    @foreach ($products as $key => $product)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 padding-0">
            <div class="product-card mm-product-card border border-r bg-white">
                <a href="{{ url($product['pidUrl']) }}">
                    <div class="row no-gutters">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-img relative">
                            <img class="img-fluid" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}"
                                alt="{{ $product['store_name'] }}">
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
                            @isset($product['micro_order_status'])
                                @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                    <div class="sold-out-label">
                                        <img class="d-block w-100" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                    </div>
                                @endif

                                @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                    <div class="sold-out-label">
                                        <img class="d-block w-100" src="{{ url('/images/sold_out_close_label.png') }}" alt="已結束">
                                    </div>
                                @endif

                                @if ($product['micro_order_status'] == 'END_CHARITY')
                                    <div class="raise-out-label">
                                        <img class="d-block w-100" src="{{ url('/images/raise_out_label.png') }}" alt="募集成功">
                                    </div>
                                @endif
                            @endisset
                            @isset($product['rank']))
                                @if ($product['rank'])
                                    <i class="hotBage">{{ $product['rank'] }}</i>
                                @endif
                            @endisset
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
                                @if ($product['app_sub_product_name'])
                                    {{ $product['app_sub_product_name'] }}
                                @elseif ($product['rs_data'])
                                    {{ $product['rs_data']['group_buy'] }}
                                @else
                                    {{ $product['product_name'] }}
                                @endif
                            </h4>
                            <div class="labelBox">
                                <div class="label-list d-flex">
                                    <div class="label-icon i-smile t-main">
                                        <span class="t-12 number">{{ $product['store_rating_int'] }}</span><span class="t-09">{{ $product['store_rating_dot'] }}</span>
                                        <span class="t-085 sm-number">
                                            ({{ $product['store_rating_people'] }})
                                        </span>
                                    </div>
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
                                    @if ($product['until_ts'] && $product['ch_id'] == 8)
                                        <div class="label-icon i-clock ml-1">
                                            <span class="t-085 t-gray until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                                        </div>
                                    @endif
                                </div>
                                @if ($product['until_ts'] && $product['ch_id'] != 8)
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
                    <!-- 小手機 mm 上會出現 -->
                    <div class="mm-countdown d-flex">
                        @if ($product['group_promo'] != '')
                            <div class="label-icon i-point mt-1 ml-1">
                                <span class="t-085 t-darkdanger">{{ $product['group_promo'] }}</span>
                            </div>
                        @endif
                        <div class="label-icon i-clock ml-1">
                            <span class="t-085 t-gray until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                        </div>
                    </div>
                    <!-- End:小手機 mm 上會出現 -->
                    <div class="product-price d-flex">
                        <div class="sell t-main t-085">
                            @if ($product['display_flag'] == 1)
                                售{{ $product['order_no'] }}份
                            @elseif ($product['display_flag'] == 2)
                                剩{{ $product['remain_no'] }}份
                            @endif
                        </div>
                        <div class="price-card d-flex ml-auto">
                            <div class="original line-through ml-auto t-gray">
                                ${{ $product['org_price'] }}
                            </div>
                            <div class="current t-danger">
                                ${{ $product['price'] }}
                                <span>起</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@endif
