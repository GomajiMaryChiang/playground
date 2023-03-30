@if ($ch == Config::get('channel.id.es'))
    <!-- Start:台灣最大線上旅展 -->
    @if (isset($esSpecial) && !empty($esSpecial['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head es-special relative padding-0">
                        <h2><i class="sectionhead-icon i-grand-opening"></i>{{ $esSpecial['title'] }}</h2>
                        <div class="more">
                            <a href="{{ url('travel_fair') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="es-special-carouel product-carousel owl-carousel owl-theme">
                            @if (count($esSpecial['product']) > 0)
                                @foreach ($esSpecial['product'] as $key => $product)
                                    <div class="item">
                                        <div class="product-card mm-product-card border border-r @if(isset($product['available_info']['enable']) && $product['available_info']['enable'] == 1) border-available @endif">
                                            <a href="{{ url('store/' . $product['store_id'] . '/pid/' . $product['product_id']) }}">
                                                <div class="product-img relative">
                                                    <img class="img-fluid" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                    @if (isset($product['available_info']['enable']) && $product['available_info']['enable'] == 1)
                                                        <!-- tag 現有空 -->
                                                        <div class="tag-available">
                                                            <div class="i-available">
                                                                <span>{{ $product['available_info']['label'] ?? '' }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- End:tag 現有空 -->
                                                    @endif
                                                </div>
                                                <div class="product-detail">
                                                    <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                                </div>
                                                <div class="product-price d-flex">
                                                    <div class="sell t-main t-085">
                                                        @if ($product['order_no'] > 0)
                                                            @if ($product['display_flag'] == 1)
                                                                售{{ $product['order_no'] }}份
                                                            @endif
                                                            @if ($product['display_flag'] == 2)
                                                                剩{{ $product['remain_no'] }}份
                                                            @endif
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:台灣最大線上旅展 -->
    @if (isset($esHotCat) && !empty($esHotCat['category']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head relative padding-0">
                        <h2>熱銷類別</h2>
                    </div>
                    <!--PC-熱銷類別 -->
                    <div class="col-md-12 section-stage best-sellingBox">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <a href="{{ url($esHotCat['category'][0]['link']) }}" class="list first best-selling d-flex relative">
                                    <div class="best-pic">
                                        <div class="best-selling-lable">
                                        </div>
                                        <img class="img-fluid" src="{{ $esHotCat['category'][0]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][0]['title'] ?? '' }}">
                                    </div>
                                    <div class="best-title">
                                        <h4>{{ $esHotCat['category'][0]['title'] }}</h4>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <a href="{{ url($esHotCat['category'][1]['link']) }}" class="list second best-selling d-flex">
                                    <div class="best-pic">
                                        <img class="img-fluid" src="{{ $esHotCat['category'][1]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][1]['title'] ?? '' }}">
                                    </div>
                                    <div class="best-title">
                                        <h4>{{ $esHotCat['category'][1]['title'] }}</h4>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <a href="{{ url($esHotCat['category'][2]['link']) }}" class="list third best-selling d-flex">
                                    <div class="best-pic">
                                        <img class="img-fluid" src="{{ $esHotCat['category'][2]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][2]['title'] ?? '' }}">
                                    </div>
                                    <div class="best-title">
                                        <h4>{{ $esHotCat['category'][2]['title'] }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--End:PC-熱銷類別 -->
                    <!--mm-熱銷類別 -->
                    <div class="mm-best-selling-carouel best-sellingBox owl-carousel owl-theme">
                        <div class="item">
                            <a href="{{ url($esHotCat['category'][0]['link']) }}" class="list first best-selling d-flex relative">
                                <div class="best-pic">
                                    <div class="best-selling-lable">
                                    </div>
                                    <img class="img-fluid" src="{{ $esHotCat['category'][0]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][0]['title'] ?? '' }}">
                                </div>
                                <div class="best-title">
                                    <h4>{{ $esHotCat['category'][0]['title'] }}</h4>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{ url($esHotCat['category'][1]['link']) }}" class="list second best-selling d-flex">
                                <div class="best-pic">
                                    <img class="img-fluid" src="{{ $esHotCat['category'][1]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][1]['title'] ?? '' }}">
                                </div>
                                <div class="best-title">
                                    <h4>{{ $esHotCat['category'][1]['title'] }}</h4>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{ url($esHotCat['category'][2]['link']) }}" class="list third best-selling d-flex">
                                <div class="best-pic">
                                    <img class="img-fluid" src="{{ $esHotCat['category'][2]['big_icon'] ?? '' }}" alt="{{ $esHotCat['category'][2]['title'] ?? '' }}">
                                </div>
                                <div class="best-title">
                                    <h4>{{ $esHotCat['category'][2]['title'] }}</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!--End:mm-熱銷類別 -->
                </div>
            </div>
        </div>
    @endif
    <!--End:熱銷類別 -->
@endif

@if ($ch == Config::get('channel.id.sh'))
    <!-- Start:宅配美食限時優惠 -->
    @if (isset($shSpecial) && !empty($shSpecial['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head grand-opening relative padding-0">
                        <h2><i class="sectionhead-icon i-delivery"></i>{{ $shSpecial['title'] ?? '宅配美食限時優惠'}}</h2>
                        <div class="more">
                            <a href="{{ url('/sh_special') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="grand-opening-carouel owl-carousel owl-theme">
                            @foreach ($shSpecial['product'] as $key => $product)
                                <div class="item">
                                    <div class="product-card mm-product-card border border-r">
                                        <a href="{{ $product['link'] }}">
                                            <div class="product-img relative">
                                                <img class="img-fluid lazyload" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                @isset($product['micro_order_status'])
                                                    @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_CHARITY')
                                                        <div class="raise-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                            </div>
                                            <div class="product-price d-flex">
                                                <div class="sell t-main t-085">
                                                    @if ($product['order_no'] > 0)
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
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
                                            <!-- 手機 mm 上會出現 -->
                                            <div class="mm-sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:手機 mm 上會出現 -->
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:宅配美食限時優惠 -->
    <!-- Start:名店美食 -->
    @if (isset($shBrand) && !empty($shBrand['category']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head relative padding-0">
                        <h2><i class="sectionhead-icon i-brands"></i>{{ $shBrand['title'] ?? '名店美食' }}</h2>
                        <div class="more">
                            <a href="{{ url('sh_brand') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="brands-carouel owl-carousel owl-theme">
                            @foreach ($shBrand['category'] as $key => $brand)
                                <div class="item">
                                    <a href="{{ url('sh_brand' . '/' . ($brand['pa_id'] ?? '0') . '?type=' . ($brand['brand_type'] ?? '')) }}">
                                        <img class="img-fluid border border-r lazyload" src="{{ $brand['small_icon'] ?? '' }}" alt="{{ $brand['title'] ?? '' }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:名店美食 -->
    <!--熱銷類別 -->
    @if (isset($shHotCat) && !empty($shHotCat['category']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head relative padding-0">
                        <h2>{{ $shHotCat['title'] ?? '熱銷類別' }}</h2>
                    </div>
                    <!--PC-熱銷類別 -->
                    <div class="col-md-12 section-stage best-sellingBox sh-best-sellingBox">
                        <div class="row">
                            @if (!empty($shHotCat['category'][0]))
                                <div class="col-md-4 col-sm-12">
                                    <a href="{{ url($shHotCat['category'][0]['link']) }}" class="list first best-selling d-flex relative">
                                        <div class="best-pic">
                                            <div class="best-selling-lable">
                                            </div>
                                            <img class="img-fluid" src="{{ $shHotCat['category'][0]['small_icon'] ?? '' }}" alt="{{ $shHotCat['category'][0]['title'] ?? '' }}">
                                        </div>
                                        <div class="best-title">
                                            <h4>{{ $shHotCat['category'][0]['title'] ?? '' }}</h4>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (!empty($shHotCat['category'][1]))
                                <div class="col-md-4 col-sm-12">
                                    <a href="{{ url($shHotCat['category'][1]['link']) }}" class="list second best-selling d-flex">
                                        <div class="best-pic">
                                            <img class="img-fluid" src="{{ $shHotCat['category'][1]['small_icon'] ?? '' }}" alt="{{ $shHotCat['category'][1]['title'] ?? '' }}">
                                        </div>
                                        <div class="best-title">
                                            <h4>{{ $shHotCat['category'][1]['title'] ?? '' }}</h4>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (!empty($shHotCat['category'][2]))
                                <div class="col-md-4 col-sm-12">
                                    <a href="{{ url($shHotCat['category'][2]['link']) }}" class="list third best-selling d-flex">
                                        <div class="best-pic">
                                            <img class="img-fluid" src="{{ $shHotCat['category'][2]['small_icon'] ?? '' }}" alt="{{ $shHotCat['category'][2]['title'] ?? '' }}">
                                        </div>
                                        <div class="best-title">
                                            <h4>{{ $shHotCat['category'][2]['title'] ?? '' }}</h4>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--End:PC-熱銷類別 -->
                    <!--mm-熱銷類別 -->
                    <div class="col-md-12 section-stage mm-sh-best-sellingBox padding-02">
                        <div class="mm-sh-best-carouel owl-carousel owl-theme">
                            @foreach ($shHotCat['category'] as $key => $value)
                                <div class="item">
                                    <a href="{{ url($value['link']) }}" class="list best-selling">
                                        <img class="img-fluid" src="{{ $value['small_icon'] ?? '' }}" alt="{{ $value['title'] ?? '' }}">
                                        <h4 class="subject-tag">
                                            {{ $value['title'] ?? '' }}
                                        </h4>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--End:mm-熱銷類別 -->
                </div>
            </div>
        </div>
    @endif
@endif

@if ($ch == Config::get('channel.id.rs'))
    <!-- Start:星級飯店品牌 -->
    @if (isset($rsBrand) && !empty($rsBrand['category']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head relative padding-0">
                        <h2><i class="sectionhead-icon i-brands"></i>{{ $rsBrand['title'] }}</h2>
                        <div class="more">
                            <a href="{{ url('brand') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="brands-carouel owl-carousel owl-theme">
                            @foreach ($rsBrand['category'] as $key => $brand)
                                <div class="item">
                                    <a href="{{ url('brand' . '/' . $brand['pa_id']) }}">
                                        <img class="img-fluid border border-r lazyload" src="{{ $brand['small_icon'] }}" alt="{{ $brand['title'] }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:星級飯店品牌 -->
    <!-- Start:限時搶購 -->
    @if (isset($flashSale) && !empty($flashSale['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head flash-sale relative padding-0">
                        <h2><i class="sectionhead-icon i-flash-sale"></i>{{ $flashSale['title'] }}</h2>
                        <div class="more">
                            <a href="{{ url('flash_sale') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="flash-sale-carouel owl-carousel owl-theme">
                            @foreach ($flashSale['product'] as $key => $product)
                                <div class="item">
                                    <div class="product-card mm-product-card border border-r">
                                        <a href="{{ $product['link'] }}">
                                            <div class="product-img relative">
                                                <img class="img-fluid lazyload" src="{{ $product['img'][0] }}" title="{{ $product['store_name'] }}"alt="{{ $product['store_name'] }}">
                                                <div class="location-tag product-flash-sale">
                                                    <div class="label-icon i-clock-white">
                                                        <span class="t-085 t-white until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                                                    </div>
                                                </div>
                                                @isset($product['micro_order_status'])
                                                    @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_CHARITY')
                                                        <div class="raise-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                            </div>
                                            <div class="product-price d-flex">
                                                <div class="sell t-main t-085">
                                                    @if ($product['order_no'] > 0)
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
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
                                            <!-- 手機 mm 上會出現 -->
                                            <div class="mm-sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:手機 mm 上會出現 -->
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:限時搶購 -->
    <!-- Start:新開幕、首次開賣 -->
    @if (isset($firstOpen) && !empty($firstOpen['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head grand-opening relative padding-0">
                        <h2><i class="sectionhead-icon i-grand-opening"></i>{{ $firstOpen['title'] }}</h2>
                        <div class="more">
                            <a href="{{ url('new_open') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="grand-opening-carouel owl-carousel owl-theme">
                            @foreach ($firstOpen['product'] as $key => $product)
                                <div class="item">
                                    <div class="product-card mm-product-card border border-r">
                                        <a href="{{ $product['link'] }}">
                                            <div class="product-img relative">
                                                <img class="img-fluid lazyload" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                @isset($product['micro_order_status'])
                                                    @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_CHARITY')
                                                        <div class="raise-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                            </div>
                                            <div class="product-price d-flex">
                                                <div class="sell t-main t-085">
                                                    @if ($product['order_no'] > 0)
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
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
                                            <!-- 手機 mm 上會出現 -->
                                            <div class="mm-sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:手機 mm 上會出現 -->
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:新開幕、首次開賣 -->
    <!-- Start:嚴選店家 -->
    @if (isset($drinks) && !empty($drinks['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head selected relative padding-0">
                        <h2><i class="sectionhead-icon i-selected"></i>{{ $drinks['title'] }}</h2>
                        <div class="more">
                            <a href="{{ url('drinks') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="selected-carouel owl-carousel owl-theme">
                            @foreach ($drinks['product'] as $key => $product)
                                <div class="item">
                                    <div class="product-card mm-product-card border border-r">
                                        <a href="{{ $product['link'] }}">
                                            <div class="product-img relative lazyload">
                                                <img class="img-fluid" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                @isset($product['micro_order_status'])
                                                    @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_CHARITY')
                                                        <div class="raise-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                            </div>
                                            <div class="product-price d-flex">
                                                <div class="sell t-main t-085">
                                                    @if ($product['order_no'] > 0)
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
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
                                            <!-- 手機 mm 上會出現 -->
                                            <div class="mm-sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:手機 mm 上會出現 -->
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:嚴選店家 -->
@endif

@if ($ch == Config::get('channel.id.bt'))
    <!-- Start:限時搶購 -->
    @if (isset($btFlashSale) && !empty($btFlashSale['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head flash-sale relative padding-0">
                        <h2><i class="sectionhead-icon i-flash-sale"></i>限時搶購</h2>
                        <div class="more">
                            <a href="{{ url('bt_flash_sale') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="flash-sale-carouel owl-carousel owl-theme">
                        @foreach ($btFlashSale['product'] as $key => $product)
                            <div class="item">
                                <div class="product-card mm-product-card border border-r">
                                    <a href="{{ $product['link'] }}">
                                        <div class="product-img relative">
                                            <img class="img-fluid lazyload" src="{{ $product['img'][0] }}" title="{{ $product['store_name'] }}"alt="{{ $product['store_name'] }}">
                                            <div class="location-tag product-flash-sale">
                                                <div class="label-icon i-clock-white">
                                                    <span class="t-085 t-white until-ts" data-untilts="{{ $product['until_ts'] }}"></span>
                                                </div>
                                            </div>
                                            @isset($product['micro_order_status'])
                                                @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                    <div class="sold-out-label">
                                                        <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                    </div>
                                                @endif

                                                @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                    <div class="sold-out-label">
                                                        <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                    </div>
                                                @endif

                                                @if ($product['micro_order_status'] == 'END_CHARITY')
                                                    <div class="raise-out-label">
                                                        <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                    </div>
                                                @endif
                                            @endisset
                                        </div>
                                        <div class="product-detail">
                                            <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                        </div>
                                        <div class="product-price d-flex">
                                            <div class="sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
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
                                        <!-- 手機 mm 上會出現 -->
                                        <div class="mm-sell t-main t-085">
                                            @if ($product['order_no'] > 0)
                                                @if ($product['display_flag'] == 1)
                                                    售{{ $product['order_no'] }}份
                                                @endif
                                                @if ($product['display_flag'] == 2)
                                                    剩{{ $product['remain_no'] }}份
                                                @endif
                                            @endif
                                        </div>
                                        <!-- End:手機 mm 上會出現 -->
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    <!-- End:限時搶購 -->
    <!-- Start:品牌連鎖 -->
    @if (isset($btChainStore) && !empty($btChainStore['product']))
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-head branding relative padding-0">
                        <h2><i class="sectionhead-icon i-branding"></i>品牌連鎖</h2>
                        <div class="more">
                            <a href="{{ url('bt_chain_store') }}">更多<i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 section-stage padding-02">
                        <div class="branding-carouel product-carousel owl-carousel owl-theme">
                            @foreach($btChainStore['product'] as $key => $product)
                                <div class="item">
                                    <div class="product-card mm-product-card border border-r @if(isset($product['available_info']['enable']) && $product['available_info']['enable'] == 1) border-available @endif">
                                        <a href="{{ $product['link'] }}">
                                            <div class="product-img relative">
                                                <img class="img-fluid" title="{{ $product['store_name'] }}" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                @if (isset($product['available_info']['enable']) && $product['available_info']['enable'] == 1)
                                                    <!-- tag 現有空 -->
                                                    <div class="tag-available">
                                                        <div class="i-available">
                                                            <span>{{ $product['available_info']['label'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                    <!-- End:tag 現有空 -->
                                                @endif
                                                @isset($product['micro_order_status'])
                                                    @if ($product['micro_order_status'] == 'END_SOLDOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/soldout_label.png') }}" alt="銷售一空">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_TIMEOUT')
                                                        <div class="sold-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                        </div>
                                                    @endif

                                                    @if ($product['micro_order_status'] == 'END_CHARITY')
                                                        <div class="raise-out-label">
                                                            <img class="d-block w-100 lazyload" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                            <div class="product-detail">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                            </div>
                                            <div class="product-price d-flex">
                                                <div class="sell t-main t-085">
                                                    @if ($product['order_no'] > 0)
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
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
                                            <!-- 手機 mm 上會出現 -->
                                            <div class="mm-sell t-main t-085">
                                                @if ($product['order_no'] > 0)
                                                    @if ($product['display_flag'] == 1)
                                                        售{{ $product['order_no'] }}份
                                                    @endif
                                                    @if ($product['display_flag'] == 2)
                                                        剩{{ $product['remain_no'] }}份
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:手機 mm 上會出現 -->
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End:品牌連鎖 -->
@endif
