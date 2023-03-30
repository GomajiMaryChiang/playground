@extends('modules.common')

@section('content')
    <div class="product-head-wrapper earnpoint-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/earnpoint') }}">聰明賺點</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $earnpointData['store_name'] ?? '' }}</li>
                        </ol>
                    </nav>
                </div>
                <!-- End:breadcrumb -->
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main earnpoint-brandBox">
        <div class="sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="brandlist-Box brand-card border border-r bg-white">
                            <div class="product-img relative">
                                <img class="img-fluid border-b" src="{{ $earnpointData['store_logo'] ?? '' }}" alt="{{ $earnpointData['store_name'] ?? '' }}">
                            </div>
                            <div class="brand-detail">
                                @if (!empty($earnpointData['reward_info']['main_reward']))
                                    <h3 class="text-center">最高贈<span class="t-main">{{ $earnpointData['reward_info']['main_reward'] }}</span>點數回饋</h3>
                                @endif

                                @if (!empty($earnpointData['reward_info']['rewards']))
                                    @foreach ($earnpointData['reward_info']['rewards'] as $reward)
                                        <p class="text-center mt-1">{{ $reward['reward_name'] ?? '' }}<span class="t-main ml-1">{{ $reward['reward_percentage'] ?? '' }}</span></p>
                                    @endforeach
                                @endif
                                <a id="jumpthirdparty" class="button btn btn-main m-3 " href="javascript:;" rel="buy">
                                    馬上購買
                                </a>
                                <hr>    
                                <p class="text-center">{{ $earnpointData['reward_info']['reward_desc'] ?? '' }}</p>
                                
                                @if (!empty($earnpointData['point_process_days']))
                                    <p class="after-purchase">{{ $earnpointData['point_process_days'] }}</p>
                                    <p class="text-center t-darkgray t-09">處理中</p>
                                @endif

                                @if (!empty($earnpointData['point_account_days']))
                                    <p class="after-purchase">{{ $earnpointData['point_account_days'] }}</p>
                                    <p class="text-center t-darkgray t-09">點數入帳</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12">
                        @if (!empty($earnpointData['promos']))
                            <div class="brandcouponBox border border-r bg-white p-3">
                                <h3>優惠券</h3>
                                <div class="row">
                                    @foreach ($earnpointData['promos'] as $promo)
                                        <div class="col-12 col-md-6">
                                            <div class="coupon-discount brand-detail rounded">
                                                <p class="t-12">{{ $promo['promo_name'] ?? '' }}</p>
                                                <p class="t-gray">{{ $promo['period'] ?? '' }}</p>

                                                @if (!empty($promo['promo_code']))
                                                    <a class="copycode text-center copy-share" href="javascript:;" data-clipboard-text="{{ $promo['promo_code'] }}">複製 {{ $promo['promo_code'] }}</a>
                                                @endif
                                            </div>
                                            <p>{{ $promo['promo_description'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="brandinfoBox border bg-white border-r mt-3 p-3">
                            <h3>注意事項</h3>
                            @if (!empty($earnpointData['notice']))
                                <ul>
                                    @foreach ($earnpointData['notice'] as $rule)
                                        <li>{{ $rule }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if (!empty($earnpointData['desc_pic']))
                                <img class="img-fluid mt-3" src="{{ $earnpointData['desc_pic'] }}" alt="{{ $earnpointData['store_name'] ?? '' }}點數聰明賺">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
    <form id="form" action="{{ url('/earnpoint/jumpthirdparty') }}" method="POST" style="display: none">
        {{ csrf_field() }}
        <input type="hidden" name="storeId" value="{{ $earnpointData['store_id'] ?? '' }}">
    </form>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('js/assets/sweetalert-2.8.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/clipboard.min.js') }}"></script>
    <script>
        $(function () {
            // 複製
            new Clipboard('.copycode');

            // 複製成功跳窗
            $('.copycode').click(function (e) {
                swal('複製成功', '', 'success');
            });

            // 點擊“馬上購買”
            $('#jumpthirdparty').click(function(e) {
                let isLogin = '{{ $isLogin ?? "" }}';
                let isRedirect = '{{ $redirectData["isRedirect"] ?? "" }}';
                let redirectUri = '{!! $redirectData["uri"] ?? "#" !!}';

                // 如有登入，直接導到跳轉頁
                if (isLogin) {
                    $('#form').submit();
                    return;
                }

                // 如未登入且可導登入頁，直接導到登入頁
                if (isRedirect) {
                    window.location = redirectUri;
                    return;
                }

                // 如未登入且不可導登入頁，跳訊息跳窗
                Swal.fire({
                    title: '請至APP下方 "我的" 驗證手機號碼',
                    text: '完成認證後將回到首頁，請重新進入即可呦～',
                    imageUrl: '{{ url("/img/maji_sister_7.png") }}',
                    allowOutsideClick: true,
                    confirmButtonText: '確定',
                    confirmButtonColor: '#F4880C',
                }).then((result) => {
                    if (result.value) {
                        window.location = redirectUri;
                    }
                })
            });
        });
    </script>
@endsection
