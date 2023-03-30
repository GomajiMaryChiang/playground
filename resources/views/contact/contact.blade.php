@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">{{ $chTitle }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main main-contact">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($isShowLightHeader)
                    <!--使用APP瀏覽，Header不顯示，麵包屑也不顯示 -->
                        <nav aria-label="breadcrumb mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/help') }}">客服中心</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $chTitle }}</li>
                            </ol>
                        </nav>
                    @endif
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper border border-r">
                        <p><i class="i-help-mail"></i></p>
                        <h2 class="text-center">有合作提案或是任何建議都歡迎聯絡！</h2>
                        <p class="text-center sub-title t-11">感謝您對 GOMAJI 的支持，如有任何疑問或建議，請您不吝指教。<br>若您是店家欲洽談合作，請您留下聯絡資訊，謝謝！</p>
                        <form class="contactBox">
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">聯絡項目</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <select id="item" name="type" class="form-control check-select w-75">
                                        @foreach ($items as $key => $value)
                                            <option value="{{ $value['ticket_category_id'] }}" @if ($value['ticket_category_id'] == $id) selected @endif>
                                                {{ $value['ticket_category_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">頻道</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <select id="ch" name="ch" class="form-control check-select w-75" @if ($ch != '') disabled  @endif>
                                        @foreach ($channels as $key => $value)
                                            <option value="{{ $value['ticket_category_id'] }}" @if ($value['ticket_category_id'] == $ch) selected @endif>{{ $value['ticket_category_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- 店家合作 start -->
                            <div id="store-cooperation">
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <p>若您欲洽談與 GOMAJI 合作相關事宜，請填寫以下資訊，GOMAJI 相關部門將會進行評估，評估通過後將由專人與您進一步聯繫，謝謝！</p>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">店家名稱</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input id="store_name" name="store_name" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫店家名" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">店家官網 / 部落格</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input id="store_website" name="store_website" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫官網/部落格" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">活動 / 商品內容</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="product_name" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫您欲合作的活動 / 商品內容 (ex：西式套餐、行動電源)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">所在地 (縣市)</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <select name="store_location" class="form-control check-select w-35 mr-3">
                                                <option value="">請選擇縣市</option>
                                                @foreach ($cities as $key => $value)
                                                    <option value="{{ $value['city_id'] }}">{{ $value['city_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <select name="store_district" class="form-control check-select w-35">
                                                <option value="">請選擇行政區</option>
                                            </select>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <p class="t-11 pt-2 mr-2">郵遞區號</p>
                                            <input name="store_zip_code" type="text" maxlength="4" size="4" class="form-control zip-code" readonly="readonly">
                                        </div>
                                        <input name="store_address" type="text" maxlength="50" size="50" class="form-control" placeholder="請輸入您的地址" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">實體店面</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="physical_store" value="1">
                                            <label class="form-check-label" for="inlineRadio1">有</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="physical_store" value="0">
                                            <label class="form-check-label" for="inlineRadio2">無</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">公司類型</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="store_type" value="0">
                                            <label class="form-check-label" for="inlineRadio3">單店</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="store_type" value="1">
                                            <label class="form-check-label" for="inlineRadio4">連鎖</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">聯絡人</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="store_contact" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫您的姓名" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">聯絡電話</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="store_phone" type="text" maxlength="12" size="12" class="form-control" placeholder="請填寫電話" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">Email</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="email" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <p>店家需有營業登記證，方可洽談合作相關事宜。</p>
                                    </div>
                                </div>
                            </div>
                            <!-- 店家合作 end -->
                            <!-- 其他建議事項/問提申訴/退費問題/商品諮詢 start -->
                            <div id="other-business">
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="full_name_label required title">訂購人姓名</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="full_name" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫您的姓名" autocomplete="off" @if ($fullName != '') value="{{ $fullName }}"  @endif @if (empty($mutable)) readonly @endif>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="email_label required title">訂購人Email</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="email" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫Email" autocomplete="off" @if ($email != '') value="{{ $email }}"  @endif @if (empty($mutable)) readonly @endif>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="phone_label required title">訂購人電話</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="phone" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫您的電話" autocomplete="off" @if ($mobilePhone != '') value="{{ $mobilePhone }}"  @endif @if (empty($mutable)) readonly @endif>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="title">訂單編號</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="bill_no" type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫編號" autocomplete="off" @if ($billNo != '') value="{{ $billNo }}" readonly @endif>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="contact_content_label required title">我的問題是</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <textarea name="contact_content" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- 其他建議事項/問提申訴/退費問題/商品諮詢 end -->
                            <!-- 保證便宜通報 start -->
                            <div id="cheapest">
                                <div class="row no-gutters input-group contact-panel">｀
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">姓名</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫您的姓名" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">Email</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">電話</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫您的電話" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">他網販售網址</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫網址" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">GOMAJI 販售網址</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <input name="name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫網址" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">我的問題是</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <textarea class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- 保證便宜通報 end -->
                            <div class="row no-gutters input-group">
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="required title">驗證碼</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <div id="captchaImg">
                                            <img src="{{ captcha_src('flat') }}" alt="captcha">
                                            <input id="captchaReload" type="button" value="&#8634" style="border: none;"></input>
                                        </div>
                                        <input id="captcha" name="captcha" type="text" maxlength="50" size="50" class="form-control" placeholder="請輸入驗證碼" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <a id="submit-btn" class="btn btn-main m-auto w-75" role="button">
                                        確定送出
                                    </a>
                                    <p id="store-agree" class="text-center t-085 pt-1 t-darkgray">點擊“確定送出”即表示您已閱讀並同意 <a class="underline t-darkgray" data-fancybox="" data-src="#recruitment-popup" href="javascript:;" >店家招募個人資料告知條款</a><br>和同意提供以上資料供 GOMAJI 使用。</p>
                                    <p id="other-agree" class="text-center t-09 pt-1 t-darkgray">點擊“確定送出”即表示您已閱讀並同意，<a class="underline t-darkgray"  href="{{ url('/terms') }}" >服務條款</a> 和 <a class="underline t-darkgray" href="{{ url('/privacy') }}" >隱私權政策</a>，<br>
                                        和同意提供以上資料供 GOMAJI 使用。</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
    <!-- Popup:recruitment-popup -->
    <div style="display: none;" id="recruitment-popup" class="popupBox w-30">
        <h2 data-selectable="true" class="t-main">店家招募個人資料告知條款</h2>
        <div class="recruitmentBox">
            <h3 class="t-main font-weight-bold">夠麻吉股份有限公司(含一起旅行社股份有限公司、台灣一起夢想公益協會)（以下簡稱本公司）</h3>
            <p class="font-weight-bold mt-2">蒐集個人資料目的： </p>
            <p>本公司基於○六九 契約、類似契約或其他法律關係事務等合理關連之特定目的範圍內，向台端蒐集個人資料（例如:GOMAJI精選店家銷售合作、公益合作）。 </p>
            <p class="font-weight-bold mt-1">蒐集個人資料類別：</p>
            <p>本公司將蒐集台端之Ｃ○○一 辨識個人者（姓名、行動電話、電子郵遞地址）。</p>
            <p class="font-weight-bold mt-1">蒐集個人資料之期間、地區、對象及方式：</p>
            <p>期間及地區：本公司將保留台端的個人資料至特定目的存續期間屆止後銷毀，並會於中華民國境內使用台端的個人資料。 </p>
            <p>對象及方式：本公司將會把台端的個人資料基於合作磋商之目的提供予本公司相關單位及作為與聯絡窗口聯繫之用。</p>
            <p class="font-weight-bold mt-1">台端得依據個資法第三條規定行使以下權利：</p>
            <p>查詢、請求閱覽個人資料；請求製給個人資料複製本；請求補充、更正個人資料；請求停止蒐集、處理或利用個人資料；請求刪除個人資料。 </p>
            <p>台端若欲行使如上權利，請於本公司上班時間由專人為台端辦理（聯絡方式：(02)2711-1758）。</p>
            <p class="font-weight-bold mt-1">台端得自由選擇填具個人資料，惟若其提供之資料不足或有誤時，本公司將無法核准申辦或提供完整服務。</p>
        </div>
    </div>
    <!-- End:recruitment-popup-->
    <!-- refund-popup -->
    <div style="display: none;" id="refund-popup" class="popupBox w-30">
        <h2 data-selectable="true" class="t-main">退費問題</h2>
        <div class="recruitmentBox">
            <p>GOMAJI 為配合信託履約保證的實施，請欲辦理退費者至「客服中心 / 查詢消費紀錄」填入您的訂購信箱，系統將發送一封購買紀錄給您，請您點選「申請退費」並依步驟提出申請即可。</p>
            <p class="mt-2"><span class="t-red mr-2">※</span>如退費的訂單已跨月且並非全額退費，系統將傳送折讓單至您的訂購信箱，請務必將折讓單簽名或蓋章後回傳，方可辦理退費。</p>
        </div>
    </div>
    <!-- End:refund-popup -->
@endsection

@section('script')
    <script src="https://www.google.com/recaptcha/api.js?render={{ Config::get('contact.recaptcha_site_key') }}"></script>

    <script>
        $(function() {
            let isSubmit = false;
            // 第一次進入頁面
            let item = $("#item").val();
            controlData(item);

            // 變更聯絡項目主題
            $('#item').on('change', function() {
                var type = $('#item').val();
                controlData(type);
            });

            $('#captchaReload').on('click', function() {
                captchaReload();
            })

            // 變更驗證碼圖片
            function captchaReload() {
                $('input[name="captcha"]').val(''); // 清空驗證碼input欄位
                $.get('/captchaReload', function(response) {
                    $('#captchaImg').find('img').attr('src', response);
                })
            }

            function controlData(type) {
                let ch = $('#ch').val();

                $('#store-cooperation').hide(); // 店家合作欄位區塊
                $('#other-business').hide();    // 其他事項欄位區怪
                $('#cheapest').hide();          // 最便宜通報區塊
                $('#store-agree').hide();       // 店家合作同意說明
                $('#other-agree').hide();       // 其他事項同意說明

                switch(type) {
                    case '{{ Config::get('contact.id.cooperation') }}':
                        // 當聯絡項目 == 店家合作 只顯示「美食餐廳」,「美容紓壓」,「旅遊住宿」,「休閒娛樂」,「宅配美食」
                        $('select[id=ch] option[value="16"]').hide();
                        $('select[id=ch] option[value="18"]').hide();
                        $('select[id=ch] option[value="19"]').hide();
                        $('select[id=ch] option[value="20"]').hide();

                        // 宅配美食選項擺到最後
                        $('select[id=ch] option[value="4"]').hide();
                        let ch4Val = $('select[id=ch] option[value="4"]').val();
                        let ch4Text = $('select[id=ch] option[value="4"]').text();
                        $('select[id=ch]').append(`<option value="${ch4Val}">${ch4Text}</option>`);

                        $('#store-cooperation').show();
                        $('#store-apply').show();
                        $('#store-agree').show();

                        // 如果切換聯絡項目且頻道停留在店家合作不可選的頻道時，換到餐廳頻道
                        if (ch == '19' || ch == '20') {
                            $('select[id="ch"]').val('1');
                        }
                        break;
                    default:
                        if (type != {{ Config::get('contact.id.media') }}) {
                            // 如果是「退費問題」，需先有一個彈跳視窗出來
                            if (type == {{ Config::get('contact.id.refund') }}) {
                                $.fancybox.open({
                                    src: '#refund-popup',
                                });
                            }

                            // 如果有點選過「店家合作」，要把最後一個宅配美食頻道選項移除
                            if ($('select[id=ch]').find('option:last').val() == 4) {
                                $('select[id=ch]').find('option:last').remove();
                            }

                            $('select[id=ch] option[value="4"]').show();  // 宅配美食
                            $('select[id=ch] option[value="16"]').hide(); // 日本旅宿
                            $('select[id=ch] option[value="18"]').show(); // 線上訂房
                            $('select[id=ch] option[value="19"]').show(); // 麻吉咖啡館
                            $('select[id=ch] option[value="20"]').show(); // 宅配購物＋

                            $('#ch').parent().parent().show();
                            $('input[name=bill_no]').parent().parent().show();
                            $('.full_name_label').text('訂購人姓名');
                            $('.email_label').text('訂購人Email');
                            $('.phone_label').text('訂購人電話');
                            $('.contact_content_label').text('我的問題是');
                        } else {
                            $('#ch').parent().parent().hide();
                            $('input[name=bill_no]').parent().parent().hide();
                            $('.full_name_label').text('您的姓名');
                            $('.email_label').text('您的Email');
                            $('.phone_label').text('您的電話');
                            $('.contact_content_label').text('詳細說明');
                        }

                        $('#other-business').show();
                        $('#other-agree').show();
                        break;
                }
            }

            // 選擇城市之後，塞入市鎮區
            $('select[name="store_location"]').on('change', function() {
                $('input[name="store_zip_code"]').val(""); // 郵遞區號欄位清空
                $('select[name="store_district"]').empty();
                $('select[name="store_district"]').append("<option value=''>請選擇</option>");
                var val = $(this).val();
                @foreach ($cityData as $key => $value)
                    if (val ==  <?= $value['id'] ?>  ) {
                        @foreach ($value['sub_categories'] as $subKey => $subValue)
                            $('select[name="store_district"]').append("<option value='{{ $subValue['zip_code'] }}'>{{ $subValue['name'] }}</option>");
                        @endforeach
                }
                @endforeach
            });

            // 選擇市鎮區之後，自動填入郵遞區號
            $('select[name="store_district"]').on('change', function() {
                $('input[name="store_zip_code"]').val($(this).val());
            })

            // 點擊提交按鈕
            $("#submit-btn").on('click', function() {
                if (isSubmit) return;
                var type = $('#item').val();
                var subject = $("#ch").val();
                var error_message = [];

                if (!subject) {
                    error_message.push('‧ 請選擇頻道');
                }

                if ('{{ Config::get('contact.id.cooperation') }}' == type) {
                    // 如果是「店家合作」
                    var target = $("#store-cooperation");
                    var store_name = $(target).find('input[name="store_name"]').val();
                    var store_website = $(target).find('input[name="store_website"]').val();
                    var product_name = $(target).find('input[name="product_name"]').val();
                    var store_location = $(target).find('select[name="store_location"]').val();
                    var store_district = $(target).find('select[name="store_district"]').val();
                    var store_zip_code = $(target).find('input[name="store_zip_code"]').val();
                    var store_address = $(target).find('input[name="store_address"]').val();
                    var physical_store = $(target).find('input[name="physical_store"]').val();
                    var store_type = $(target).find('input[name="store_type"]').val();
                    var store_contact = $(target).find('input[name="store_contact"]').val();
                    var store_phone = $(target).find('input[name="store_phone"]').val();
                    var email = $(target).find('input[name="email"]').val();

                    if(!email) error_message.push('‧ Email不得為空白');
                    else if (!validate_email(email)) error_message.push('‧ Email格式錯誤');
                    if (!store_name) error_message.push('‧ 店家名稱不得為空白');
                    if (!product_name) error_message.push('‧ 活動/商品內容不得為空白');
                    if (!store_location) error_message.push('‧ 所在地不得為空白');
                    if (!store_district) error_message.push('‧ 地區不得為空白');
                    if (!store_zip_code) error_message.push('‧ 郵遞區號不得為空白');
                    if (!store_address) error_message.push('‧ 地址不得為空白');
                    if (!store_contact) error_message.push('‧ 聯絡人不得為空白');
                    if (!store_phone) error_message.push('‧ 聯絡電話不得為空白');
                    else if (store_phone.length < 9) error_message.push('‧ 聯絡電話格式錯誤');
                    if (!physical_store) error_message.push('‧ 請選擇有無實體店面');
                    if (!store_type) error_message.push('‧ 請選擇公司類型');
                } else {
                    var isMedia = (type == {{ Config::get('contact.id.media') }}) ? true : false;
                    var target = $("#other-business");
                    var full_name = $(target).find('input[name="full_name"]').val();
                    var email = $(target).find('input[name="email"]').val();
                    var phone = $(target).find('input[name="phone"]').val();
                    var bill_no = $(target).find('input[name="bill_no"]').val();
                    var contact_content = $(target).find('textarea[name="contact_content"]').val();

                    let emailEmpty = !isMedia ? '訂購人 email 不得為空白' : '您的 email 不得為空白';
                    let emailWrong = !isMedia ? '訂購人 email 格式錯誤' : '您的 email 格式錯誤';
                    let phoneEmpty = !isMedia ? '訂購人電話不得為空白' : '您的電話不得為空白';
                    let phoneWrong = !isMedia ? '訂購人電話格式錯誤' : '您的電話格式錯誤';
                    if (!full_name) error_message.push('‧ 姓名不得為空白');
                    if (!email) error_message.push(`‧ ${emailEmpty}`);
                    else if (!validate_email(email)) error_message.push(`‧ ${emailWrong}`);
                    if(!phone) error_message.push(`‧ ${phoneEmpty}`);
                    else if (!validate_mobile_phone(phone)) error_message.push(`‧ ${phoneWrong}`);
                    if (!contact_content) error_message.push('‧ 請輸入您的疑問或建議');
                }
                var captcha = $('input[name="captcha"]').val();
                if (!captcha) error_message.push('‧ 驗證碼尚未輸入');

                if (error_message.length > 0) {
                    // 填表內容有缺少或格式錯誤
                    swal({
                        title: '欄位尚未填妥',
                        text:
                            '<p class="lead text-muted" style="display: block;">' +
                            error_message.join("<br>") +
                            '</p>'
                        ,
                        html: true,
                        icon: 'warning',
                        confirmButtonText: 'ok',
                    });
                } else {
                    // 填表內容正確並送出表單
                    isSubmit = true; // 表單送出狀態
                    if (type == '{{ Config::get('contact.id.cooperation') }}') {
                        var json = `type=${type}&subject=${subject}&store_name=${store_name}&store_website=${store_website}&product_name=${product_name}&store_location=${store_location}&store_district=${store_district}&store_zip_code=${store_zip_code}&store_address=${store_address}&physical_store=${physical_store}&store_type=${store_type}&store_contact=${store_contact}&store_phone=${store_phone}&email=${email}`
                    } else if (type == '{{ Config::get('contact.id.media') }}') {
                        var json = `type=${type}&full_name=${full_name}&email=${email}&phone=${phone}&contact_content=${contact_content}`
                    } else {
                        var json = `type=${type}&subject=${subject}&full_name=${full_name}&email=${email}&phone=${phone}&bill_no=${bill_no}&contact_content=${contact_content}`
                    }

                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ Config::get('contact.recaptcha_site_key') }}', {action: 'submit'}).then(function(token) {
                            if (!token) {
                                swal({
                                    title: '身份檢驗錯誤！',
                                    text: '請稍後再重新嘗試',
                                    icon: 'warning',
                                    confirmButtonText: 'ok',
                                    onClose: $('#captcha').focus(),
                                });
                            }
                            json = `${json}&token=${token}`
                            $.ajax({
                                url: '/sendContact',
                                type: 'post',
                                data: {
                                    'captcha' : captcha,
                                    'json' : json,
                                    '_token' : '{{ csrf_token() }}' //Laravel內建csrf驗證
                                },
                                success: function(return_code) {
                                    if (return_code == '0000') {
                                        let successTitle = '親愛的麻吉您好';
                                        let successText = '系統已同步寄送通知信，內附專屬連結，您可隨時查看與客服人員的互動記錄。客服人員將於收到您的來信後，於上班時間依序回覆，謝謝。';

                                        // 店家合作的成功跳窗文字不同
                                        if (type == '{{ Config::get("contact.id.cooperation") }}') {
                                            successTitle = '親愛的店家您好';
                                            successText = '感謝您的報名，後續將由相關部門進行評選，若貴店家通過評選將由專人與您聯繫洽談，謝謝。';
                                        }

                                        // 行銷合作與媒體公關的成功彈出訊息
                                        if (type == '{{ Config::get("contact.id.media") }}') {
                                            successTitle = '親愛的麻吉您好';
                                            successText = '感謝您的來信，我們會盡快與您聯繫，謝謝。';
                                        }

                                        swal({
                                            title: successTitle,
                                            text: successText,
                                            icon: 'success',
                                            confirmButtonText: 'ok',
                                        }, function() {
                                            $('input:not([type="radio"], [type="button"], [readonly]), textarea').val('');
                                            if (type == 11) {
                                                // 如果是「店家合作」，也要將縣市地區清掉以及 radio check 都不要打勾
                                                $('select[name="store_location"], select[name="store_district"]').find('option').eq(0).prop('selected', true);
                                                $('select[name="store_district"]').find('option:not(:eq(0))').remove();
                                                $('input[type="radio"]').prop('checked', false);
                                            }
                                        });
                                    } else if (return_code == 'Incorrect') {
                                        // 驗證碼錯誤
                                        swal({
                                            title: '驗證碼錯誤',
                                            text: '請重新輸入驗證碼',
                                            icon: 'warning',
                                            confirmButtonText: 'ok',
                                            onClose: $('#captcha').focus(),
                                        });
                                    } else if (return_code == 'robot') {
                                        // 檢驗似乎是機器人
                                        swal({
                                            title: '身份檢驗錯誤',
                                            text: '請稍後再重新嘗試',
                                            icon: 'warning',
                                            confirmButtonText: 'ok',
                                            onClose: $('#captcha').focus(),
                                        });
                                    } else {
                                        swal({
                                            title: '系統忙綠中',
                                            text: '請改用電話與夠麻吉聯繫',
                                            icon: 'warning',
                                            confirmButtonText: 'ok',
                                        });
                                    }
                                    captchaReload();
                                    isSubmit = false;
                                }
                            });
                        });
                    });
                }
            })


            //檢查 Email 格式
            function validate_email(email)
            {
                regex = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
                return regex.test(email);
            }

            // 檢查url
            function validate_url(url) {
                regex = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                return regex.test(url);
            }

            // 檢查手機號碼
            function validate_mobile_phone(mobile_phone) {
                regex = /^09[0-9]{8}$/;
                return regex.test(mobile_phone);
            }
        });
    </script>
@endsection
