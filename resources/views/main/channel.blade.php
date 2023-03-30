@extends('modules.common')

@section('content')
    <div id="mm-categoryfilterBox" class="mm-categoryfilterBox">
        <div class="d-flex">
            <div id="mm-categoryfilter-slider" class="mm-categoryfilter-carousel owl-carousel owl-theme">
                @if ($categoryId == 0)
                    <div class="item active">
                @else
                    <div class="item">
                @endif
                    <a href="{{ url('ch/' . $ch) }}">
                        全部
                    </a>
                </div>
                @if (!empty($categories))
                    @foreach ($categories as $key => $category)
                        @if ($category['cat_id'] != 0)
                            @if ($categoryId == $category['cat_id'])
                                <div class="item active">
                            @else
                                <div class="item">
                            @endif
                                <a href="{{ url($category['link']) }}">
                                    {{ $category['cat_name'] }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div id="categoryArrow" class="categoryArrow">
                <i class="social-icon i-arrow-gray"></i>
            </div>
        </div>
        <div id="mm-categoryfilter-menu" class="mm-categoryfilter-menu">
            <ul class="item-list d-flex align-content-start flex-wrap">
                @if (!empty($categories))
                    @foreach ($categories as $key => $category)
                        <li>
                            @if ($category['cat_id'] == 0)
                                <a href="{{ url('ch/' . $ch) }}">全部</a>
                            @else
                                <a class="item" href="{{ url($category['link']) }}">{{ $category['cat_name'] }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <!-- End:mm channel頁top類別區塊 -->
    <div class="gomaji-banners-wrapper {{ $theme }}">
        <!-- theme是控制背景主題 -->
        <div class="container padding-0">
            <div class="row no-gutters">
                @include('layouts.channelBreadcrumb')
                <!-- End:breadcrumb -->
                @include('layouts.channelCategory')
                <!-- End:hot-categoryBox類別 -->
                @isset($banners)
                    @include('layouts.channelBanner')
                @endisset
                <!-- End:banner -->
            </div>
        </div>
    </div>
    <!-- End:home-banners-wrapper -->
    <main class="main">
        <!-- Start:浮水印 -->
        @isset($activityAd['enable'])
            @if ($activityAd['enable'] == 1)
                <div class="activity-ad mainstar-floating-ad">
                    <span class="icon i-close" id="mm-iconBtn"></span>
                    @if ($activityAd['action'] == 'product')
                        <a href="{{ url('store/' . $activityAd['sid'] . '/pid/' . $activityAd['pid']) }}" @if (!$platform) target="_blank" @endif><img src="{{ url('/images/mainstar-floating-ad.png') }}" alt="主打星ad"></a>
                    @else
                        <a href="javascript:void(0);" id="mm-popupAdBtn"><img src="{{ url('/images/mainstar-floating-ad.png') }}" alt="主打星ad"></a>
                    @endif
                </div>
                <div class="mainstar-label-wrap">
                    @if ($activityAd['action'] == 'product')
                        <a href="{{ url('store/' . $activityAd['sid'] . '/pid/' . $activityAd['pid']) }}" target="_blank">
                    @else
                        <a href="javascript:void(0);">
                    @endif
                        <div class="mainstar-label">
                            <div class="d-flex justify-content-center">
                                <h3>主打星</h3>
                                <i class="fas fa-angle-right t-white t-12"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endisset
        <!-- End:浮水印 -->
        <!-- Start:主打星 -->
        @isset($popupAd['display'])
            @if ($popupAd['display'])
                <div class="mainstar-wrap @if (!empty($activityAd['action']) && $activityAd['action'] == 'flagship-product') mainstar-fortwo-wrap @endif" style="{{ $popupAdStyle }}">
                    <div class="mainstarBox relative">
                        <a class="mainstar-close" href="javascript:void(0);"><i class="i-close-white-solid"></i></a>
                        <div class="title d-flex justify-content-center">
                            <i class="i-star"></i>
                            <h3>主打星</h3>
                            <i class="i-star"></i>
                        </div>
                        @if (!empty($activityAd['action']) && $activityAd['action'] == 'flagship-product')
                            <div class="d-flex bd-highlight">
                        @endif
                            @if (!empty($popupAd['products']))
                                @foreach ($popupAd['products'] as $key => $product)
                                    <a href="{{ url('store/' . $product['store_id'] . '/pid/' . $product['product_id']) }}" @if (!$platform) target="_blank" @endif @if (!empty($activityAd['action']) && $activityAd['action'] == 'flagship-product') class="flex-fill bd-highlight" style="width: 100%;" @endif>
                                        <div class="product-item todayshootat9 bg-white">
                                            <div class="product-img {{ $flagShipBlock }}">
                                                <img class="img-fluid" src="{{ $product['img'][0] }}" alt="{{ $product['store_name'] }}">
                                                <!-- 搶購完畢 -->
                                                @if (!empty($product['micro_order_status']) && $product['micro_order_status'] == 'END_SOLDOUT')
                                                    <div class="sold-out-label">
                                                        <img class="d-block w-100" src="{{ url('/images/soldout_label.png') }}" alt="搶購一空">
                                                    </div>
                                                @endif
                                                <!-- 已結束 -->
                                                @if (!empty($product['micro_order_status']) && $product['micro_order_status'] == 'END_TIMEOUT')
                                                    <div class="sold-out-label">
                                                        <img class="d-block w-100" src="{{ url('/images/sold_out_close_lab') }}el.png" alt="已結束">
                                                    </div>
                                                @endif
                                                <!-- 募集成功 -->
                                                @if (!empty($product['micro_order_status']) && $product['micro_order_status'] == 'END_CHARITY')
                                                    <div class="raise-out-label">
                                                        <img class="d-block w-100" src="{{ url('/images/raise_out_label.pn') }}g" alt="募集成功">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-detail relative {{ $flagShipBlock }}">
                                                <h3 class="ellipsis">{{ $product['store_name'] }}</h3>
                                                <div class="product-price d-flex">
                                                    <div class="price-card ml-auto d-flex order-2">
                                                        <div class="original line-through ml-auto t-gray">
                                                            ${{ $product['org_price'] }}
                                                        </div>
                                                        <div class="current t-danger">
                                                            ${{ $product['price'] }}
                                                            <span>起</span>
                                                        </div>
                                                    </div>
                                                    <div class="sell t-main t-085 order-1">
                                                        @if ($product['display_flag'] == 1)
                                                            售{{ $product['order_no'] }}份
                                                        @endif
                                                        @if ($product['display_flag'] == 2)
                                                            剩{{ $product['remain_no'] }}份
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn btn-main" role="button">立即搶購</div>
                                    </a>
                                @endforeach
                            @endif
                        @if (!empty($activityAd['action']) && $activityAd['action'] == 'flagship-product')
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endisset
        <!-- End:主打星 -->
        @if($categoryId == 0)
            @include('layouts.channelCommend')
        @endif
        <!--End:小編嚴選 -->
        <!-- Start:全部Products列表 -->
        <div class="sectionBox channel-sectionBox">
            <div class="container">
                <div class="row" id="container__row">
                    @if (count($products) > 0)
                        <div class="col-md-12 main-head relative">
                            @if ($categoryId == 0)
                                <h2 class="text-center">全部{{ $chTitle }}</h2>
                            @else
                                <h2 class="text-center">全部{{ $subChTitle }}</h2>
                            @endif
                            <div class="filterbarBox">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $sortList[$sort] ?? $sortList[0] }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    @foreach ($sortList as $key => $value)
                                        <a class="dropdown-item" href="{{ $sortUrl }}&sort={{ $key }}">{{ $value }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @include('layouts.channelProduct')
                    @else
                        <div class="col-md-12 mb-5">
                            @if ($categoryId == 0)
                                <h2 class="text-center">全部{{ $chTitle }}</h2>
                            @else
                                <h2 class="text-center">全部{{ $subChTitle }}</h2>
                            @endif
                            <p class="text-center no-product">目前無任何檔次！</p>
                        </div>
                    @endif
                </div>
                @if ($totalPages > 1)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <input class="btn-loadmore btn btn-outline-main w-30" value="看更多" data-lt="載入中…" type="button">
                    </div>
                @endif
            </div>
        </div>
        <!-- Start:全部Products列表 -->
    </main>

    <img src="https://clk.gomaji.com/{{ $clk['plat'] ?? '' }}/{{ $clk['bu'] ?? '' }}/?city={{ $clk['cityEn'] ?? '' }}&tag_id={{ $clk['tag'] ?? '' }}&category_id={{ $clk['category'] ?? '' }}" style="display:none" height="1" width="1" />
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('/js/assets/jquery.scrollmagic.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/assets/TweenMax.min.js') }}"></script>
    @if (isset($popupAd['display']) && $popupAd['display'])
        <script>
            $(function() {
                var is_mobile = {{ $platform }};
                var is_safari = navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 &&  navigator.userAgent.indexOf('Android') == -1;
                var controller = new ScrollMagic();
                var mainstarBox = $('.mainstar-wrap'); // 主打星Box

                if (is_mobile) {
                    // mm主打星flag，點擊叉叉關閉
                    $('.i-close').on('click', function() {
                        $(this).parent().attr('style', 'display:none !important');
                    })
                }
                // 主打星Box關閉
                $('.mainstar-close').on('click', function() {
                    $('.mainstar-wrap').css('display', 'none')
                })
            })
        </script>
    @endif
    <script>
        // mm-categoryfilterBox 展開後，定住在頂端 header 下方
        let filterBox = $('#mm-categoryfilterBox');
        let filterBoxHeight = filterBox.height();
        let categoryArrow = $('#categoryArrow');
        let headerHeight = $('.mm-header').height();
        let filterMenu = $('#mm-categoryfilter-menu');
        let menuPosition = parseInt(headerHeight, 10) + parseInt(filterBoxHeight, 10);
        let menuHeight = $(window).height();
        let isOpening = 0;

        filterMenu.css({
            'position': 'sticky',
            'top': menuPosition,
            'z-index': 1050,
            'overflow': 'scorll',
            'height': menuHeight,
            'padding-bottom': $(window).height() * 0.3,
        });

        $(categoryArrow).on('click', function() {

            //規定元素從隱藏到可見的速度為300毫秒
            $(filterMenu).slideToggle(300,function () {
                // 點擊後 展開
                if (isOpening == 0) {
                    console.log('FilterBox is opening.')
                    isOpening = 1;
                    $(filterBox).addClass('sticky-top');
                    $(filterBox).css('top', headerHeight);
                    return;
                }
                // 點擊後 收起
                if (isOpening == 1) {
                    console.log('FilterBox is closing.')
                    isOpening = 0;
                    $(filterBox).removeClass('sticky-top');
                    $(filterBox).css('top', '');
                    return;
                }
            });
        })
    </script>
    <script>
        $(function () {
            // 特別企劃
            $('.special-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 1.3,
                        margin: 10
                    },
                    600: {
                        items: 2,
                        margin: 20
                    },
                    1000: {
                        items: 3,
                        margin: 20
                    }
                }
            });

            // banner
            $('.carousel-first-cover').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
            });

            // mm 類別
            $('.mm-categoryfilter-carousel').owlCarousel({
                margin: 15,
                loop: false,
                autoWidth: true,
                items: 4,
                rewind: false,
            });

            // rs 星級飯店 ＆ sh 名店美食
            $('.brands-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 3.4,
                        margin: 10
                    },
                    600: {
                        items: 4,
                        margin: 20
                    },
                    1000: {
                        items: 6,
                        margin: 20
                    }
                }
            });

            // rs 限時搶購 ＆ bt 限時搶購
            $('.flash-sale-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 2.2,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // rs 新開幕
            $('.grand-opening-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 2.2,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // rs 喝飲料 小編嚴選
            $('.selected-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 2.2,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // bt 連鎖品牌
            $('.branding-carouel').owlCarousel({
                loop: true,
                margin: 20,
                responsive: {
                    0: {
                        items: 2.2,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // es 線上旅展
            $('.es-special-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 1.3,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // es 熱銷類別
            $('.mm-best-selling-carouel').owlCarousel({
                loop: true,
                responsive: {
                    0: {
                        items: 1.6,
                        margin: 15
                    },
                    600: {
                        items: 2.2,
                        margin: 15
                    }
                }
            });

            // mm sh 熱銷類別
            $('.mm-sh-best-carouel').owlCarousel({
                loop: false,
                responsive: {
                    0: {
                        items: 2,
                        margin: 10
                    },
                    600: {
                        items: 2,
                        margin: 20
                    },
                }
            });
        })
    </script>
    <script>
    @if ($platform == 1)
        $(function(){
            const windowWidth = $(window).width() - $('#categoryArrow').width();
            var slider = $('#mm-categoryfilter-slider');
            var owlItem = slider.find('.owl-item');
            var item = slider.find('.item'); // 所有類別
            var active = slider.find('.item.active');
            var length = $(item).length; // 熱門類別按鈕數量
            var index = slider.find('.item').index(active); // 前面第幾個，0 開始計算
            var indexReverse = (parseInt(length) - parseInt(index)) * -1; // 後面倒數第幾個，-1 開始計算
            var backSpacing = 0;
            var breakPoint;
            var sliderEdge;
            // 若是 .active 為後方倒數6個之內就要判斷顯示位置
            if ((length - index) < 7) {
                for (let i = -1; i > -7; i--) {
                    backSpacing += (parseInt(item.eq(i).width()) + 15);
                    if (backSpacing > windowWidth) {
                        breakPoint = i; // 倒數第幾個的後方寬度會 > 螢幕寬度
                        sliderEdge = breakPoint + 1; // owl-carousel 抓取的可滑動節點
                        break;
                    }
                }
                if (indexReverse > sliderEdge) {
                    let width = 0;
                    for (i = 0; i < (length + sliderEdge); i++){
                        width += (item.eq(i).width() + 15);
                    }
                    slider.find('.owl-stage').css({
                        'transform': `translate3d(-${width}px, 0px, 0px)`,
                    });
                } else {
                    sliderDefaultPoint();
                }
            } else {
                sliderDefaultPoint();
            }

            function sliderDefaultPoint() {
                let width = 0;
                for (i = 0; i < length; i++){
                    if (owlItem.eq(i).children().hasClass('active')){
                        // 如果子項目(按鈕本身)有.active，移動到這個按鈕的位置
                        slider.find('.owl-stage').css({
                            'transform': `translate3d(-${width}px, 0px, 0px)`,
                        });
                        break;
                    }
                    width += item.eq(i).width() + 15;
                }
            }
        })
    @endif
    </script>
    <script>
        untilTsCaculate();

        function untilTsCaculate() {
            $('.until-ts').each(function () {
                let $obj = $(this);
                let second_time = $obj.data('untilts');
                second_time = parseInt(second_time);

                let time = '';

                if (second_time > 0) {
                    second_time = second_time - 1;
                    $obj.data('untilts', second_time);


                    time = parseInt(second_time) + "秒";
                    if (parseInt(second_time) > 60) {

                        let second = parseInt(second_time) % 60;
                        let min = parseInt(second_time / 60);
                        time = min + "分" + second + "秒";

                        if (min > 60) {
                            min = parseInt(second_time / 60) % 60;
                            let hour = parseInt(parseInt(second_time / 60) / 60);
                            time = hour + "時" + min + "分" + second + "秒";

                            if (hour > 24) {
                                hour = parseInt(parseInt(second_time / 60) / 60) % 24;
                                let day = parseInt(parseInt(parseInt(second_time / 60) / 60) / 24);
                                time = day + "天" + hour + "時" + min + "分" + second + "秒";
                            }
                        }
                    }
                }
                $obj.html(time);
            });
            setTimeout(untilTsCaculate, 1000);
        }
    </script>
    <script>
        $(function () {
            let loadMoreUrl = '{!! $loadMoreUrl !!}';
            let page = {{ $defaultPage ?? 1 }};
            let isLoading = 0;
            let isMore = @if ($totalPages <= 1) 0 @else 1 @endif

            $('img.lazyload').lazyload();
            $('img.lazyload').each(function() {
                if ($(this).offset().top < $(window).height()) {
                    $(this).trigger('appear');
                }
            })

            $(window).on('scroll', function() {
                var windowHeight = $(window).height();
                var scrollHeight = $(document).height();
                var scrollPosition = $(window).height() + $(window).scrollTop();
                if ((scrollHeight - scrollPosition) <= windowHeight) {
                    $('.btn-loadmore').trigger('click');
                }
            });

            $('body').on('click', '.btn-loadmore', function ()
            {
                if (1 == isLoading) {
                    return;
                }
                if (0 == isMore) {
                    return;
                }

                page++;
                var _url = '{{ url('ch') }}' + loadMoreUrl + page;

                isLoading = 1;
                $.get(_url, function (json) {
                    isLoading = 0;
                    result = $.parseJSON(json);
                    if (result.code != 1) {
                        alert(result.message);
                        return;
                    }

                    if (page >= result.total_pages) {
                        isMore = 0;
                        $('.btn-loadmore').hide();
                    }

                    $('#container__row').append(result.html);
                    $("img.lazyload").lazyload();
                })
            })
        })
    </script>
    <script>
        $(function () {
            $('body').on('click', '.channel-sectionBox .product-card a', function (e) {
                e.preventDefault();

                let targetUrl = e.currentTarget.href;
                let page = $(this).attr('data-page');

                document.cookie = `default_page=${page}; domain=.gomaji.com; path=/`;

                location.href = targetUrl;
            });
        });
    </script>
    <script>
        // 主打星出現
            $(function () {
                let action = "{!! $activityAd['action'] ?? '' !!}"; // 主打星行為模式

                // PC浮水印主打星按鈕
                $(".mainstar-label-wrap").click(function () {
                    // 主打星有2檔才顯示跳窗
                    if (action == 'flagship-product') {
                        $(".mainstar-wrap").slideToggle(300,function () { }); // 規定元素從隱藏到可見的速度為300毫秒
                    }
                });
                // mm浮水印主打星按鈕
                $("#mm-popupAdBtn").click(function () {
                    // 主打星有2檔才顯示跳窗
                    if (action == 'flagship-product') {
                        $(".mainstar-wrap").slideToggle(300,function () { }); // 規定元素從隱藏到可見的速度為300毫秒
                    }
                });
                // mm浮水印主打星的叉叉按鈕
                $("#mm-iconBtn").click(function () {
                    $(this).parent().remove(); // 隱藏主打星浮水印
                });

            });
    </script>
@endsection
