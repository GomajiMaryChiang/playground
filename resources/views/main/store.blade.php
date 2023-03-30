@extends('modules.common')

@section('content')
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <!-- breadcrumb -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] ?? '#' }}">{{ $breadcrumb['title'] ?? '' }}</a></li>
                            @if (!empty($breadcrumb['subLink']))
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['subLink'] ?? '#' }}">{{ $breadcrumb['subTitle'] ?? '' }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['subTitle'] ?? '' }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
                <!-- End:breadcrumb -->
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main">
        <div class="sectionBox store-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="product-content-warp">
                            <div class="product-content-head relative">
                                <h1>
                                    {{ $store['store_name'] ?? '' }}
                                    @if (!empty($branchList))
                                        <span class="t-gray">(共{{ count($branchList) }}間分店)</span>
                                    @endif
                                </h1>
                                <!-- 店家評價 -->
                                @if ($store['store_rating_people'] > 0)
                                    <div class="label-smile {{ $store['store_rating_class'] }} font-weight-bold">
                                        <span class="t-10 number t-main">{{ $store['store_rating_int'] }}</span>
                                        <span class="t-085 t-main">{{ $store['store_rating_dot'] }}</span>
                                        <span class="t-085 t-main total">
                                            &nbsp;({{ $store['store_rating_people'] }})
                                        </span>
                                    </div>
                                @endif
                                <!-- End:店家評價 -->
                            </div>
                            <div class="row">
                                <div class="col-md-6 padding-0">
                                    <div class="product-imgBox relative">
                                        <img class="img-fluid border border-r lazyload" data-original="{{ $store['store_img_url'] ?? '' }}" alt="{{ $store['store_name'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if ($breadcrumb['chId'] != Config::get('channel.id.sh'))
                                        <div class="section-head">
                                            <!-- 店家評價 -->
                                            @if ($store['store_rating_people'] > 0)
                                                <div class="store-mm label-smile {{ $store['store_rating_class'] }} font-weight-bold">
                                                    <span class="t-10 number t-main">{{ $store['store_rating_int'] }}</span>
                                                    <span class="t-085 t-main">{{ $store['store_rating_dot'] }}</span>
                                                    <span class="t-085 t-main total">
                                                        &nbsp;({{ $store['store_rating_people'] }})
                                                    </span>
                                                </div>
                                            @endif
                                            <!-- End:店家評價 -->

                                            <!-- 分店下拉選項 -->
                                            @if (!empty($branchList))
                                                <div class="store filterbarBox">
                                                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ $defaultBranch['branch_name'] ?? '' }}
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                        @foreach ($branchList as $branch)
                                                            <a class="dropdown-item branch_dropdown_item" href="#" data-id="{{ $branch['branch_id'] ?? 0 }}">{{ $branch['branch_name'] ?? '' }}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- End:分店下拉選項 -->

                                            <!-- 店家資訊 -->
                                            <div id="store_info">
                                                @if (empty($branchList))
                                                    @if (!empty($store['store_address']))
                                                        <p>地址：{{ $store['store_address'] }}</p>
                                                    @endif
                                                    @if (!empty($store['store_tel']))
                                                        <p>電話：{{ $store['store_tel'] }}</p>
                                                    @endif
                                                @else
                                                    @if (!empty($defaultBranch['branch_address']))
                                                        <p>地址：{{ $defaultBranch['branch_address'] }}</p>
                                                    @endif
                                                    @if (!empty($defaultBranch['branch_phone']))
                                                        <p>電話：{{ $defaultBranch['branch_phone'] }}</p>
                                                    @endif
                                                    @if (!empty($defaultBranch['branch_business_hours']))
                                                        <p>營業時間：{{ $defaultBranch['branch_business_hours'] }}</p>
                                                    @endif
                                                    @if (!empty($defaultBranch['last_order_time']))
                                                        <p>最晚預約或點餐時間：{{ $defaultBranch['last_order_time'] }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                            <!-- End:店家資訊 -->

                                            <!-- 錯誤回報 -->
                                            <div class="report mt-3 mb-2">
                                                <a data-fancybox="" data-src="#report-popup" href="javascript:;" class="btn btn-main w-50">錯誤回報</a>
                                            </div>
                                            <!-- End:錯誤回報 -->
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- 類別標籤 -->
                            @if (!empty($categoryList))
                                <div class="store product-share">
                                    <div class="categoryBox float-left">
                                        @foreach ($categoryList as $category)
                                            <div class="list">
                                                <a href="{{ $category['link'] ?? '#' }}">{{ $category['name'] ?? '' }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- End:標籤 -->

                            <!-- 地圖 -->
                            <div class="gogole-map">                                
                                <iframe id="branchdesc__map" src="" width="100%" height="150" frameborder="0" style="border: 0px;" allowfullscreen=""></iframe>
                            </div>
                            <!-- End:地圖 -->
                        </div>
                        <!-- End:product-content店家訊息 -->

                        <!-- 優惠券列表 -->
                        @if (!empty($productList))
                            <div class="sectionBox">
                                <div class="section-head">
                                    <h2>優惠券</h2>
                                </div>
                                @foreach ($productList as $product)
                                    @include('layouts.product.storeCoupon')
                                @endforeach
                            </div>
                        @endif
                        <!-- End:優惠券列表 -->

                        <!-- 店家商品介紹 -->
                        @if (!empty($store['store_intro']))
                            <div class="sectionBox section-head">
                                <h2>店家商品介紹</h2>
                                {!! $store['store_intro'] !!}
                            </div>
                        @endif
                        <!-- End:店家商品介紹 -->
                    </div>
                    <!-- End:店家資訊 -->

                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12">
                        <a class="border-r store-app-banner" href="{{ url('/app') }}" target="_blank">
                            <img class="img-fluid lazyload" title="立刻下載APP輸入邀請碼" data-original="{{ url('/images/store-app-downloand.jpg') }}" alt="立刻下載APP輸入邀請">
                        </a>

                        <!-- 附近推薦檔次列表 -->
                        @if (!empty($otherProductList))
                            <div class="sectionBox store-nearby">
                                <div class="section-head">
                                    <h2>附近推薦</h2>
                                </div>
                                @foreach ($otherProductList as $product)
                                    @include('layouts.product.nearby')
                                @endforeach
                            </div>
                        @endif
                        <!-- End:附近推薦檔次列表 -->
                    </div>
                    <!-- End:旁邊-附近推薦 -->
                </div>
            </div>
        </div>
        <!-- End:檔次內容-->
    </main>
    <!-- End:main -->
@endsection

@section('popup')
    <!-- Popup:店家錯誤回報 -->
    <div style="display: none;" id="report-popup" class="popupBox w-35">
        <h2 data-selectable="true" class="t-orange">店家錯誤回報</h2>
        <input type="hidden" name="report_store_id" id="report_store_id" value="{{ $store['store_id'] ?? 0 }}">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="錯誤回報">錯誤回報
                </label>
            </div>
            <select class="custom-select" id="report_type">
                <option value="0" selected="">請選擇回報項目...</option>
                <option value="{{ Config::get('store.errorReport.close') }}">店家已結束營業</option>
                <option value="{{ Config::get('store.errorReport.address') }}">地圖地點、地址錯誤</option>
                <option value="{{ Config::get('store.errorReport.businessHours') }}">營業資訊(時間、電話)有誤</option>
            </select>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="錯誤回報">選擇分店</label>
            </div>
            <select class="custom-select" id="report_branch">
                @if (empty($branchList))
                    <option value="" selected="">請選擇...</option>
                    <option value="0">{{ $store['store_name'] }}</option>
                @else
                    <option value="" selected="">請選擇分店...</option>
                    @foreach ($branchList as $branch)
                        <option value="{{ $branch['branch_id'] ?? 0 }}">{{ $branch['branch_name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="input-group mb-3" id="report_branch_address" style="display: none;">
            <div class="input-group-prepend">
                <label class="input-group-text" for="錯誤回報">更正地址
                </label>
            </div>
            <input type="text" class="form-control" placeholder="" aria-label="" id="branch_address">
        </div>
        <div class="input-group mb-3" id="report_branch_business_hours" style="display: none;">
            <div class="input-group-prepend">
                <label class="input-group-text" for="錯誤回報">營業資訊更正
                </label>
            </div>
            <input type="text" class="form-control" placeholder="" aria-label="" id="branch_business_hours">
        </div>
        <p id="report_message" class="d-flex justify-content-center" style="color: red; margin-bottom: 0.5rem !important;"></p>
        <p class="d-flex justify-content-center">
            <button data-fancybox-close="" class="btn btn-gray w-25 mr-2" href="#">取消</button>
            <button class="btn btn-main w-25" href="#" id="report_submit">送出</button>
        </p>
    </div>
    <!-- End:店家錯誤回報 -->
@endsection

@section('script')
    <script>
        $(function () {
            let branchList = @json($branchList);

            // 圖片Lazyload，進入頁面時視窗內的圖片先讀取
            $('img.lazyload').lazyload().each(function() {
                if ($(this).offset().top < $(window).height()) {
                    $(this).trigger('appear');
                }
            })

            // 地圖
            if (branchList != '') {
                buildMap('{{ $defaultBranch["real_branch_address"] ?? '' }}', '{{ $defaultBranch["lat"] ?? '' }}', '{{ $defaultBranch["lng"] ?? '' }}');
            } else {
                buildMap('{{ $store["store_address"] ?? '' }}');
            }

            // 分店的下拉選單
            $('.branch_dropdown_item').click(function(e) {
                e.preventDefault();
                let branchId = $(this).attr('data-id');
                let branchObj = branchList.hasOwnProperty(branchId) ? branchList[branchId] : false;

                if (!branchObj) {
                    return ;
                }

                // 更新下拉選單 active 的字
                $('#dropdownMenuLink').html(branchObj.branch_name);

                // 更新店家資訊
                let storeInfoAry = [];
                if (branchObj.hasOwnProperty('branch_address') && branchObj.branch_address != '') {
                    storeInfoAry.push(`地址：${branchObj.branch_address}`);
                }
                if (branchObj.hasOwnProperty('branch_phone') && branchObj.branch_phone != '') {
                    storeInfoAry.push(`電話：${branchObj.branch_phone}`);
                }
                if (branchObj.hasOwnProperty('branch_business_hours') && branchObj.branch_business_hours != '') {
                    storeInfoAry.push(`營業時間：${branchObj.branch_business_hours}`);
                }
                if (branchObj.hasOwnProperty('last_order_time') && branchObj.last_order_time != '') {
                    storeInfoAry.push(`最晚預約或點餐時間：${branchObj.last_order_time}`);
                }
                $('#store_info').html('<p>' + storeInfoAry.join('</p><p>') + '</p>');

                // 更新地圖
                buildMap(branchObj.real_branch_address, branchObj.lat, branchObj.lng);
            });

            // 錯誤回報跳窗 - 回報項目
            $('#report_type').change(function() {
                let reportItem = $(this).val();
                switch(reportItem) {
                    case '0':
                        $('#report_branch_address').hide();
                        $('#report_branch_business_hours').hide();
                        break;
                    case `{{ Config::get('store.errorReport.close') }}`:
                        $('#report_branch_address').hide();
                        $('#report_branch_business_hours').hide();
                        break;
                    case `{{ Config::get('store.errorReport.address') }}`:
                        $('#report_branch_business_hours').hide();
                        $('#report_branch_address').show();
                        break;
                    case `{{ Config::get('store.errorReport.businessHours') }}`:
                        $('#report_branch_address').hide();
                        $('#report_branch_business_hours').show();
                        break;
                }
                changeDetail();
            });

            // 錯誤回報跳窗 - 選擇分店
            $('#report_branch').change(function() {
                changeDetail();
            });

            // 錯誤回報跳窗 - 點選送出
            $('#report_submit').click(function(e) {
                e.preventDefault();

                let reportStoreId = $('#report_store_id').val();
                let reportBranchId = $('#report_branch').val();
                let reportType = $('#report_type').val();
                let reportAddress = $('#branch_address').val().trim();
                let reportBusinessHours = $('#branch_business_hours').val().trim();
                let reportTypeAry = [
                    `{{ Config::get('store.errorReport.close') }}`,
                    `{{ Config::get('store.errorReport.address') }}`,
                    `{{ Config::get('store.errorReport.businessHours') }}`
                ];

                // 參數檢查
                if (reportTypeAry.indexOf(reportType) === -1) {
                    $('#report_message').text('請選擇回報項目！');
                    return;
                }
                if (reportBranchId == '') {
                    $('#report_message').text('請選擇分店！');
                    return;
                }
                if (reportType == `{{ Config::get('store.errorReport.address') }}` && reportAddress == '') {
                    $('#report_message').text('請填寫更正地址！');
                    return;
                }
                if (reportType == `{{ Config::get('store.errorReport.businessHours') }}` && reportBusinessHours == '') {
                    $('#report_message').text('請填寫營業資訊更正！');
                    return;
                }

                axios({
                    method: 'post',
                    url: '/api/errorReport',
                    data: {
                        storeId: reportStoreId,
                        branchId: reportBranchId,
                        reportType,
                        branchAddress: reportAddress,
                        branchBusinessHours: reportBusinessHours,
                    },
                    config: {
                        headers: { 'Content-Type': 'multipart/form-data' },
                        responseType: 'json',
                    },

                }).then(function(response) {
                    let res = response.hasOwnProperty('data') ? response.data : {};
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '0';
                    let description = res.hasOwnProperty('description') ? res.description : '回報失敗>< 請稍後再試～';
                    let data = res.hasOwnProperty('data') ? res.data : {};

                    if (returnCode != '0000') {
                        $.fancybox.close();
                        swal(`${description}（${returnCode}）`, '', 'warning');
                        return;
                    }

                    $.fancybox.close();
                    resetReportPopup();
                    swal('感謝回報', '我們已經收到您的回報，謝謝您的協助！', 'success');
                    return;

                }).catch(function (error) {
                    console.log(error);
                });
            });

            /*
             * 更新地圖
             */
            function buildMap(address, lat = '', lng = '')
            {
                $('#branchdesc__map').hide();

                if (address == '') {
                    return;
                }

                address = encodeURIComponent(address);
                $('#branchdesc__map').attr('src', `https://maps.google.com/maps?f=q&source=s_q&hl=zh-TW&geocode=&ie=UTF8&z=14&iwloc=A&output=embed&hq=&q=${address}&hnear=${address}&sll=${lat},${lng}`);

                $('#branchdesc__map').show();
            }

            /*
             * 錯誤回報跳窗 - 更新地址＆營業資訊的說明內容
             */
            function changeDetail()
            {
                let branchId = $('#report_branch').val();
                let branchObj = branchList.hasOwnProperty(branchId) ? branchList[branchId] : false;

                if (!branchObj) {
                    return;
                }

                $('#branch_business_hours').attr('placeholder', branchObj.branch_business_hours);
                $('#branch_address').attr('placeholder', branchObj.branch_address);
            }

            /*
             * 錯誤回報跳窗 - 清空欄位
             */
            function resetReportPopup()
            {
                $('#report_message').text('');
                $('#report_branch').val('');
                $('#report_type').val('0');
                $('#branch_address').val('');
                $('#branch_business_hours').val('');
                $('#report_type').trigger('change');
            }
        });
    </script>
@endsection