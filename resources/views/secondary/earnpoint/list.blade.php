@extends('modules.common')

@section('content')
    <div class="gomaji-banners-wrapper">
        <!-- theme是控制背景主題 -->
        <div class="container padding-0">
            <div class="row no-gutters">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
                        <li class="breadcrumb-item active" aria-current="page">聰明賺點</li>
                    </ol>
                </nav>
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
            </div>
        </div>
    </div>
    <!-- End:home-banners-wrapper -->
    <main class="main">
        <div class="sectionBox earnpointBox">
            <div class="container">
                <div class="row">
                    @if (!empty($earnpointList))
                        <div class="col-md-12 main-head padding-0">
                            <h2 class="text-center pc-header">聰明賺點</h2>
                            <h2 class="text-center mm-header">全部特約商店</h2>
                        </div>
                        @foreach ($earnpointList as $earnpoint)
                            <div class="col-6 col-xl-3 col-lg-6 col-md-6 col-sm-6 padding-05">
                                <div class="brand-card border bg-white">
                                    <a href="{{ $earnpoint['link'] ?? '#' }}">
                                        <div class="brand-img border-bottom relative">
                                            <img class="img-fluid" src="{{ $earnpoint['store_logo'] ?? '' }}" alt="{{ $earnpoint['store_name'] ?? '' }}">
                                        </div>
                                    </a>
                                    <div class="brand-detail">
                                        @if (!empty($earnpoint['main_reward']))
                                            <h3 class="text-center">最高贈<span class="t-main">{{ $earnpoint['main_reward'] }}</span>點數回饋</h3>
                                        @endif
                                        @if (!empty($earnpoint['promo_code']))
                                            <div class="copycodeBox text-center">
                                                <p class="t-09 t-gray">優惠碼</p>
                                                <a class="copycode text-center copy-share" href="javascript:;" data-clipboard-text="{{ $earnpoint['promo_code'] }}">複製 {{ $earnpoint['promo_code'] }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- End:星級飯店品牌 -->
        <div class="sectionBox earnpointBox bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 earnpoint-policy">
                        <h2 class="text-center">簡單4步驟 點數聰明賺</h2>
                        <img class="img-fluid pc-policy-step" src="{{ url('/images/earnpoint-step.png') }}" alt="點數聰明賺4步驟">
                        <img class="img-fluid mm-policy-step" src="{{ url('/images/mm-earnpoint-step-1.png') }}" alt="點數聰明賺4步驟">
                        <img class="img-fluid mm-policy-step" src="{{ url('/images/mm-earnpoint-step-2.png') }}" alt="點數聰明賺4步驟">
                        <h3>辦法說明：</h3>
                        <ul>
                            <li>本頻道羅列之商家網站為 GOMAJI 聯盟行銷合作夥伴。</li>
                            <li>前往商家網站前請先完成 GOMAJI 手機認證以利後續點數回饋。</li>
                            <li>於商家網站交易前，請先仔細閱讀注意事項，以確保核發點數。如未依照指示交易，將無法獲得點數或補發。</li>
                            <li>如欲取消或更改於商家網站交易之訂單，請依照商家網站之條款與細則約束，並洽商家網站客服。</li>
                            <li>GOMAJI 僅提供點數回饋，如訂單產品內容或服務有任何疑問，敬請洽詢商家網站客服尋求協助。</li>
                            <li>GOMAJI 點數回饋依商家網站通過審核時間為主。點數效期為匯入後30天，過期無法延長。點數使用規則請依 <a class="underline t-main" href="{{ url('/help?faq=18.1#question-18-1') }}" target="_blank">GOMAJI 點數使用辦法</a>。</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('js/assets/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/clipboard.min.js') }}"></script>
    <script>
        $(function () {
            $('img.lazyload').lazyload();

            // banner
            $('#carousel-first-cover').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
            });

            // 複製
            new Clipboard('.copycode');

            // 複製成功跳窗
            $('.copycode').click(function (e) {
                swal('複製成功', '', 'success');
            });
        });
    </script>
@endsection
