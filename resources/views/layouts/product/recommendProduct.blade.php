<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 padding-0">
    <div class="product-card mm-product-card border border-r bg-white {{ !empty($recommend['is_available_info']) ? 'border-available' : '' }}">
        <a href="{{ $recommend['link'] ?? '#' }}">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-img {{ $recommend['class_name'] }} relative">
                    <img class="img-fluid lazyload" title="{{ $recommend['store_name'] ?? '' }}" src="{{ url('/images/loading-540x359.jpg') }}" data-original="{{ $recommend['img'][0] ?? '' }}" alt="{{ $recommend['store_name'] ?? '' }}">
                    <div class="location-tag d-flex">
                        @if (!empty($recommend['spot_name']))
                            <div class="label-icon i-map">
                                <span class="t-085 t-white">{{ $recommend['spot_name'] }}</span>
                            </div>
                        @endif

                        @if (!empty($recommend['extra_labels']))
                            <div class="i-coupon">
                                <span class="t-085 t-yellow">{{ $recommend['extra_labels'] }}</span>
                            </div>
                        @endif
                    </div>     
                    @switch ($recommend['status'])
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

                    @if (!empty($recommend['is_available_info']))
                        <div class="tag-available">
                            <div class="i-available">
                                <span>{{ $recommend['available_info']['label'] ?? '' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-6 product-detail">
                    <h3 class="ellipsis">{{ $recommend['real_product_name'] ?? '' }}</h3>
                    <h4 class="ellipsis t-gray">{{ $recommend['real_sub_product_name'] ?? '' }}</h4>
                    <div class="labelBox">
                        <div class="label-list d-flex">
                            @if (!empty($recommend['store_rating_people']) && $recommend['store_rating_people'] > 0 && $recommend['city_id'] != Config::get('city.baseCityList.publicWelfare'))
                                <div class="label-icon i-smile t-main">
                                    <span class="t-12 number">{{ $recommend['store_rating_int'] ?? '' }}</span><span class="t-09">{{ $recommend['store_rating_dot'] ?? '' }}</span>
                                    <span class="t-085 sm-number">
                                        ({{ $recommend['store_rating_people'] }})
                                    </span>
                                </div>
                            @endif

                            @if (!empty($recommend['group_promo']))
                                <div class="label-icon i-point mt-1 ml-1">
                                    <span class="t-085 t-darkdanger">{{ $recommend['group_promo'] }}</span>
                                </div>
                            @endif

                            @if (!empty($recommend['bt_no_sale']))
                                <div class="label-icon i-nosale t-pink">
                                    <span class="t-085">{!! $recommend['bt_no_sale'] !!}</span>
                                </div>
                            @endif
                        </div>
                        <div class="tagBox d-flex flex-wrap">
                            @if ($recommend['order_no'] >= 10000)
                                <div class="tag" style="color: #FF8800; border: 1px solid #FF8800;">
                                    破萬
                                </div>
                            @elseif ($recommend['order_no'] >= 1000)
                                <div class="tag" style="color: #FF8800; border: 1px solid #FF8800;">
                                    破千
                                </div>
                            @endif

                            @if (!empty($recommend['icon_new']))
                                <div class="tag" style="color: #446CB3; border: 1px solid #446CB3;">
                                    最新
                                </div>
                            @endif

                            @if (!empty($recommend['icon_hot']))
                                <div class="tag" style="color: #FF8800; border: 1px solid #FF8800;">
                                    熱銷
                                </div>
                            @endif
                
                            @foreach ($recommend['sale_flag'] as $flag)
                                <div class="tag" style="border: 1px solid {{ $flag['color'] }}; color: {{ $flag['color'] }};">
                                    {{ $flag['title'] }}
                                </div>
                            @endforeach

                            @if (!empty($recommend['until_ts']))
                                <div class="label-icon i-clock ml-1">
                                    <span class="t-085 t-gray until-ts" data-untilts="{{ $recommend['until_ts'] }}"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- PC 上的 金額＋售價 -->
            <div class="product-price d-flex">
                <div class="sell t-main t-085">{{ $recommend['display_desc'] }}</div>
                <div class="price-card d-flex ml-auto">
                    @if (!empty($recommend['org_price']) && $recommend['org_price'] > 0)
                        <div class="original line-through ml-auto t-gray">
                            ${{ $recommend['org_price'] }}
                        </div>
                    @endif
                    <div class="current t-danger">
                        ${{ $recommend['price'] ?? '' }}
                        @if (!empty($recommend['multi_price']) && $recommend['multi_price'] > 1)
                            <span>起</span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End:PC 上的 金額＋售價 -->
            <!-- 手機 mm 上會出現 標籤和金額 -->
            <div class="mm-countdown d-flex bd-highlight">
                <div class="flex-fill bd-highlight">
                    @if (!empty($recommend['group_promo']))
                        <div class="label-icon i-point">
                            <span class="t-085 t-darkdanger">{{ $recommend['group_promo'] }}</span>
                        </div>
                    @endif

                    @if (!empty($recommend['until_ts']))
                        <div class="label-icon i-clock ml-1">
                            <span class="t-085 t-gray until-ts" data-untilts="{{ $recommend['until_ts'] }}"></span>
                        </div>
                    @endif
                </div>
                <div class="flex-fill bd-highlight">
                    <div class="product-price">
                        <div class="price-card d-flex ml-auto">
                            @if (!empty($recommend['org_price']) && $recommend['org_price'] > 0)
                                <div class="original line-through ml-auto t-gray">
                                    ${{ $recommend['org_price'] }}
                                </div>
                            @endif
                            <div class="current t-danger">
                                ${{ $recommend['price'] ?? '' }}
                                @if (!empty($recommend['multi_price']) && $recommend['multi_price'] > 1)
                                    <span>起</span>
                                @endif
                            </div>
                        </div>
                        <div class="sell t-main t-085 text-right">{{ $recommend['display_desc'] }}</div>
                    </div>
                </div>
            </div>
            <!-- End:手機 mm 上會出現 標籤和金額 -->
        </a>
    </div>
</div>