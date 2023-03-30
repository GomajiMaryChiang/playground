@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">店家洗單通報</h1>
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
                            <li class="breadcrumb-item active" aria-current="page">店家洗單通報</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper border border-r">
                        <p><i class="i-help-mail"></i></p>
                        <p class="text-center sub-title t-11">為確保店家服務品質，如您與店家預約或到店時，店家要求或暗示接受直接付款，取代使用 GOMAJI 兌換劵或建議將已購買兌換劵退費，請向 GOMAJI 通報！<br>經查證屬實將可獲$500點數給予每一店家之首位回報者，未符合發送資格者將不另行通知。<br><a class="t-main underline" href="{{ url('/help?faq=11.3') }}" target="_blank">詳細規定</a></p>
                        <form id="contact-form" class="contactBox store-violations">
                            <input type="hidden" id="product_id" name="product_id" value="{{ $store['product_id'] }}">
                            <input type="hidden" id="store_id" name="store_id" value="{{ $store['store_id'] }}">
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="title">店家名稱</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <h3 class="store-name">{{ $store['store_branch'][0]['store_name'] ?? '' }}</h3>
                                    @if ($store['multi_store_one_branch'] == 'Y')
                                        <input id="store_branch" name="store_branch" maxlength="100" size="20" type="text" placeholder="店家分店" />
                                    @elseif ($store['multi_store_one_branch'] == 'N')
                                        <select id="store_branch" name="store_branch" class="form-control check-select left mr-3 w-260">
                                            @foreach ($store['store_branch'] as $branch)
                                                <option value="{{ $branch['group_id'] }}" gid="{{ $branch['group_id'] }}" @if ($branch['group_id'] == $store['select_branch_id']) selected @endif>
                                                    {{ $branch['branch_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select id="store_branch" name="store_branch" class="form-control check-select w-75">
                                            <option value="0">請選擇分店</option>
                                            @foreach ($store['store_branch'] as $branch)
                                                <option value="{{ $branch['group_id'] }}" gid="{{ $branch['group_id'] }}" @if ($branch['group_id'] == $store['select_branch_id']) selected @endif>{{ $branch['branch_name'] }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">通報人姓名</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <input id="full_name" name="full_name" type="text" maxlength="4" size="4" class="form-control" placeholder="請填寫姓名" autocomplete="off">
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
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="required title">洗單描述</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <textarea id="contact_content" name="contact_content" class="form-control" rows="5"></textarea>
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
                    'subject': '店家洗單通報',
                    'product_id': $('#product_id').val(),
                    'store_id': $('#store_id').val(),
                    'store_name': $('#store_branch').val(),
                    'full_name': encodeURIComponent($('#full_name').val()),
                    'email': $('#email').val(),
                    'mobile_phone': $('#mobile_phone').val(),
                    'contact_content': $('#contact_content').val()
                }

                if (data.store_name && data.store_name != '0') {
                    data.group_id = $(this).find('select[name=store_branch] option:selected').attr('gid');
                }

                if (! data.store_name || '0' == data.store_name) {
                    error_msg.push('‧ 店家名稱不得為空白');
                } else if ('' == data.full_name) {
                    error_msg.push('‧ 請填寫通報人姓名');
                } else if ('' == data.email) {
                    error_msg.push('‧ 請填寫通報人EMAIL');
                } else if (! validate_email(data.email)) {
                    error_msg.push('‧ 通報人EMAIL格式錯誤');
                } else if ('' == data.mobile_phone) {
                    error_msg.push('‧ 請填寫通報人手機');
                } else if (! validate_mobile_phone(data.mobile_phone)) {
                    error_msg.push('‧ 通報人手機格式錯誤');
                } else if ('' == data.contact_content) {
                    error_msg.push('‧ 請填寫洗單描述');
                }

                if (error_msg.length > 0) {
                    alert(error_msg.join("\n"));
                    form.data('submitting', false);
                } else {

                    $.post('/api/storeViolation', { data: JSON.stringify(data) }, function (data) {
                        if ('0000' == data.return_code) {
                            $.fancybox.open('<div class="popupBox popupBox-400">\n' +
                                '    <h2 data-selectable="true" class="t-11 mb-2"><span class="t-song">感謝您</h2>\n' +
                                '    <p data-selectable="true" class="text-center" id="send-message">\n' +
                                '    感謝您提供寶貴的資訊！GOMAJI 稽核小組將立即進行查證，如確認有洗單行為將發送點數給予每一店家之第一位回報者，未符合資格者不另行通知。謝謝您的支持！</p>\n' +
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
