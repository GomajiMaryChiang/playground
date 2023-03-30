@extends('modules.common')

@section('content')
    <div class="gomaji-banners-wrapper {{ $theme }}">
        <div class="container padding-0">
            <div class="row no-gutters">
                <!-- Banner -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row no-gutters">
                        @if (!empty($bannerList))
                            <div class="col-lg-8 col-md-12 col-sm-12">
                                <div class="first-cover owl-carousel owl-loaded owl-drag" id="carousel-first-cover">
                                    @foreach ($bannerList as $banner)
                                        <div class="item">
                                            <a href="{{ $banner['link'] ?? '#' }}"><img class="img-fluid lazyload" src="{{ $banner['img'] ?? '' }}" alt="{{ $banner['subject'] ?? '' }}"></a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (!empty($secondBannerList) || !empty($thirdBannerList))
                            <div class="col-lg-4 col-md-12 col-sm-12 pl-2">
                                @if (!empty($secondBannerList))
                                    @foreach ($secondBannerList as $secondBanner)
                                        <div class="second-cover">
                                            <a href="{{ $secondBanner['link'] ?? '#' }}">
                                                <img class="img-fluid" src="{{ $secondBanner['img'] ?? '' }}" alt="{{ $secondBanner['subject'] ?? '' }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                @if (!empty($thirdBannerList))
                                    @foreach ($thirdBannerList as $thirdBanner)
                                        <div class="third-cover">
                                            <a href="{{ $thirdBanner['link'] ?? '#' }}">
                                                <img class="img-fluid" src="{{ $thirdBanner['img'] ?? '' }}" alt="{{ $thirdBanner['subject'] ?? '' }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End: Banner -->
                <!-- 頻道icon -->
                @if (!empty($channelList))
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h1 class="hidden">GOMAJI最大吃喝玩樂平台14大頻道</h1>
                        <!-- mm-channel-wrapper -->
                        <div class="mm-channel-wrapper">
                            <div class="mm-channelBox mm-channel-carousel owl-carousel owl-theme border border-r">
                                @foreach ($channelList as $channelAry)
                                    <div class="channel-list">
                                        @foreach ($channelAry as $chId => $channel)
                                            <div class="channel-item">
                                                <a class="channel" href="{{ $channel['url'] ?? '#' }}" data-id="{{ $chId }}">
                                                    <img class="mx-auto d-block img-fluid" src="{{ $channel['icon'] ?? '' }}" alt="{{ $channel['title'] ?? '' }}">
                                                    <div class="title text-center">{{ $channel['title'] ?? '' }}</div>
                                                    <div class="badge bg-danger">{{ $channel['badge'] ?? '' }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End:mm-channel-wrapper -->
                        <!-- channel-wrapper -->
                        <div class="channel-wrapper d-flex justify-content-around">
                            @foreach ($channelList as $channelAry)
                                <div class="channel-list">
                                    @foreach ($channelAry as $chId => $channel)
                                        <div class="channel-item">
                                            <a class="channel" href="{{ $channel['url'] ?? '#' }}" data-id="{{ $chId }}">
                                                <img class="mx-auto d-block img-fluid" src="{{ $channel['icon'] ?? '' }}" alt="{{ $channel['title'] ?? '' }}">
                                                <div class="title text-center">{{ $channel['title'] ?? '' }}</div>
                                                <div class="badge bg-danger">{{ $channel['badge'] ?? '' }}</div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <!-- End:channel-wrapper -->
                    </div>
                @endif
                <!-- End: 頻道icon -->
            </div>
        </div>
    </div>
    <!-- End: home-banners-wrapper -->
    <main class="main">
        <!-- 活動浮水印 -->
        @isset($activityAd['enable'])
            @if ($activityAd['display'])
                <div class="activity-ad" style="display: block;">
                    <span class="icon i-close" onclick="iconClose();"></span>
                    @if ($activityAd['action'] == 'url')
                        <a href="{{ $activityAd['link'] }}"><img src="{{ $activityAd['img'] }}" alt="{{ $activityAd['alt'] }}"></a>
                    @endif
                </div>
            @endif
        @endisset
        <!-- End: 活動浮水印 -->

        <!-- 9點開搶 只賣今天 -->
        <div class="sectionBox todayshootat9">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 section-head relative padding-0">
                        <h2><span class="head"><span>9</span>點開搶</span><i class="icon i-lightning"></i><span class="bgArrow-triangle"></span></h2>
                        @if (!empty($todaySpecialList))
                            <div id="countdown" class="countdown">
                                <ul>
                                    <li><span id="hours">00</span>:</li>
                                    <li><span id="minutes">00</span>:</li>
                                    <li><span id="seconds">00</span></li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- 大 DD -->
                    @if (!empty($todaySpecialList))
                        <div class="col-lg-4 col-md-4 padding-0">
                            <!-- PC 大 DD -->
                            <div class="PC-todayshoot {{ $todaySpecialClass ?? '' }}">
                                <div class="PC-todayshoot PC-todayshoot-carousel owl-carousel owl-theme" id="PC-todayshoot-carousel">
                                    @foreach ($todaySpecialList as $todaySpecial)
                                        @include('layouts.product.todaySpecial')
                                    @endforeach
                                </div>
                            </div>
                            <!-- End: PC 大 DD -->

                            <!-- mm 大 DD -->
                            <div class="mobile-todayshoot">
                                @foreach ($todaySpecialList as $todaySpecial)
                                    @include('layouts.product.mmTodaySpecial')
                                @endforeach
                            </div>
                            <!-- End: mm 大 DD -->
                        </div>
                    @endif
                    <!-- End: 大 DD -->

                    <!-- 小 DD -->
                    @if (!empty($todaySubSpecialList))
                        <div class="col-lg-8 col-md-8 padding-02">
                            <div class="row no-gutters">
                                <div class="todayspecial todayspecial-carousel owl-carousel owl-theme border border-r" id="todayspecial-carousel">
                                    @foreach ($todaySubSpecialList as $todaySubSpecial)
                                        @include('layouts.product.todaySubSpecial')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- End: 小 DD -->
                </div>
            </div>
        </div>
        <!-- End: 9點開搶 只賣今天 -->

        <!-- 下載APP Banner -->
        <div class="sectionBox adBanner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <a data-fancybox="" data-src="#welcome-app-popup" href="javascript:;">
                            <img class="img-fluid" src="{{ url('/images/newuser-2020.jpg') }}" alt="ads">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: 下載APP Banner -->

        <!-- 星級飯店品牌 -->
        @if (!empty($rsBrandList))
            @include('layouts.carousel.picture', ['pictureList' => $rsBrandList])
        @endif
        <!-- End: 星級飯店品牌 -->

        <!-- 熱門類別 -->
        @if (!empty($hotCatList))
            <div class="sectionBox hot-categoryBox bg-gray mt-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 section-head relative padding-0">
                            <h2>熱門類別</h2>
                        </div>
                        <div class="col-md-12 section-stage padding-02">
                            <div class="hot-category">
                                <ul>
                                    @foreach ($hotCatList as $hotCat)
                                        <li class="hot-category-item">
                                            <a class="{{ $hotCat['active'] ? 'active' : '' }}" href="{{ $hotCat['link'] ?? '#' }}">{{ $hotCat['name'] ?? '' }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mm-hot-category relative">
                                <div class="mm-hot-category-carouel owl-carousel owl-theme">
                                    @foreach ($mmHotCatList as $mmHotCat)
                                        <div class="item">
                                            <ul>
                                                @foreach ($mmHotCat as $mmHotCatSub)
                                                    <li class="hot-category-item">
                                                        <a class="{{ $mmHotCatSub['active'] ? 'active' : '' }}" href="{{ $mmHotCatSub['link'] ?? '#' }}">{{ $mmHotCatSub['name'] ?? '' }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- End: 熱門類別 -->

        <!-- 好站★好讚 -->
        @if (!empty($awesomeWebsites))
            @include('layouts.carousel.picture', ['pictureList' => $awesomeWebsites])
        @endif
        <!-- End: 好站★好讚 -->

        <!-- 聰明賺點 -->
        @if (!empty($affiliateList))
            @include('layouts.carousel.picture', ['pictureList' => $affiliateList])
        @endif
        <!-- End: 聰明賺點 -->

        <!-- 熱銷宅配生鮮美食 -->
        @if (!empty($esForeignList))
            @include('layouts.carousel.picture', ['pictureList' => $esForeignList])
        @endif
        <!-- End: 熱銷宅配生鮮美食 -->

        <!-- 旅遊行程推薦 -->
        @if (!empty($esMarketList))
            @include('layouts.carousel.picture', ['pictureList' => $esMarketList])
        @endif
        <!-- End: 旅遊行程推薦 -->

        <!-- 特別企劃 -->
        @if (!empty($specialList))
            @include('layouts.carousel.picture', ['pictureList' => $specialList])
        @endif
        <!-- End: 特別企劃 -->

        <!-- 排行榜 -->
        @if (!empty($rankingList))
            @include('layouts.carousel.picture', ['pictureList' => $rankingList])
        @endif
        <!-- End: 排行榜 -->

        <!-- 100元做公益 -->
        @if (!empty($welfareList))
            @include('layouts.carousel.picture', ['pictureList' => $welfareList])
        @endif
        <!-- End: 100元做公益 -->

        <!-- 今日上架 -->
        @if (!empty($recommendList))
            <div class="sectionBox main-sectionBox bg-gray">
                <div class="container">
                    <div class="row" id="container__row">
                        <div class="col-md-12 main-head">
                            <h2 class="text-center">今日上架</h2>
                        </div>
                        @foreach ($recommendList as $recommend)
                            @if ($recommend['product_kind'] == 4)
                                @include('layouts.product.recommendBanner')
                            @else
                                @include('layouts.product.recommendProduct')
                            @endif
                        @endforeach
                    </div>
                    @if ($totalPage > 1)
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input class="btn-loadmore btn btn-outline-main w-30 loadingmore" value="看更多" data-lt="載入中…" type="button">
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <!-- End: 今日上架 -->
    </main>
    <!-- End: main -->
@endsection

@section('popup')
    <!-- Popup:welcome-app-popup -->
    <div style="display: none;" id="welcome-app-popup" class="popupBox welcome-app-popup w-35">
        <div class="newuserBox">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-7">
                        <h3 class="text-white text-center">下載 APP，輸入優惠碼<br><q>GOMAJI</q>拿 $100</h3>
                        <p class="text-white t-09 text-center mb-3">1 點 = 1 元，餐劵、住宿劵、SPA 按摩劵、<br>門票展覽、宅配團購…等全站抵用。</p>
                        <div class="row">
                            <div class="col-6">
                                <a href="https://itunes.apple.com/tw/app/id431218690?mt=8" target="_blank" rel="noopener">
                                    <img src="{{ url('images/etc/ios_btn.png') }}" alt="GOMAJI APP">
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="https://play.google.com/store/apps/details?id=com.wantoto.gomaji2&referrer=utm_source%3Dofficial_site%26utm_medium%3Dapp_dl_page%26utm_campaign%3Dindex"
                                    target="_blank" rel="noopener">
                                    <img src="{{ url('images/etc/googleplay_btn.png') }}" alt="GOMAJI APP">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="qrcode">
                            <img src="{{ url('images/etc/qrcode.png') }}" alt="GOMAJI APP QRCode" width="150">
                            <p class="t-085 t-white text-center mt-1">打開 APP 並登入
                                <i class="fas fa-angle-right"></i> 選擇<br>「賺取點數 / 輸入優惠碼」
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:welcome-app-popup -->

    <!-- Popup:announcement公告  -->
    <div style="display: none;" id="announcement-popup" class="popupBox w-20">
        <div class="announcement">
            <h2 class="t-white">公告</h2>
            <p class="text-center">{{ $announcement }}</p>
        </div>
        <p class="d-flex justify-content-center mt-3">
            <button data-fancybox-close="" class="btn btn-main w-100" href="#">謝謝您的支持！</button>
        </p>
    </div>
    <!-- End:announcement公告 -->
@endsection

@section('script')
    <script>
        $(function () {
            // lazyload
            $('img.lazyload').lazyload();

            // banner
            $('#carousel-first-cover').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
            });

            // mm channel
            $('.mm-channel-carousel').owlCarousel({
                nav: true,
                stagePadding: 15,
                loop: false,
                responsive: {
                    0: {
                        items: 4,
                        margin: 0,
                    },
                    600: {
                        items: 2,
                        margin: 15,
                    },
                    1000: {
                        items: 7,
                        margin: 20,
                    },
                },
            });

            // 大 DD
            $('#PC-todayshoot-carousel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                margin: 0,
                nav: true,
                stagePadding: 0,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            // 小 DD
            $('#todayspecial-carousel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: false,
                margin: 0,
                nav: true,
                stagePadding: 15,
                responsive: {
                    0: {
                        items: 3,
                        margin: 0
                    },
                    600: {
                        items: 2,
                        margin: 15
                    },
                    1000: {
                        items: 3,
                        margin: 20
                    }
                }
            });

            // 星級飯店
            $('#brands-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
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

            // mm 熱門類別
            $('.mm-hot-category-carouel').owlCarousel({
                loop: false,
                margin: 0,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            // 聰明賺點
            $('#makemoney-carousel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.3,
                        margin: 10
                    },
                    600: {
                        items: 4,
                        margin: 20
                    },
                    1000: {
                        items: 5,
                        margin: 20
                    }
                }
            });

            // 熱銷宅配生鮮美食
            $('#buy-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.3,
                        margin: 10
                    },
                    600: {
                        items: 4,
                        margin: 20
                    },
                    1024: {
                        items: 5,
                        margin: 20
                    },
                    1200: {
                        items: 6,
                        margin: 20
                    }
                }
            });

            // 旅遊行程推薦
            $('#trip-carouel, #awesomeWebsites-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.3,
                        margin: 10,
                    },
                    600: {
                        items: 3,
                        margin: 20,
                    },
                    1000: {
                        items: 4,
                        margin: 20,
                    },
                },
            });

            // 特別企劃
            $('#special-carouel').owlCarousel({
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

            // 排行榜
            $('#billboard-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.3,
                        margin: 10
                    },
                    600: {
                        items: 4,
                        margin: 20
                    },
                    1024: {
                        items: 5,
                        margin: 20
                    },
                    1200: {
                        items: 6,
                        margin: 20
                    }
                }
            });

            // 100元做公益
            $('#welfare-carousel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.3,
                        margin: 10
                    },
                    600: {
                        items: 4,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // 公告跳窗
            let announcement = '{{ $announcement ?? "" }}';
            if (announcement != '') {
                $.fancybox.open({
                    src: '#announcement-popup'
                });
            }

            // 訂閱電子報跳窗
            let isShowEpaper = '{{ $isShowEpaper ?? false }}';
            if (isShowEpaper) {
                $.fancybox.open({
                    src: '#epaper'
                });
            }

            // 9點開搶只賣今天倒數
            const second = 1,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

            let distance = '{{ $todaySpecialList[0]['count_down'] ?? 0 }}';

            let interval = setInterval(function () {
                if (distance <= 0) {
                    clearInterval(interval);
                    return;
                }
                distance--;
                document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour));
                document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute));
                document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
            }, 1000);

            // 今日上架倒數
            untilTsCaculate();

            // 分頁
            let page = 1;
            let isLoading = 0;
            let isMore = {{ $totalPage <= 1 ? 0 : 1 }};

            $(window).on('scroll', function() {
                var windowHeight = $(window).height();
                var scrollHeight = $(document).height();
                var scrollPosition = $(window).height() + $(window).scrollTop();
                if ((scrollHeight - scrollPosition) <= windowHeight) {
                    $('.loadingmore').trigger('click');
                }
            });

            $('body').on('click', '.loadingmore', function() {
                if (1 == isLoading) {
                    return;
                }
                if (0 == isMore) {
                    return;
                }

                page++;
                let _url = `/?page=${page}`;

                isLoading = 1;
                $.get(_url, function(json) {
                    isLoading = 0;
                    result = $.parseJSON(json);
                    if (result.code != 1) {
                        alert(result.message);
                        return;
                    }

                    if (page >= result.totalPage) {
                        isMore = 0;
                        $('.loadingmore').hide();
                    }

                    $('#container__row').append(result.html);
                    $("img.lazyload").lazyload();
                });
            });

            // 點擊頻道 icon awesome_websites
            // goAwesomeWebsites由於是轉頁gotour、宅配嚴選、宅配購物，所以跟頻道一樣處理登入
            $('.channel-wrapper a, .mm-channel-wrapper a, .goChannelPage, .goAwesomeWebsites').click(function (e) {
                e.preventDefault();
                let url = e.currentTarget.attributes.href.value;
                let chId = $(this).data('id');
                let t = `{{ $cookieAry['t'] }}`;

                if (t && chId === {{ Config::get('channel.id.buy123') }}) {
                    loginBuy123(url);
                    return;
                }

                if (t && chId === {{ Config::get('channel.id.esMarket') }}) {
                    loginEsmarket(url);
                    return;
                }

                if (t && chId === {{ Config::get('channel.id.shopify') }}) {
                    handleShopify(url);
                    return;
                }

                window.location.href = url;
            });
        });

        /*
         * 登入生活市集
         */
        function loginBuy123(url)
        {
            let t = `{{ $cookieAry['t'] }}`;

            axios({
                method: 'post',
                url: '/api/loginBuy123',
                data: {
                    t
                },
                config: {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    responseType: 'json',
                },
            }).then(function(response) {

                if (typeof(response) == 'undefined' || response == '') {
                    window.location.href = url;
                }

                let gmcSitePay = $('#gmcSitePay').val();
                let res = (response.hasOwnProperty('data') && response.data.hasOwnProperty('data')) ? response.data.data : {};
                let param = {
                    gm_uid: $.cookie('gm_uid'),
                    token: res.hasOwnProperty('gb_t') ? res.gb_t : '',
                    ts: res.hasOwnProperty('gb_ts') ? res.gb_ts : '',
                    expire_ts: res.hasOwnProperty('gb_ets') ? res.gb_ets : '',
                    reg_email: res.hasOwnProperty('gb_el') ? res.gb_el : ''
                };
                if (gmcSitePay === 'ref_457') {
                    param.s_banner = '85shop';
                }

                window.location.href = `https://buy123.gomaji.com/redirect/gomaji_login?${jQuery.param(param)}&redirect=${encodeURI(url)}`;

            }).catch(function (error) {
                console.log(error);
            });
        }

        /*
         * 登入 ES 商城
         */
        function loginEsmarket(url)
        {
            let t = `{{ $cookieAry['t'] }}`;

            axios({
                method: 'post',
                url: '/api/loginEsmarket',
                data: {
                    t
                },
                config: {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    responseType: 'json',
                },
            }).then(function(response) {

                if (typeof(response) == 'undefined' || response == '') {
                    window.location.href = url;
                }

                let urlObj = new URL(url);
                let res = response.hasOwnProperty('data') ? response.data : {};
                let data = res.hasOwnProperty('data') ? res.data : {};
                let gb_t = data.hasOwnProperty('gb_t') ? data.gb_t : '';
                let gb_ts = data.hasOwnProperty('gb_ts') ? data.gb_ts : '';
                let gb_ets = data.hasOwnProperty('gb_ets') ? data.gb_ets : '';
                let gb_el = data.hasOwnProperty('gb_el') ? data.gb_el : '';
                let param = {
                    gm_uid: $.cookie('gm_uid'),
                    gb_t,
                    gb_ts,
                    gb_ets,
                    gb_el
                };

                if (urlObj.search === '') {
                    window.location.href = `${url}?${jQuery.param(param)}`;
                } else {
                    window.location.href = `${url}&${jQuery.param(param)}`;
                }

            }).catch(function (error) {
                console.log(error);
            });
        }

        /*
         * 處理 Shopify 登入
         */
        function handleShopify(url)
        {
            let gb_sel = `{{ $cookieAry['gb_sel'] }}`;
            let gb_el = `{{ $cookieAry['gb_el'] }}`;

            if (gb_sel) {
                redirectShopify(url);
                return;
            }

            if (gb_el) {
                loginShopify(url);
                return;
            }

            logout('請重新登入', `/login?goto=${url}`);
            return;
        }

        /*
         * 登入 Shopify
         */
        function loginShopify(url)
        {
            let t = `{{ $cookieAry['t'] }}`;
            let gb_el = decodeURIComponent(`{{ $cookieAry['gb_el'] }}`);

            axios({
                method: 'post',
                url: '/api/loginShopify',
                data: {
                    t,
                    gb_el,
                    url,
                    email: ''
                },
                config: {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    responseType: 'json',
                },
            }).then(function(response) {

                if (typeof(response) == 'undefined' || response == '') {
                    window.location.href = url;
                }

                let res = response.hasOwnProperty('data') ? response.data : {};
                let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                let description = res.hasOwnProperty('description') ? res.description : '';
                let data = res.hasOwnProperty('data') ? res.data : {};
                let gb_sel = data.hasOwnProperty('gb_sel') ? data.gb_sel : '';
                let multipassUrl = data.hasOwnProperty('multipass_url') ? data.multipass_url : '';

                if (returnCode !== '0000') {
                    logout(description, `/login?goto=${url}`);
                    return;
                }

                document.cookie = `gb_sel=${encodeURIComponent(gb_sel)}; domain=.gomaji.com; path=/`;
                window.location.href = multipassUrl;

            }).catch(function (error) {
                console.log(error);
            });
        }

        /*
         * 取得 Shopify 網址
         */
        function redirectShopify(url)
        {
            let t = `{{ $cookieAry['t'] }}`;
            let gb_sel = decodeURIComponent(`{{ $cookieAry['gb_sel'] }}`);

            axios({
                method: 'post',
                url: '/api/redirectShopify',
                data: {
                    t,
                    gb_sel,
                    url
                },
                config: {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    responseType: 'json',
                },
            }).then(function(response) {

                if (typeof(response) == 'undefined' || response == '') {
                    window.location.href = url;
                }

                let res = response.hasOwnProperty('data') ? response.data : {};
                let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                let description = res.hasOwnProperty('description') ? res.description : '';
                let data = res.hasOwnProperty('data') ? res.data : {};
                let multipassUrl = data.hasOwnProperty('multipass_url') ? data.multipass_url : '';

                if (returnCode !== '0000') {
                    logout(description, `/login?goto=${url}`);
                    return;
                }

                window.location.href = multipassUrl;

            }).catch(function (error) {
                console.log(error);
            });
        }

        /*
         * 關閉浮水印
         */
        function iconClose()
        {
            $('.activity-ad').remove();
        }

        /*
         * 倒數時間
         */
        function untilTsCaculate()
        {
            $('.until-ts').each(function ()
            {
                let $obj = $(this);
                let second_time = $obj.data('untilts');
                second_time = parseInt(second_time);

                let time = '';

                if (second_time > 0) {
                    second_time = second_time - 1;
                    $obj.data('untilts', second_time);

                    time = parseInt(second_time) + '秒';
                    if (parseInt(second_time) > 60) {

                        let second = parseInt(second_time) % 60;
                        let min = parseInt(second_time / 60);
                        time = min + '分' + second + '秒';

                        if (min > 60) {
                            min = parseInt(second_time / 60) % 60;
                            let hour = parseInt(parseInt(second_time / 60) / 60);
                            time = hour + '時' + min + '分' + second + '秒';

                            if (hour > 24) {
                                hour = parseInt(parseInt(second_time / 60) / 60) % 24;
                                let day = parseInt(parseInt(parseInt(second_time / 60) / 60) / 24);
                                time = day + '天' + hour + '時' + min + '分' + second + '秒';
                            }
                        }
                    }
                }
                $obj.html(time);
            });

            setTimeout(untilTsCaculate, 1000);
        }
    </script>
@endsection
