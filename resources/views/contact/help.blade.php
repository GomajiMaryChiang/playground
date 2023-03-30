@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">您好，需要什麼協助嗎？</h1>
                    <form class="help-search-form">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-item-1 nav-link active" id="nav-1" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home"
                                    aria-selected="true">訂單查詢（購物金、點數查詢）</a>
                                <a class="nav-item nav-item-2 nav-link" id="nav-2" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">發票歸戶</a>
                            </div>
                        </nav>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-1">
                                <div class="help-search-content">
                                    <input name="history-email" type="text"  maxlength="50" size="50" class="form-control w-50 d-inline-block" placeholder="請輸入您的E-mail" autocomplete="off">
                                    <select name="history-duration" class="form-control check-select w-30 ml-3 d-inline-block">
                                        <option value="0">請選擇欲查詢的日期</option>
                                        <option value="3">最近三個月的紀錄</option>
                                        <option value="6">最近六個月的紀錄</option>
                                        <option value="12">全部的紀錄</option>
                                    </select>
                                    <a id="history-query" href="javascript:void(0);" class="btn btn-main d-inline-block">查詢</a>
                                    <p class="t-09 t-gray ml-1 mt-1">提醒您！MAIL 查詢結果將寄至您的信箱，完整訂單管理功能建議下載 <a href="{{ url('/app') }}" target="_blank">GOMAJI APP</a> 。</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-2">
                                <div class="help-search-content">
                                    <input name="invoice-email" type="text" maxlength="50" size="50" class="form-control w-82 d-inline-block" placeholder="請輸入您的E-mail" autocomplete="off">
                                    <a id="invoice-query" data-src="#help-search-msg" href="javascript:void(0);" class="btn btn-main d-inline-block">查詢</a>
                                </div>
                            </div>
                        </div>
                        <div class="link">
                            <a href="#help-info-wrapper" class="t-white t-11 underline">客服信箱</a>
                            <a href="#help-info-wrapper" class="t-white t-11 ml-3 underline">店家合作</a>
                            <a href="#help-info-wrapper" class="t-white t-11 ml-3 underline">行銷公關</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($isShowLightHeader)
                        <nav aria-label="breadcrumb mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $chTitle }}</li>
                            </ol>
                        </nav>
                    @endif
                    <!-- End:breadcrumb -->
                    <div class="row no-gutters help-faq-wrapper">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="sticky-top">
                                <div id="faq" class="list-group faq">
                                    @if (!empty($faqLists))
                                        @foreach ($faqLists['item'] as $key => $value)
                                            <a class="list-group-item list-group-item-action" id="{{ $value['id'] }}" href="#faq-{{ $value['category_id'] }}">{{ $value['category_name'] }}</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy help-faq-content">
                                @if (!empty($noticeData))
                                    <div class="accordion">
                                        <div class="card">
                                            <div class="card-header" id="heading-notice">
                                                <h3>
                                                    <button class="btn" id="question-notice" type="button" data-toggle="collapse" data-target="#collapse-notice" aria-expanded="true" aria-controls="collapse-notice" style="color: red;">
                                                        ※ 客服中心春節時期公告
                                                    </button>
                                                </h3>
                                            </div>
                                            <div id="collapse-notice" class="collapse show" aria-labelledby="heading-notice">
                                                <div class="card-body">
                                                    親愛的麻吉您好：<br>
                                                    值此春節佳節將屆之際，GOMAJI僅此致上最誠摯的祝福，並向您說明{{ $noticeData['year'] ?? '' }}年春節期間客服人員服務時間調整如下：<br><br>
                                                    {{ $noticeData['period'] ?? '' }}客服電話將暫停服務，若您有任何服務需求，敬請來信反應，我們將儘速以E-mail方式回覆您；連假期間造成不便之處，敬請見諒。GOMAJI 客服信箱：<a href="{{ url('/help/contact') }}" target="_blank" style="color: #007bff;">https://www.gomaji.com/help/contact</a>，客服專線：(02)2711-1758 (09:00AM~18:00PM) 。<br><br>
                                                    新的一年，GOMAJI會努力持續提供良好的服務以及不打折的品質給您，謝謝您的支持與愛護。<br><br>
                                                    GOMAJI全體員工<br>
                                                    敬祝 新春愉快，萬事如意!!<br><br>
                                                    <img style="width: 100%;" src="{{ $noticeData['imgUrl'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($faqLists))
                                    @foreach ($faqLists['question'] as $key => $value)
                                        <h2 id="faq-{{ $value['id'] }}" class="t-main">{{ $value['category_name'] }}</h2>
                                        <div class="accordion" id="accordionExample">
                                            @foreach ($value['question_list'] as $subKey => $subValue)
                                                <div class="card">
                                                    <div class="card-header" id="heading{{ $subValue['id'] }}">
                                                        <h3>
                                                            <button class="btn" id="question-{{ $subValue['id'] }}" type="button" data-toggle="collapse" data-target="#collapse-{{ $subValue['id'] }}" aria-expanded="false" aria-controls="collapse-{{ $subValue['id'] }}">
                                                                {{ $subValue['question'] }}
                                                            </button>
                                                        </h3>
                                                    </div>
                                                    <div id="collapse-{{ $subValue['id'] }}" class="collapse" aria-labelledby="heading{{ $subValue['id'] }}">
                                                        <div class="card-body">
                                                            {!! $subValue['answer'] !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                                <!-- End:faq -->
                                <div id="help-info-wrapper" class="help-info-warpper">
                                    <div class="row no-gutters">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="help-info first">
                                                <p><i class="i-help-mail"></i></p>
                                                <p class="text-center"><a class="underline t-main t-14" href="{{ url('/help/contact/' . Config::get('contact.id.query')) . '?uinfo=' . $uinfo }}">客服信箱</a></p>
                                                <p class="text-center mb-1 t-main t-11">02-2711-1758</p>
                                                <p class="text-center">(週一至週五 9:00AM ~ 6:00PM)<br>建議 / 退費 / 疑問 / 合作<br><span class="t-09">我們為客戶隨時隨地解決任何問題。</span></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="help-info second">
                                                <p><i class="i-help-store"></i></p>
                                                <p class="text-center mb-3"><a class="underline t-main t-14" href="{{ url('/help/contact/' . Config::get('contact.id.cooperation')) }}">店家合作報名</a></p>
                                                <p class="text-center">想打響品牌，讓顧客大排長龍嗎？<br><span class="t-09">請立即線上報名。給您夠擠滿的客源！</span></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="help-info">
                                                <p><i class="i-help-mk"></i></p>
                                                <p class="text-center mb-3"><a class="underline t-main t-14" href="{{ url('/help/contact/' . Config::get('contact.id.media')) . '?uinfo=' . $uinfo }}">行銷合作與媒體公關</a></p>
                                                <p class="text-center">品牌行銷合作提案、媒體公關聯繫洽詢等事項。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
    <!-- Popup:help-search-msg -->
    <div style="display: none;" id="help-search-msg" class="popupBox w-30">
        <h2 data-selectable="true" class="t-main">感謝您</h2>
        <div class="epaperBox">
            <p>GOMAJI 已將查詢結果寄到您的指定信箱，請前往信箱查看；如未收到，請確認是否在垃圾郵件或促銷內容中，並點選回報為非垃圾郵件，謝謝！</p>
        </div>
    </div>-
    <!-- End:help-search-msg-->
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('js/assets/jquery.sticky.js') }}"></script>
    <script>
        $(document).ready(function () {
            var footer = $('.footer');
            var footerHeight = footer.outerHeight();
            $("#faq").sticky({
                topSpacing: 0,
                bottomSpacing: footerHeight,
            });
            // 滾動監控
            $('body').scrollspy({ target: '#faq' })

            // 處理標籤
            var faqItemId = {{ $faqItemId }};
            var faqSubItemId = {{ $faqSubItemId }};

            if (faqItemId > 0) {
                if (faqSubItemId > 0) {
                    let id = 'question-' + faqItemId + '-' + faqSubItemId;
                    location.hash = id; // #question-X-X寫至網址上
                    $('#' + id).trigger('click'); // 該標籤內容展開
                } else {
                    location.hash='faq-' + faqItemId;
                }
            }
        });
    </script>
    <script>
        $(function() {
            var historyIsClick = false;
            // 購買紀錄查
            $('#history-query').click(function() {
                if (historyIsClick === false) {

                    // 將按鈕反灰避免連點
                    historyIsClick = true;
                    disbleDoubleClick();

                    var email = $('#nav-home').find('input[name=history-email]').val();
                    var duration = $('#nav-home').find('select[name=history-duration]').val();

                    if (!validate_email(email)) {
                        alert('email 格式錯誤');
                        historyIsClick = false;
                        enableClick();
                        return;
                    } else if (duration == 0) {
                        alert('請選擇欲查詢的期間');
                        historyIsClick = false;
                        enableClick();
                        return;
                    } else {
                        $.get('/api/sendHistory', { email: email, duration: duration} ,function (json) {

                            if (json == '') {
                                historyIsClick = false;
                                enableClick();
                                alert('查詢失敗，請稍後再試');
                                return;
                            }

                            // 恢復按鈕狀態
                            historyIsClick = false;
                            enableClick();

                            let _result = $.parseJSON(json);

                            // 該信箱無購買紀錄
                            if (_result.return_code == '9998') {
                                // 將輸入值清回預設值，跳窗返回
                                $('#nav-home').find('input[name=history-email]').val('');
                                $('#nav-home').find('select[name=history-duration]').val('0');
                                alert(_result.description);
                                return;
                            }

                            // 其他錯誤
                            if (_result.return_code != '0000') {
                                // 將輸入值清回預設值，跳窗返回
                                $('#nav-home').find('input[name=history-email]').val('');
                                $('#nav-home').find('select[name=history-duration]').val('0');
                                alert('查詢有誤');
                                return;
                            } else {
                                // 查詢成功
                                // 將輸入值清回預設值，跳窗返回
                                $('#nav-home').find('input[name=history-email]').val('');
                                $('#nav-home').find('select[name=history-duration]').val('0');
                                $('#query-finish').trigger('click');
                                // 查詢成功彈跳視窗
                                $.fancybox.open({
                                    src: '#help-search-msg',
                                })
                                return;
                            }
                        });
                    }
                }
            });

            // 發票歸戶
            $('#invoice-query').click(function() {

                var email = $('#nav-profile').find('input[name="invoice-email"]').val();

                if (!validate_email(email)) {
                    alert('email 格式錯誤');
                } else {
                    $.get('/api/sendInvoice', { email: email }, function (json) {

                        let _result = $.parseJSON(json);

                        if (_result.return_code != '0000') {
                            $('#nav-profile').find('input[name=invoice-email]').val('');
                            alert(_result.description);
                            return;
                        } else {
                            // 查詢成功
                            // 將輸入值清回預設值，跳窗返回
                            $('#nav-profile').find('input[name=invoice-email]').val('');
                            $('#query-finish').trigger('click');
                            // 查詢成功彈跳視窗
                            $.fancybox.open({
                                src: '#help-search-msg',
                            })
                            return;
                        }
                    });
                }
            });

            //檢查 Email 格式
            function validate_email(email)
            {
                regex = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
                return regex.test(email);
            }

            function disbleDoubleClick() {
                $('#history-query').css({
                    'background': '#9E9E9E',
                    'cursor' : 'not-allowed',
                })
                $('#history-query').attr('disabled', 'true');
            }
            function enableClick() {
                $('#history-query').css({
                    'background': '#FF8800',
                    'cursor' : 'pointer',
                })
                $('#history-query').attr('disabled', 'false');
            }
        })
    </script>
@endsection
