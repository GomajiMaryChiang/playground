<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/help') }}" target="_blank">客服</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/app') }}" target="_blank">下載APP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/kol') }}" target="_blank">網紅推薦</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.gomaji.com/blog" target="_blank">吃喝玩樂情報</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.104.com.tw/company/bjv2ebc?jobsource=checkc" target="_blank" rel="noopener">人才招募</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}" target="_blank">關於 GOMAJI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/terms') }}" target="_blank">服務條款</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/privacy') }}" target="_blank">隱私權政策</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/stakeholder') }}" target="_blank">投資人管理專區</a>
                    </li>
                </ul>
                <!-- mm footer 出現-->
                <div class="mm-companyInfoBox">
                    <div class="gomaji-social d-flex justify-content-center">
                        <a href="https://www.facebook.com/YICHIGOMAJI/" title="FACEBOOK粉絲頁" target="_blank" rel="noopener">
                            <i class="social-icon i-facebook"></i>
                        </a>
                        <a href="https://line.me/R/ti/p/@gomaji" title="Line" target="_blank" rel="noopener">
                            <i class="social-icon i-line"></i>
                        </a>
                        <a href="https://www.instagram.com/gomaji.tw/?hl=zh-tw" title="Instagram" target="_blank" rel="noopener">
                            <i class="social-icon i-IG"></i>
                        </a>
                    </div>
                    <div class="companyInfo">
                        <p class="t-gray t-08">夠麻吉股份有限公司 統編：25145643<br>
                            一起旅行社股份有限公司 統編：53334842 (甲種旅行業註冊編號：727500、執照編號：甲06403、品保會員編號：北1846)<br>
                            代表人：吳進昌 (聯絡人)<br>
                            地址：106台北市大安區市民大道四段100號4樓<br>
                            客服電話：(02)2711-1758<br>(週一至週五 9:00AM ~ 6:00PM)<br>公司電話：(02)2711-8177<br>傳真電話：(02)2711-1757<br>
                            客服信箱：<a href="{{ url('/help/contact/6') }}">聯絡我們</a>、<a href="mailto:support@gomaji.com">support@gomaji.com</a></p>
                        <p class="copyright t-08 t-gray mt-3">版權所有 Copyright © 2010-{{ $currentYear }} <br>GOMAJI All Rights Reserved.</p>
                        <p class="copyright t-08 t-gray">防詐騙提醒：不肖人士可能假冒 GOMAJI 、飯店餐廳或銀行，常以 +886 開頭偽造電話謊稱取消重複訂單等各種理由，要求 ATM、網銀等金融操作皆為詐騙，請直接掛斷！</p>
                    </div>
                </div>
                <!-- End:mm footer 出現-->
                <div class="companyInfoBox">
                    <div class="companyInfo d-flex bd-highlight">
                        <div class="companyInfo-text bd-highlight">
                            <p class="t-gray t-085">夠麻吉股份有限公司 統編：25145643<br>
                                一起旅行社股份有限公司 統編：53334842 (甲種旅行業註冊編號：727500、執照編號：甲06403、品保會員編號：北1846)<br>
                                代表人：吳進昌 (聯絡人)<br>
                                地址：106台北市大安區市民大道四段100號4樓<br>
                                客服電話：(02)2711-1758 (週一至週五 9:00AM ~ 6:00PM)<br>公司電話：(02)2711-8177<br>傳真電話：(02)2711-1757<br>
                                客服信箱：<a href="{{ url('/help/contact/6') }}">聯絡我們</a>、<a href="mailto:support@gomaji.com">support@gomaji.com</a></p>
                        </div>
                        <div class="gomaji-social d-flex align-self-center ml-auto">
                            <a href="https://www.facebook.com/YICHIGOMAJI/" title="FACEBOOK粉絲頁" target="_blank" rel="noopener">
                                <i class="social-icon i-facebook"></i>
                            </a>
                            <a href="https://line.me/R/ti/p/@gomaji" title="Line" target="_blank" rel="noopener">
                                <i class="social-icon i-line"></i>
                            </a>
                            <a href="https://www.instagram.com/gomaji.tw/?hl=zh-tw" title="Instagram" target="_blank" rel="noopener">
                                <i class="social-icon i-IG"></i>
                            </a>
                            <a data-fancybox data-src="#epaper" href="javascript:;" title="電子報">
                                <i class="social-icon i-mail-send"></i>
                            </a>
                        </div>
                    </div>
                    <p class="copyright t-085 t-gray mt-3">版權所有 Copyright © 2010-{{ $currentYear }} GOMAJI All Rights Reserved.</p>
                    <p class="copyright t-085 t-gray">防詐騙提醒：不肖人士可能假冒 GOMAJI 、飯店餐廳或銀行，常以 +886 開頭偽造電話謊稱取消重複訂單等各種理由，要求 ATM、網銀等金融操作皆為詐騙，請直接掛斷！</p>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="autoLogout" value="{{ $autoLogout ?? '' }}">
    <input type="hidden" id="searchKeywords" value="{{ $searchKeywords ?? '' }}">
    <input type="hidden" id="gcCity" value="{{ $gcCity ?? 0 }}">
    <input type="hidden" id="gmcSitePay" value="{{ $gmcSitePay ?? '' }}">
</footer>
<!-- End:pc-footer -->
