@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">電子報訂閱管理</h1>
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
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">電子報訂閱管理</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper rating-wrapper border border-r">
                        <p><img class="maji" src="{{ url('/images/maji-epaper.png') }}" alt="麻吉妹妹嚇到"></p>
                        <p class="text-center sub-title t-14 mb-3">您確定要取消電子報嗎？快下載 APP ，優惠訊息更即時！</p>
                        <p class="text-center t-10">請勾選訂閱好康報內容：</p>
                        <p class="text-center t-10">E-mail ： <span class="t-main">{{ $email }}</span></p>

                        @if (!empty($edmCityList))
                            <form class="contactBox store-violations">
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-4 col-sm-12 col-12">
                                        <label class="title">請選擇好康報訂閱城市</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-12">
                                        @foreach ($edmCityList as $cityId => $edmCity)
                                            @if (!empty($edmCity['newline']))
                                                <br>
                                            @endif 
                                            <label class="input-ckeckbox mt-3 ml-3">
                                                <input 
                                                    name="with-order-info" 
                                                    type="checkbox" 
                                                    aria-label="" 
                                                    value="{{ $cityId }}" 
                                                    @if (!empty($edmCity['checked'])) checked @endif 
                                                >
                                                <span>{{ $edmCity['name'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-4 col-sm-12 col-12">
                                        <label class="title">快速選擇</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-12">
                                        <label class="input-ckeckbox mt-3 ml-3">
                                            <input type="checkbox" aria-label="" id="cancelAll">
                                            <span>全部取消</span>
                                        </label>
                                        <label class="input-ckeckbox mt-3 ml-3">
                                            <input type="checkbox" aria-label="" id="selectAll">
                                            <span>全部訂閱</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <a class="btn btn-main m-auto w-75 mb-4" href="javascript:;" role="button" id="submit">
                                            送出
                                        </a>
                                    </div>
                                </div>
                                <div class="row no-gutters input-group contact-panel">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <a href="{{ url('/app') }}" target="_blank"><img class="img-fluid" src="{{ url('/images/ad-app.png') }}" alt="下載APP輸入優惠碼"></a>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('popup')
    <!-- Popup:offer-notice-popup 訂閱優惠通知  -->
    <div style="display: none;" id="epapermail-popup" class="popupBox w-25">
        <h2 class="t-main">電子報訂閱</h2>
        <div class="content">
                <p class="text-center"></p>
            </div>
        <p class="d-flex justify-content-center mt-3">
            <a class="btn btn-main w-25" href="{{ url('/') }}">回首頁</a>
        </p>
    </div>
    <!-- End:offer-notice-popup 訂閱優惠通知 -->
@endsection

@section('script')
    <script>
        // 全部訂閱
        $('#selectAll').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="with-order-info"]').prop('checked', true);
                $('#cancelAll').prop('checked', false);
            }
        });

        // 全部取消
        $('#cancelAll').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="with-order-info"]').prop('checked', false);
                $('#selectAll').prop('checked', false);
            }
        });

        // 點擊“送出”
        $('#submit').click(function(e) {
            let cityList = $('input[name="with-order-info"]:checked').map(function() { return $(this).val(); }).get().join(',');
            let session = '{{ $session }}';

            axios({
                method: 'put',
                url: '/api/epaper',
                data: { cityList, session },
                config: {
                    headers: { 'Content-Type': 'multipart/form-data' },
                    responseType: 'json',
                },
            }).then(function(response) {
                let res = response['data'];
                let popupText = '';
                switch (res['return_code']) {
                    case '0000':
                        popupText = '您已成功更新電子報訂閱狀態，謝謝！';
                        break;
                    default:
                        popupText = '訂閱失敗，請重新訂閱或洽客服人員（' + res['return_code'] + '）';
                        break;
                }
                $('#epapermail-popup').find('.text-center').text(popupText);
                $.fancybox.open({
                    src: '#epapermail-popup'
                });
            }).catch(function (error) {
                console.log(error);
            });
        });
    </script>
@endsection
