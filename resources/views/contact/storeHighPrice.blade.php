@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">價高通報</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main main-contact">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">價高通報</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper border border-r">
                        <p><i class="i-help-mail"></i></p>
                        <form id="contact-form" class="contactBox store-violations">
                            <input type="hidden" id="product_id" name="product_id" value="{{ $store['product']['product_id'] }}">
                            <input type="hidden" id="sp_flag" name="sp_flag" value="{{ $store['product']['sp_flag'] }}">
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="title">店家名稱</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <h3 class="store-name">{{ $store['product']['store_name_alias'] }}</h3>
                                </div>
                            </div>
                            @if ($store['product']['sp_flag'] == 0)
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="title">方案</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <h3 class="store-name">{{ $store['product']['product_name'] }}</h3>
                                        <input type="hidden" id="sp_id" name="sp_id" value="0">
                                    </div>
                                </div>
                            @else
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-3 col-sm-12 col-12">
                                        <label class="title">子方案</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-12">
                                        <select id="sp_id" name="sp_id" class="form-control">
                                            @foreach ($store['sub_products'] as $sp)
                                                <option value="{{ $sp['sp_id'] }}">
                                                    {{ $sp['sp_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">比價網網址</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="web_url" name="web_url" type="text" maxlength="255" size="4" class="form-control" placeholder="請輸入含https://之比價網完整網址" autocomplete="off">
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">比價網站價錢</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="price" name="price" type="text" maxlength="7" size="4" class="form-control input-price" placeholder="請填寫價錢" autocomplete="off">元
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">比較條件</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <textarea class="form-control" id="contact_content" name="contact_content" maxlength="100" rows="5"></textarea>
                                    <p class="t-gray">訂房時會因入住日/人數/加人加價/網站促銷…等因素而價格不同，請提供您當時的比價細項條件以供參考，謝謝!</p>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">通報人姓名</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="full_name" name="full_name" type="text" maxlength="45" size="4" class="form-control" placeholder="請填寫姓名" autocomplete="off">
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">通報人E-mail</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="email" name="email" type="text" maxlength="45" size="4" class="form-control" placeholder="請填寫E-mail" autocomplete="off">
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">通報人手機</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="mobile_phone" name="mobile_phone" type="text" maxlength="10" size="4" class="form-control" placeholder="請填寫手機(此為贈點依據)，例：09XXXXXXXX" autocomplete="off">
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <a class="btn btn-main m-auto w-75 subm-contact" href="javascript:void(0);" role="button">
                                        確定送出
                                    </a>
                                    <p class="text-center t-085 pt-1 t-darkgray">點擊“確定送出”即表示您已閱讀並同意，<a class="underline t-darkgray"  href="{{ url('/terms') }}" >服務條款</a> 和 <a class="underline t-darkgray" href="{{ url('/privacy') }}" >隱私權政策</a>，
                                        和活動之規範。</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script>

        $(function () {

            // 送出表單檢查
            $('#contact-form').data('submitting', false).submit(function() {
                var form = $(this);

                if (form.data('submitting')) {
                    return false;
                }
                form.data('submitting', true);

                var error_msg = [];
                var data = {
                    'subject': '商品價高通報',
                    'product_id': $('#product_id').val(),
                    'sp_flag': $('#sp_flag').val(),
                    'web_url': encodeURIComponent($('#web_url').val()),
                    'price': encodeURIComponent($('#price').val()),
                    'contact_content': $('#contact_content').val(),
                    'full_name': encodeURIComponent($('#full_name').val()),
                    'email': $('#email').val(),
                    'mobile_phone': $('#mobile_phone').val()
                }

                if (0 != data.sp_flag) {
                    data.sp_id = $(this).find('select[name=sp_id] option:selected').val();
                } else {
                    data.sp_id = $('#sp_id').val();
                }

                if (! data.product_id) {
                    error_msg.push('‧ 商品資料異常，請重新整理');
                } else if (1 == data.sp_flag && 0 == data.sp_id) {
                    error_msg.push('‧ 請選擇子方案');
                } else if ('' == data.web_url) {
                    error_msg.push('‧ 請填寫比價網網址');
                } else if ('' == data.price) {
                    error_msg.push('‧ 請填寫比價網站價錢');
                } else if (0 == data.price) {
                    error_msg.push('‧ 比價網站價錢須大於0');
                } else if ('' == data.contact_content) {
                    error_msg.push('‧ 請填寫比價條件');
                } else if ('' == data.full_name) {
                    error_msg.push('‧ 請填寫通報人姓名');
                } else if ('' == data.email) {
                    error_msg.push('‧ 請填寫通報人EMAIL');
                } else if (! validate_email(data.email)) {
                    error_msg.push('‧ 通報人EMAIL格式錯誤');
                } else if ('' == data.mobile_phone) {
                    error_msg.push('‧ 請填寫通報人手機');
                } else if ( ! validate_mobile_phone(data.mobile_phone)) {
                    error_msg.push('‧ 通報人手機格式錯誤');
                } else if ('' == data.contact_content) {
                    error_msg.push('‧ 請填寫洗單描述');
                }

                if (error_msg.length > 0) {
                    alert(error_msg.join("\n"));
                    form.data('submitting', false);
                    // parent.$.fancybox.close();
                } else {
                    
                    $.post('/api/storeHighPrice', { data: JSON.stringify(data) }, function (data) {
                        if ('0000' == data.return_code) {
                            console.log(data);console.log(typeof(data))
                            $.fancybox.open('<div class="popupBox popupBox-400">\n' +
                                '    <h2 data-selectable="true" class="t-11 mb-2"><span class="t-song">感謝您</h2>\n' +
                                '    <p data-selectable="true" class="text-center" id="send-message">\n' +
                                '    針對您提出的比價問題，GOMAJI 稽核小組已收到您的通報，非常感謝您的回應！</p>\n' +
                                '</div>');
                        } else {
                            alert(data.description);
                        }
                        form.data('submitting', false);
                    });
                }
                return false;
            });

            $.extend($.fancybox.defaults, {
                afterClose: function(){
                    location.reload();
                },
                beforeClose: function(){
                    // alert('Fancybox is closing');
                }
            });


            $('.subm-contact').click(function() {
                $('#contact-form').submit();
            });

        });


        //檢查 Email 格式
        function validate_email(email)
        {
            regex = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
            return regex.test(email);
        }

        //檢查手機號碼
        function validate_mobile_phone(mobile_phone)
        {
            regex = /^09[0-9]{8}$/;
            return regex.test(mobile_phone);
        }
    </script>
@endsection