<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"
            name="viewport">
        <title>GOMAJI APP 首次下載現賺$100！</title>
        <meta name="keywords" content="GOMAJI、餐券、SPA、訂房、宅配、購物、便宜、優惠、按摩、休息、泡湯、國旅卡、住宿、免運、美食">
        <meta name="description" property="og:description"
            content="GOMAJI 最大吃喝玩樂平台APP，提供優惠餐券、按摩券、SPA券、住宿券、展覽門票、宅配團購、訂房(國旅卡適用)…等優惠券，生活大小事一次購足，首次下載APP現賺100元點數！" />
        <link rel="SHORTCUT ICON" href="https://www.gomaji.com/favicon.ico">
        <!--設計需要修改_開始-->
        <meta property="og:site_name" content="GOMAJI 夠麻吉" />
        <meta property="og:url" content="https://www.gomaji.com/app" />
        <meta property="og:image" content="{{ url('/img/app-thumb.jpg') }}" />
        <meta property="og:title" content="GOMAJI 最大吃喝玩樂平台" />
        <meta property="og:description" content="GOMAJI 最大吃喝玩樂平台 下載APP並輸入邀請碼：GOMAJI，現賺100元點數！" />
        <!--新版開始-->

        <!--給FB-->
        <link href="{{ url('/img/app-thumb.jpg') }}" rel="image_src" type="image/jpeg">

        <!--給下方line-->
        <meta property="gm:share" content="enable" />
        <meta property="gm:url" content="https://www.gomaji.com/app" />
        <meta property="gm:message" content="GOMAJI 最大吃喝玩樂平台 下載APP並輸入邀請碼：GOMAJI，現賺100元點數！" />
        <!--設計需要修改_結束-->

        <!--CSS開始-->
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/bootstrap/4.4.1/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/jquery.fancybox.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/sweetalert.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/assets/font-awesome.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/app.css?1631006804') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/app-responsive.css?1612511400') }}" />
        <!--CSS結束-->

        <!--數字不會開啟撥號_開始-->
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="address=no">
        <!--數字不會開啟撥號_結束-->

        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-MG359L');</script>
        <!-- End Google Tag Manager -->
        <!-- Start Alexa Certify Javascript -->
        <script type="text/javascript">
            _atrk_opts = { atrk_acct: "sMjZh1aon800Mv", domain: "gomaji.com", dynamic: true };
            (function () { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(as, s); })();
        </script>
        <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=sMjZh1aon800Mv" style="display:none"
                height="1" width="1" alt="" /></noscript>
        <!-- End Alexa Certify Javascript -->

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->

        @include('layouts.jsonld.organization')
        @include('layouts.jsonld.website')
        @include('layouts.jsonld.breadCrumbList')
    </head>
    <body id="top">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v10.0&appId=132670053446111&autoLogAppEvents=1" nonce="FmRKo6k3"></script>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WNT85FG" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!--Start:主視覺開始-->
        <div class="wrapper">
            <div id="foodtop-box" class="topBtn down">
                <a href="#top" id="topbtn">
                    <i class="chevron-up" aria-hidden="true"></i>
                    <span>TOP</span>
                </a>
            </div>
            <div class="tabBox">
                <div class="container">
                    <div class="row">
                        <ul class="tabs">
                            <li><a href="#tabs-1">APP 獨享好康</a></li>
                            <li><a href="#tabs-2">八大服務特色</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="wrap-topview">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 titleBox">
                            <img class="title" src="{{ url('/images/app/title.png') }}" alt="GOMAJI APP 下載點數輕鬆賺！">
                            <img class="m-title w-100" src="{{ url('/images/app/m_title.png') }}" alt="GOMAJI APP 下載點數輕鬆賺！">
                            <!--APP下載連結發送手機連結-->
                            <div class="app-download">
                                <div class="app-download-area d-flex">
                                    <div class="app-download-btn">
                                        <a href="https://itunes.apple.com/tw/app/id431218690?mt=8" target="_blank" rel="noopener">
                                            <img class="w-100" src="{{ url('/images/app/ios_bt.png') }}" alt="GOMAJI APP">
                                        </a>
                                    </div>
                                    <div class="app-download-btn">
                                        <a href="https://play.google.com/store/apps/details?id=com.wantoto.gomaji2&amp;referrer=utm_source%3Dofficial_site%26utm_medium%3Dapp_dl_page%26utm_campaign%3Dindex"
                                            target="_blank" rel="noopener">
                                            <img class="w-100" src="{{ url('/images/app/android_bt.png') }}" alt="GOMAJI APP">
                                        </a>
                                    </div>
                                </div>
                                <div class="app-download-phone">
                                    <p class="text-center t-11">免費！傳送下載連結至手機</p>
                                    <div class="input-group mb-3">
                                        <input type="text" name="mobile" class="form-control" placeholder="手機號碼(例如：0912345678)"
                                            aria-label="手機號碼" aria-describedby="button-addon">
                                        <div class="input-group-append">
                                            <button class="font_bt btn btn-orange" type="button" id="button-addon">確認</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End:APP下載連結發送手機連結-->
                            <!--invite firend APP下載連結-->
                            <div class="app-invite-download" style="display: none;">
                                <div class="app-invite-download-area d-flex">
                                    <div class="app-download-btn">
                                        <a href="https://itunes.apple.com/tw/app/id431218690?mt=8" target="_blank" rel="noopener">
                                            <img class="w-100" src="{{ url('/images/app/ios_bt.png') }}" alt="GOMAJI APP">
                                        </a>
                                        <a href="https://play.google.com/store/apps/details?id=com.wantoto.gomaji2&amp;referrer=utm_source%3Dofficial_site%26utm_medium%3Dapp_dl_page%26utm_campaign%3Dindex"
                                            target="_blank" rel="noopener">
                                            <img class="w-100" src="{{ url('/images/app/android_bt.png') }}" alt="GOMAJI APP">
                                        </a>
                                    </div>

                                    <div class="qrcode">
                                        <img src="{{ url('/images/app/qrcode.png') }}" alt="GOMAJI APP QRCode" width="140">
                                    </div>
                                </div>
                            </div>
                            <!--End:invite firend APP下載連結-->

                        </div>
                        <div class="col-md-6">
                            <img class="iphone" src="{{ url('/images/app/title_iphone.png') }}?1631006804" alt="GOMAJI APP">
                        </div>
                    </div>
                </div>
            </div>
            @if ($code == 'GOMAJI')
                <!--APP下載邀請碼GOMAJI-->
                <div class="awardBox">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 awardBox-area">
                                <img class="w-100 award" src="{{ url('/images/app/award.png') }}" alt="GOMAJI 首次下載">
                                <img class="w-100 m-award" src="{{ url('/images/app/m_award.png') }}" alt="GOMAJI 首次下載">
                                <div class="copy-gomaji">
                                    <span class="copy" id="copy" data-clipboard-target="#copy_value">點選複製</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End:APP下載邀請碼GOMAJI-->
            @else
                <!--invite firend APP下載邀請碼-->
                <div class="invite-awardBox">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 awardBox-area">
                                <img class="w-100 award" src="{{ url('/images/app/invite_award.png') }}" alt="GOMAJI 首次下載">
                                <img class="w-100 m-award" src="{{ url('/images/app/m_invite_award.png') }}" alt="GOMAJI 首次下載">
                                <div class="copy_value">
                                    <i>{{ $code }}</i>
                                </div>
                                <div class="copy-gomaji">
                                    <span class="copy" id="copy" data-clipboard-target="#copy_value">點選複製</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End:invite firend APP下載邀請碼-->
            @endif
            <div id="copy_value" style="opacity: 0">{{ $code }}</div>
            <div class="main-section">
                <div class="container" id="tabs">
                    <div class="row">
                        <div id="tabs-1">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title" src="{{ url('/images/app/section1.png') }}?1631068611" alt="推薦好友點數齊賺">
                                        <p>推薦成功，好友可獲點數回饋<br>好友消費成功，您也能獲得點數。</p>
                                        <a class="note" href="https://www.gomaji.com/help?faq=18.4#question-18-4" target="_blank">點我看注意事項</a>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section1_phone.png') }}" alt="GOMAJI 賺取點數">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title" src="{{ url('/images/app/section2.png') }}" alt="購物省錢分享賺錢">
                                        <p>分享商品連結推薦好友購買<br>核銷後即可獲2%點數回饋<br>評價後分享可再獲3%點數回饋。</p>
                                        <a class="note" href="https://www.gomaji.com/help?faq=18.4#question-18-4" target="_blank">點我看注意事項</a>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section2_phone.png') }}" alt="GOMAJI 商品頁面分享賺點">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section6.png') }}" alt="美容舒壓 即買即訂">
                                        <p class="s-l">APP 購買美容舒壓商品，<br>優惠及預約一次解決！<br>快速預訂、輕鬆體驗。</p>
                                        <a class="note" href="{{ url('/help?faq=5.7#question-5-7') }}" target="_blank">點我看注意事項</a>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section6_phone.png') }}" alt="美容舒壓 即買即訂">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section3.png') }}?1631068611" alt="麻吉咖啡館想贈點">
                                        <p class="s-l">九大連鎖通路，超過上萬家門市<br>隨時隨地，走到哪喝到哪！</p>
                                        <a class="note" data-fancybox data-src="#mjcafe" href="javascript:;">點我看注意事項</a>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section3_phone.png') }}" alt="GOMAJI 麻吉咖啡館">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section4.png') }}?1631068611" alt="專屬優惠超多回饋">
                                        <p>不定時APP專屬優惠折扣<br>與贈點活動，讓您花錢不心疼。</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section4_phone.png') }}?1631006804" alt="GOMAJI 回饋特展">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End:tabs-1-->
                        <div id="tabs-2">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_rs.png') }}?1631068611" alt="美食餐廳">
                                        <p>人氣餐廳、五星飯店、吃到飽<br>各式餐券，全台美食樣樣俱全。</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section_rs_phone.png') }}" alt="GOMAJI 美食餐廳">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_bu.png') }}?1631068611" alt="美容舒壓">
                                        <p>美髮、美甲美睫、按摩、舒壓SPA<br>瑜珈、健身課程、天天好氣色。</p>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section_bu_phone.png') }}" alt="GOMAJI 美容舒壓">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_tr.png') }}?1631068611" alt="旅遊住宿">
                                        <p>旅展搶購、星級飯店、商務飯店<br>民宿、摩鐵休息、泡湯應有盡有。</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section_tr_phone.png') }}" alt="GOMAJI 旅遊住宿">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title" src="{{ url('/images/app/section_sh.png') }}?1631068611" alt="宅配美食">
                                        <p>美食安心購，一指購足<br>所有生鮮美食，直送到家免出門。</p>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section_sh_phone.png') }}" alt="GOMAJI 宅配美食">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_re.png') }}?1631068611" alt="情侶休息">
                                        <p>搜尋您位置附近的泡湯/旅館，<br>休息現有空標示，前往不撲空。</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section_re_phone.png') }}" alt="GOMAJI 情侶休息">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_massage.png') }}?1631068611" alt="按摩">
                                        <p>網羅全台按摩名店，提供高質感體驗<br>，徹底釋放您體內的疲勞。</p>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section_ma_phone.png') }}" alt="GOMAJI 按摩">
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_li.png') }}" alt="休閒娛樂">
                                        <p>展演門票、農場體驗、<br>親子休閒、旅遊票券，應有盡有。</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="pic" src="{{ url('/images/app/section_li_phone.png') }}" alt="GOMAJI 休閒娛樂">
                                    </div>
                                </div>
                            </div>

                            <div class="section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="title title-service" src="{{ url('/images/app/section_takeout.png') }}?1631068611" alt="美食外帶">
                                        <p>飲食新主張，美味帶著走，<br>精選外帶美食餐券5折起。</p>
                                    </div>
                                    <div class="col-md-6 order-first">
                                        <img class="pic" src="{{ url('/images/app/section_takeout_phone.png') }}" alt="GOMAJI 美食外帶">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End:tabs-2-->
                    </div>
                </div>
            </div>
            <div class="download">
                <div class="container">
                    <div class="row  justify-content-center">
                        <div class="col-md-6">
                            <div class="app-icon">
                                <img src="{{ url('/images/app/app_icon.png') }}" alt="GOMAJI APP" width="110px">
                            </div>
                            <h3 class="text-center">現在立即下載 GOMAJI APP</h3>
                            <div class="app-download-area d-flex">
                                <div class="app-download-btn">
                                    <a href="https://itunes.apple.com/tw/app/id431218690?mt=8" target="_blank" rel="noopener">
                                        <img class="w-100" src="{{ url('/images/app/ios_bt.png') }}" alt="GOMAJI APP">
                                    </a>
                                </div>
                                <div class="app-download-btn">
                                    <a href="https://play.google.com/store/apps/details?id=com.wantoto.gomaji2&amp;referrer=utm_source%3Dofficial_site%26utm_medium%3Dapp_dl_page%26utm_campaign%3Dindex"
                                        target="_blank" rel="noopener">
                                        <img class="w-100" src="{{ url('/images/app/android_bt.png') }}" alt="GOMAJI APP">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End:主視覺-->
        <!--Footer-->
        <div class="footer relative">
            <div class="container">
                <div class="row">
                    <div class="logo">
                        <img src="{{ url('/images/app/logo_footer.png') }}" alt="GOMAJI夠麻吉" width="100">
                    </div>
                    <!--FB開始-->
                    <div class="fb-like-footer">
                        <div id="fb-root"></div>
                        <!--GOMAJI 夠麻吉 FB ID-->
                        <fb:like href="https://www.gomaji.com/app" send="true" layout="button_count" width="600" show_faces="true" font=""></fb:like>
                    </div>
                    <!--  FB結束 -->
                </div>
            </div>
        </div>
        <!--Footer-MM-->
        <div class="footer-mm">
            <div class="container">
                <div class="row">
                    <div class="logo">
                        <img src="{{ url('/images/app/logo_footer_m.png') }}" alt="GOMAJI夠麻吉" width="72">
                    </div>
                    <!--FB開始-->
                    <div class="fb-like">
                        <div class="fb-like" data-href="https://www.gomaji.com/app-download" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
                    </div>
                    <!--  FB結束 -->
                </div>
            </div>
        </div>
        <!--End:mm-footer-->

        <!--popup-麻吉咖啡館 -->
        <div style="display: none;max-width:600px;" id="mjcafe" class="popupBox">
            <h2>麻吉咖啡館贈點 注意事項</h2>
            <div class="main">
                <ul>
                <li>適用平台：GOMAJI 最新版 APP</li>
                <li>每日的時間區間為 00:00 ~ 23:59</li>
                <li>贈送點數計算方式為需扣除所折抵之點數後，實際刷卡支付之金額，並採小數第一位四捨五入方式計算，點數效期為 20 天。</li>
                <li>活動期間名額不限，每組 email 以及手機號碼每日限領取 1 次。</li>
                <li>參與本次活動需完成最新版 GOMAJI APP 手機認證，方可獲得點數，點數由系統自動匯入所認證之帳號下。</li>
                <li>參加本活動之同時，即同意接受本活動辦法說明之規範。</li>
                <li>本活動有不可抗力特殊原因無法執行時，主辦單位 GOMAJI 保留隨時修改、變更或終止本活動之權利，將不會事先通知。</li>
            </ul>
            </div>
        </div>
        <!--End:popup-麻吉咖啡館 -->
    </body>

    <!-- jQuery -->
    <script src="https://kit.fontawesome.com/923eda4210.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/bootstrap/4.4.1/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/owl.carousel.min.js?1624863302') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/clipboard.min.js') }}"></script>

    <script>
        $(window).bind("load", function () {
            $.getScript("{{ url('/js/social.js') }}", function () { });
            //在ios android 隱藏 footer
            //if (navigator.userAgent.match(/GOMAJI/)) {
            if (window.location.href.match("cmd=android") || window.location.href.match("cmd=iphone2")) {
                $('.footer').hide();
            }
        });
    </script>

    <script>
        // 手機發送成功
        // document.querySelector('.input-group button').onclick = function () {
        //     swal("發送成功", "", "success");
        // };
        // 複製成功
        document.querySelector('.copy-gomaji span').onclick = function () {
            swal("複製成功", "", "success");
        };

        // 剪貼簿功能
        new Clipboard('.copy');

        // .down 下滑至300後才出現
        $(function () {
            $(window).scroll(function () {
                var target = $(".down");
                var isVisible = target.is(":visible");
                if ($(window).scrollTop() >= 300) {
                    if (!isVisible) target.show();
                } else {
                    if (isVisible) target.hide();
                }
            });
            //scroll up
            $(".down").on('click', function (event) {
                $('html,body').animate({
                    scrollTop: '0'
                }, 1000);
            });
        });

        $('a[href*=#]:not([href=#notice])').click(function () {
            var target = $(this.hash);
            $('html,body').animate({
                scrollTop: target.offset().top - 20
            }, 1000);
            return false;
        });

    </script>

    <script>
        //頁籤
        $(function () {
            // 預設顯示第一個 Tab
            var _showTab = 0;
            var $defaultLi = $('ul.tabs li').eq(_showTab).addClass('active');
            $($defaultLi.find('a').attr('href')).siblings().hide();

            // 當 li 頁籤被點擊時...
            // 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
            $('ul.tabs li').click(function (event) {
                event.preventDefault(); // 關閉原本超連結效果
                var target = $('#tabs');
                $(this).addClass('active'); // 被點選的 li 加上 active class(被點選的樣式在 tab_bar ul li.active設定，未點選的樣式在 tab_bar ul li設定)
                $(this).siblings().removeClass('active'); // 移除其他同層 li 的 active class
                var clickTab = $(this).find('a').attr('href'); // 從被點選的li上獲取<a>標籤，並從<a>標籤上獲取 href 的值
                $(clickTab).fadeIn(); // 淡入被點選的內容
                $(clickTab).siblings().hide(); // 隱藏其他同層的內容
                $('html,body').animate({ // 滑動
                    scrollTop: target.offset().top - 50
                }, 1000);

            }).find('a').focus(function () {
                this.blur();
            });
        });

            // SMS
        $('.font_bt').click(function(e) {
            e.preventDefault();
            var mobile = $('input[name="mobile"]').val();
            if (validate_mobile_phone(mobile)) {
                send_sms(mobile);
            } else {
                swal('手機號碼格式錯誤 Σ(°Д°;', '', 'warning');
            }
        });

        function validate_mobile_phone(mobile_phone) {
            var regex = /^09[0-9]{8}$/;
            return regex.test(mobile_phone);
        }

        function send_sms(mobile_phone) {
            // YWA
            try {
                doDownload('PC');
            } catch (e) {}
            $.ajax({
                url: '/app/sendAppSms',
                async: false,
                type: 'post',
                data: {
                    'mobile_phone' : mobile_phone,
                    '_token' : '{{ csrf_token() }}' //Laravel內建csrf驗證
                },
                success: function(response) {
                    if (response) {
                        swal('發送成功！','','success');
                    } else {
                        swal('發送失敗 (╥﹏╥) ','伺服器忙碌中，請稍候再發送～感謝！','error');
                    }
                }
            });
        }
    </script>

</html>
