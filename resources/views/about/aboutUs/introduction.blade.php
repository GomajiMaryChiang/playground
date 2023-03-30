@extends('modules.common')

@section('content')
    <main class="main">
        <div class="about-banner">
            <div class="container-fluid">
                <div class="row">
                    <img class="img-fluid" src="{{ url('/images/about/about.jpg') }}" alt="關於我們">
                </div>
            </div>
        </div>
        <!-- End:我們的banner -->
        <div class="mm-about-banner">
            <div class="container-fluid">
                <div class="row">
                    <img class="w-100" src="{{ url('/images/about/about-mm.jpg') }}" alt="關於我們">
                </div>
            </div>
        </div>
        <!-- End:mm-about-banner -->
        <div class="about-menubar sticky" data-toggle="sticky-onscroll">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-12">
                        <div class="menubar">
                            <ul class="nav">
                                <li class="nav-item active"><a class="nav-link" href="{{ url('/about') }}">關於我們</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/about/event') }}">公司記事</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/about/newsroom') }}">媒體報導</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-2 t-main">關於 GOMAJI</h2>
                        <h2 class="text-center mb-3">最大吃喝玩樂平台</h2>
                        <h3 class="text-center">做最大 發揮正向影響力 幫助更多的人</h3>
                        <p class="text-center t-12 mt-4 mb-4">全台最大吃喝玩樂平台GOMAJI以活化閒置資源、協助店家賺錢、提供消費者省錢且美好體驗為成立初衷。</p>
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <p>企業驅動核心為強而有力的執行團隊，秉持熱情卓越、信任分享、正向影響力的企業文化，締造超過30億的年交易額成為團購龍頭，並於2016.01.11上櫃(8472)，為台灣上櫃公司電子商務類別6家中唯一O2O類型的企業。</p>
                            </div>
                            <div class="col-md-5">
                                <p>面對網路產業的瞬息萬變，GOMAJI 不斷面對挑戰積極發展更全面的 O2O 模式，將努力帶給消費者更豐富、更便利、更優惠的生活消費體驗。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center sub-title mb-3">我們的使命</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="features-item-icon features-item-1 text-center">
                            <img src="{{ url('/images/about/features-item-1.png') }}" alt="活化閒置資源">
                        </div>
                        <h4 class="text-center t-15">活化閒置資源</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="features-item-icon features-item-1 text-center">
                            <img src="{{ url('/images/about/features-item-2.png') }}" alt="幫助店家賺錢">
                        </div>
                        <h4 class="text-center t-15">幫助店家賺錢</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="features-item-icon features-item-1 text-center">
                            <img src="{{ url('/images/about/features-item-3.png') }}" alt="買划算好體驗">
                        </div>
                        <h4 class="text-center t-15">買划算好體驗</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="mb-4 sub-title">創立動機</h3>
                        <p class="mb-4">「做最大、累積正向影響力、幫助更多人」。人不知道從哪裏來，也不知死後去哪? 死了真就這樣消失了嗎? 無知讓人害怕死亡，那活著的意義與價值是什麼?
                        </p>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p>傳道書3章11節-- 「神造萬物，各按其時成為美好，又將永生安置在世人心中。然而神自始自終的作為， 人不能參透。我知道世人，莫強如終身喜樂行善；並且人人吃喝，在他一切勞祿中享福，這也是神的恩賜。」</p>
                            </div>
                            <div class="col-md-6">
                                <p>GOMAJI 團隊堅持發揮自己的才能及熱情創業，不怕吃苦用喜樂的意志服務一年1,000 家店家 及100萬的消費者開始，做到最大累積影響力，如此幫助的力量才可以長久且巨大。</p>
                            </div>
                        </div>
                        <p class="mb-2 font-weight-lighter font-italic">Alin 2010.06.01</p>
                    </div>
                    <div class="col-md-5">
                        <img class="img-fluid" src="{{ url('/images/about/about-img-1.jpg') }}" alt="創立動機">
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section about-imgBox bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-2.jpg') }}" alt="GOMAJI大會">
                            </div>
                            <div class="col-md-6">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-3.jpg') }}" alt="GOMAJI運動大會">
                            </div>
                            <div class="col-md-12 mt-4">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-5.jpg') }}" alt="GOMAJI">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-4.jpg') }}" alt="GOMAJI運動大會">
                            </div>
                            <div class="col-md-6">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-6.jpg') }}" alt="GOMAJI運動大會">
                            </div>
                            <div class="col-md-6">
                                <img class="img-fluid" src="{{ url('/images/about/about-img-7.jpg') }}" alt="GOMAJI白色尾牙">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <img class="img-fluid" src="{{ url('/images/about/about-img-8.jpg') }}" alt="GOMAJI">
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section company-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="t-white mb-2">企業資訊</h3>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="t-white">夠麻吉股份有限公司 統編：25145643 負責人：吳進昌</p>
                                <p class="t-white">一起旅行社股份有限公司 統編：53334842 負責人：吳進昌</p>
                                <p class="t-white">(交觀字號:交觀甲7275號 執照號碼: 甲01335 甲種旅行社 品保北1846號)</p>
                            </div>
                            <div class="col-md-6">
                                <p class="t-white">地址：106台北市大安區市民大道四段100號4樓</p>
                                <p class="t-white">客服電話：(02)2711-1758 (週一至週五 9:00AM ~ 6:00PM)</p>
                                <p class="t-white">客服信箱：<a class="t-white underline" href="{{ url('/help/contact/6') }}">聯絡我們</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection
