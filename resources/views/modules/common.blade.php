<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--
                            _oo0oo_
                            o8888888o
                            88" . "88
                            (| -_- |)
                            0\  =  /0
                        ___/`---'\___
                        .' \\|     |// '.
                        / \\|||  :  |||// \
                    / _||||| -:- |||||- \
                    |   | \\\  -  /// |   |
                    | \_|  ''\---/''  |_/ |
                    \  .-\__  '-'  ___/-. /
                    ___'. .'  /--.--\  `. .'___
                ."" '<  `.___\_<|>_/___.' >' "".
                | | :  `- \`.;`\ _ /`;.`/ - ` : | |
                \  \ `_.   \_ __\ /__ _/   .-` /  /
            =====`-.____`.___ \_____/___.-`___.-'=====
                            `=---='
            ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                    佛祖保佑         永無bug
                ````````````       ````````````      `````         ````         `````               ````   ````
            `````      ```     `````      `````    ``````       `````        ```````              ````   ````
    -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, min-scale=1, max-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>@if(isset($meta['title'])){!! $meta['title'] !!}@else{{ 'GOMAJI 最大吃喝玩樂平台 | 全台人氣美食、優惠餐廳、五星餐劵、按摩劵、SPA劵、住宿劵' }}@endif</title>
        <meta name="description" content="{{ $meta['description'] ?? '提供優惠餐劵、按摩劵、SPA劵、住宿劵、休息泡湯劵、展覽門票、宅配團購…等優惠劵，生活大小事一次購足！' }}">
        <meta name="keywords" content="{{ $meta['keywords'] ?? '美食,美食餐廳,餐券,BUFFET,SPA,按摩,休息,泡湯,住宿,好康,優惠,優惠劵' }}">
        <meta name="google-site-verification" content="sM6RR2X8YqwtlRWeMbOPcjpEz8BZZoLR_vEhM3dv_Tc" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Graph data FB -->
        <meta property="og:title" content="@if(isset($meta['title'])){!! $meta['title'] !!}@else{{ 'GOMAJI 最大吃喝玩樂平台 | 全台人氣美食、優惠餐廳、五星餐劵、按摩劵、SPA劵、住宿劵' }}@endif" />
        <meta property="og:site_name" content="{{ $meta['ogSiteName'] ?? 'GOMAJI 最大吃喝玩樂平台 | 全台人氣美食、優惠餐廳、五星餐劵、按摩劵、SPA劵、住宿劵' }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="@if(isset($meta['canonicalUrl'])){!! $meta['canonicalUrl'] !!}@else{{ 'https://www.gomaji.com/' }}@endif" />
        <meta property="og:image" content="{{ $meta['ogImage'] ?? 'https://staticdn.gomaji.com/ch_pic/gomaji-com.jpg' }}" />
        <meta property="og:description" content="{{ $meta['description'] ?? '提供優惠餐劵、按摩劵、SPA劵、住宿劵、休息泡湯劵、展覽門票、宅配團購…等優惠劵，生活大小事一次購足！' }}" />
        <!-- END:Graph data FB-->

        <link rel="canonical" href="@if(isset($meta['canonicalUrl'])){!! $meta['canonicalUrl'] !!}@else{{ 'https://www.gomaji.com/' }}@endif">

        <link rel="SHORTCUT ICON" href="{{ url('favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ url('images/touch-icon-120x120.png') }}" />
        <link rel="apple-touch-icon" sizes="152x152" href="{{ url('images/touch-icon-152x152.png') }}" />
        <link rel="apple-touch-icon" sizes="167x167" href="{{ url('images/touch-icon-167x167.png') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/touch-icon-180x180.png') }}" />
        <link rel="apple-touch-icon" sizes="192x192" href="{{ url('images/touch-icon-192x192.png') }}" />
        <link rel="icon" sizes="128x128" href="{{ url('images/touch-icon-128x128.png') }}" />
        <link rel="icon" sizes="192x192" href="{{ url('images/touch-icon-192x192.png') }}" />

        <!-- css外部-->
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/bootstrap/4.4.1/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/jquery.fancybox.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/jquery-ui.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/owl.carousel.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/sweetalert.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/font-awesome.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/autocomplete.css') }}" />
        <!-- css -->

        <link rel="stylesheet" type="text/css" href="{{ url('css/base.css?1677120652') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/main.css?1678848352') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/layout.css?1677120652') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/responsive.css?1678848352') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/theme.css?1676711097') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/common.css?1613807556') }}">
        <!-- End:css-->
        @yield('css')
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WNT85FG');</script>
        <!-- End Google Tag Manager -->
        <!-- jsonld -->
        @include('layouts.jsonld.organization')
        @include('layouts.jsonld.website')
        <!-- 商品資訊(檔次頁、店家頁、頻道頁、關於我們、公司記事、媒體報導、隱私權保護政策、服務條款、客服中心、聯絡我們、網紅頁、聰明賺點列表、聰明賺點詳細頁) -->
        @if (!empty($webType) && ($webType == 'channel' || $webType == 'product' || $webType == 'store' || $webType == 'about' || $webType == 'privacy' || $webType == 'terms' || $webType == 'help' || $webType == 'contact' || $webType == 'coffee' || $webType == 'brand' || $webType == 'brandList' || $webType == 'category' || $webType == 'special' || $webType == 'specialList' || $webType == '510' || $webType == 'chSpecial' || $webType == 'search' || $webType == 'kol' || $webType == 'earnpoint' || $webType == 'esForeign' || $webType == 'earnpointDetail'))
            @include('layouts.jsonld.breadCrumbList')
        @endif
        <!-- 輪播介面（首頁、頻道頁、店家頁、聰明賺點列表）-->
        @if (!empty($webType) && ($webType == 'index' || $webType == 'channel' || $webType == 'store' || $webType == 'coffee' || $webType == 'brand' || $webType == 'brandList' || $webType == 'category' || $webType == 'special' || $webType == 'specialList' || $webType == '510' || $webType == 'chSpecial' || $webType == 'search'|| $webType == 'earnpoint' || $webType == 'esForeign'))
            @include('layouts.jsonld.itemList')
        @endif
        <!-- 當地商家(店家頁) -->
        @if (!empty($webType) && $webType == 'store')
            @include('layouts.jsonld.restaurant')
        @endif
        <!-- 商品資訊(檔次頁) -->
        @if (!empty($webType) && $webType == 'product')
            @include('layouts.jsonld.product')
        @endif
        <!-- FAQPage(客服中心) -->
        @if (!empty($webType) && $webType == 'help')
            @include('layouts.jsonld.FAQPage')
        @endif
        <!-- End jsonld -->

    </head>
    <body data-spy="scroll">
        <div class="wrapper relation">
            <div class="overlay"></div>

            @if (!empty($isShowMicroHeader))
                @include('layouts.headerMicro')
            @elseif (!empty($isShowLightHeader))
                @include('layouts.headerLight')
            @elseif (!empty($isShowHeader))
                @include('layouts.header')
            @endif

            @include('layouts.watermark')

            @yield('content')

            @if (!empty($isShowFooter))
                @include('layouts.footer')
            @endif

        </div>
        <!-- End:wrapper -->

        @include('layouts.popup')

        @yield('popup')

    </body>

    <!-- 共用js -->
    <script src="https://kit.fontawesome.com/923eda4210.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js?1677228863') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/owl.carousel.min.js?1624863302') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery.lazyload.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery.cookie.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/autocomplete.js?1648694185') }}"></script>
    <script type="text/javascript" src="{{ url('js/main.js?1650535511') }}"></script>

    @yield('script')

</html>
