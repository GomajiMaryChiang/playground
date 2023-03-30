@extends('modules.common')

@section('content')
    <!-- 宅配規格 -->
    <div class="sectionBox checkout-card-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <form id="specForm" name="specForm" class="col-lg-10 col-md-10 padding-0">
                    <div class="checkout-card border border-r">
                        <h2 class="checkout-card-header">數量/商品</h2>
                        <div class="checkout-card-box">
                            @if ($productInfo['sp_flag'] == 1)
                                <div class="panel-box container mt-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-2">
                                            <h3 class="t-10 mt-2">方案</h3>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="sp_id" name="sp_id" class="form-control check-select">
                                            @if (!empty($productInfo['sub_products']))
                                                @foreach ($productInfo['sub_products'] as $key => $value)
                                                    <option value="{{ $value['sp_id'] }}"
                                                            price="{{ $value['sp_price'] }}"
                                                            radix="{{ $value['sp_radix'] }}"
                                                            pre_buy_no="{{ $value['sp_pre_buy_no'] }}"
                                                            @if ($value['sp_id'] == $spid && $value['sp_pre_buy_no'] != 0)
                                                                selected
                                                            @elseif ($value['sp_pre_buy_no'] == 0)
                                                                disabled="disabled"
                                                            @endif
                                                            >
                                                            {{ $value['sp_name'] }}
                                                        @if ($value['sp_pre_buy_no'] == 0)
                                                            （售完）
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @elseif (count($productInfo['sub_products']) == 0 && $productInfo['inventory'] == 1)
                                                <option value="0"
                                                        radix="{{ $productInfo['radix'] }}"
                                                        pre_buy_no="{{ $productInfo['pre_buy_no'] }}"
                                                        >
                                                        {{ $productInfo['product_name'] }}
                                                </option>
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="panel-box container mt-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-2">
                                            <h3 class="t-10 mt-2">方案</h3>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="sp_id" name="sp_id" class="form-control check-select" disabled>
                                            @if (!empty($productInfo['sub_products']))
                                                @foreach ($productInfo['sub_products'] as $key => $value)
                                                    <option value="{{ $value['sp_id'] }}"
                                                            price="{{ $value['sp_price'] }}"
                                                            radix="{{ $value['sp_radix'] }}"
                                                            pre_buy_no="{{ $value['sp_pre_buy_no'] }}"
                                                            >
                                                            {{ $value['sp_name'] }}
                                                    </option>
                                                @endforeach
                                            @elseif (count($productInfo['sub_products']) == 0 && $productInfo['inventory'] == 1)
                                                <option value="0"
                                                        radix="{{ $productInfo['radix'] }}"
                                                        pre_buy_no="{{ $productInfo['pre_buy_no'] }}"
                                                        >
                                                        {{ $productInfo['product_name'] }}
                                                </option>
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="panel-box container">
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <h3 class="t-10 mt-2">數量</h3>
                                    </div>
                                    <div class="col-md-9">
                                        <select id="buy_number" name="buy_number" class="form-control check-select w-30">
                                            <option value="0">請選擇</option>
                                            @if ($productInfo['sp_flag'] > 0 && $productInfo['sub_products'])
                                                @foreach ($productInfo['sub_products'] as $key => $value)
                                                    @if ($spid == $value['sp_id'])
                                                        @for ($i = 1; $i <= $value['sp_pre_buy_no']; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    @endif
                                                @endforeach
                                            @else
                                                @for ($i = 1; $i <= $productInfo['pre_buy_no']; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            @endif
                                        </select>
                                        <p class="no-empty error" style="display:none;">不可空白，請選擇數量</p>
                                    </div>
                                </div>
                            </div>
                            @if (isset($specUnits) && !empty($specUnits))
                            <div class="panel-box container">
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <h3 class="t-10 mt-2">商品規格</h3>
                                    </div>
                                    <div class="col-md-10 card-wrapper">
                                        <p class="title t-main">您的購物清單商品總和為：<span class="select_buy_number number">0</span>
                                            <span>
                                                <a class="look" data-fancybox="" data-src="#productpackage-popup" href="javascript: void(0);">(查看規格)</a>
                                            </span>
                                        </p>
                                        <!-- 規格選擇區塊 Start -->
                                        <div class="cardBox table_{{ $spid }}">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="spec_th">
                                                        {!! $table['group_' . $groupId]['specTh'] !!}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="spec_td item-row">
                                                        {!! $table['group_' . $groupId]['specTd'] !!}
                                                    </tr>
                                                    <tr id="add-item">
                                                        <td colspan="4" width="100%">
                                                            <div class="card-plus">
                                                                <a class="btn btn-outline-main" href="javascript: void(0);">
                                                                    新增商品項目
                                                                </a>
                                                                <p class="warning text-center error" style="display:none;"></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- 規格選擇區塊 End -->
                                        <!-- PC 購物車 Start -->
                                        <div class="shopping-cartBox">
                                            <p class="t-danger t-095">請再挑選<span class="remainRadix">0</span>件商品</p>
                                            <div class="shopping-cart">
                                                <table class="list-table table">
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- PC 購物車 End -->
                                        <!-- MM 購物車 Start -->
                                        <div class="shopping-cart-mm">
                                            <table class="mm-list-table">
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- MM 購物車 End -->
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="checkout-part checkout-buy border py-3 bg-gray">
                        <a class="formCheck product-hint btn btn-main my-4 w-50 m-auto" href="{{ $sendLink }}">確認，下一步</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 最後送出 Form 及 JSON String 放這邊 -->
    <form id="sendForm" name="sendForm" method="POST" action="https://ssl.gomaji.com/checkout-1.php?pid={{ $pid }}&sp_id={{ $spid }}&share_code={{ $shareCode }}{{ !empty($ref) ? '&ref=' . $ref : '' }}" style="display:none;" role="form">
        <input type="hidden" id="json" name="json" value="">
    </form>
    <input type="hidden" id="pid" name="pid" value="{{ $pid }}">
    <input type="hidden" id="platform" name="platform" value="{{ $platform }}">
    <input type="hidden" id="radix" name="radix" value="{{ $productInfo['radix'] }}">
    <input type="hidden" id="groupId" name="groupId" value="{{ $groupId }}">
    <input type="hidden" id="sp_flag" name="sp_flag" value="{{ $productInfo['sp_flag'] }}">
    <input type="hidden" id="inventoryCheck" name="inventoryCheck" value="{{ count($specInfo['inventory_ids']) }}">
    <input type="hidden" id="preview" name="preview" value="{{ $preview }}">
    <input type="hidden" id="shareCode" name="shareCode" value="{{ $shareCode }}">
    <input type="hidden" id="ref" name="ref" value="{{ $ref }}">
    <input type="hidden" id="introUrl" name="introUrl" value="{{ $productInfo['product_intro_url'] }}">
    <input type="hidden" id="tableJSON" name="tableJSON" value="{{ ($tableJSON) ?? '' }}">
    <input type="hidden" id="quantity" name="quantity" value="{{ ($quantity) ?? '' }}">
    <input type="hidden" id="units" name="units" value="">
    <!-- End:宅配規格 -->
@endsection

@section('popup')
    <!-- Popup productpackage-popup -->
    <div style="display: none;" id="productpackage-popup" class="popupBox storeBranchBox">
        <h2 class="t-main" data-selectable="true">商品內容</h2>
        <div class="panel-box cityBox container bg-pink">
            <div class="row justify-content-center no-gutters">
                <div class="col-md-12">
                    <div class="applicable"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Popup productpackage-popup -->
@endsection

@section('script')
    <script>
        $(function() {
            var groupId = $('#groupId').val();

            var introUrl = $('#introUrl').val();
            // 商品詳細規格介紹
            $.get(introUrl, function(html) {
                $('#productpackage-popup').find('.applicable').html(html);
            })
            var platform = $('#platform').val();
            var table = $('.cardBox table');
             // 定住規格第一欄欄位初始樣貌
            var sp_flag = parseInt($('#sp_flag').val());
            var pid = $('#pid').val();
            var sp_id = $('#sp_id').val(); // 方案ID
            var radix = $('#sp_id').find('option:selected').attr('radix'); // 方案基數
            var pre_buy_no = $('#sp_id').find('option:selected').attr('pre_buy_no'); // 最大可選擇方案數量
            var buy_number = $('#buy_number').val(); // 方案數量
            var quantity = JSON.parse($('input[name="quantity"]').val()); // 規格數量表
            var table = JSON.parse($('input[name="tableJSON"]').val()); // 表格規格欄位
            var units = new Object; // 詳細規格內容
            var buy_number = 0; // 方案數量初始為零
            var totalRadix = 0; // 應選商品數初始為零
            var selectedRadix = 0; // 已選擇商品數初始為零
            var remainRadix = 0; // 剩餘可選數量初始為零
            var buy_number_option; // 定義方案數量下拉選項
            var alertCheck = true; // alert() 彈跳視窗出現與否
            var stopCheck = true; // 變更細項選擇時，是否顯示數量
            var formCheck = false; // 是否可以提交判斷
            var submitCheck = false; // 點擊提交按鈕的判斷
            var actionRoute = $('#sendForm').attr('action');
            var preview = $('#preview').val();
            var shareCode = $('#shareCode').val();
            var ref = $('#ref').val();

            // 如果一進到頁面，有規格選擇不是在「請選擇」欄位
            // 可能是因為由結帳頁面按下上一頁所導致，先回到「請選擇」欄位
            $('.input_css').each(function() {
                $(this).find(`option[value="0"]`).prop('selected', true);
            })
            $('.group_id')
            $('#buy_number').find(`option[value="0"]`).prop('selected', true);

            // 選擇方案變更
            $('#sp_id').on('change', function(event) {
                alertCheck = false;
                $.get("{{ url('/api/inventory') }}", {
                    'pid': {{ $pid }},
                    'spid': $(this).val()
                }, function(json) {
                    jsonObj = JSON.parse(json);
                    if (jsonObj.length != 0) {
                        groupId = jsonObj.groupId;
                        quantity = (jsonObj.quantity ? JSON.parse(jsonObj.quantity) : '');
                        $('.spec_th').html(jsonObj['table'][`group_${groupId}`].specTh);
                        $('.spec_td').html(jsonObj['table'][`group_${groupId}`].specTd);
                        $('.input_css').off().on('change', function() {
                            selectChange($(this), groupId, alertCheck, quantity);
                        })
                    }
                })
                sp_id = $(this).val(); // 方案ID
                radix = $(this).find('option:selected').attr('radix');
                pre_buy_no = $(this).find('option:selected').attr('pre_buy_no');
                actionRoute = `https://ssl.gomaji.com/checkout-1.php?pid=${pid}&sp_id=${sp_id}&share_code=${shareCode}&ref=${ref}`;
                $('#sendForm').attr('action', actionRoute);
                $('.select_buy_number').text(0);
                $('#add-item').find('p').hide(); // 「新增商品項目」重新選擇方案後隱藏提示文字訊息

                // 換方案則把方案數量重新帶入
                buy_number_option = '<option value="0" selected>請選擇</option>';
                for (let i = 1; i <= pre_buy_no; i++) {
                    buy_number_option += `<option value="${i}">${i}</option>`;
                }
                $('#buy_number').empty().html(buy_number_option);
                // 方案有變更，下列歸零
                buy_number = 0;    // 方案數量
                totalRadix = 0;    // 商品應選總數
                selectedRadix = 0; // 商品已選總數
                remainRadix = 0; // 剩餘可選數量跟著歸零
                $('.remainRadix').text(remainRadix);
                $('select[name="inventory_quantity"]').eq(0).trigger('change').parent().find('option:not([value="0"])').remove();
                $('.warning').text('').hide();
                alertCheck = true;
                formCheck = false;

                $('.list-table > tbody, .mm-list-table > tbody').empty();
            })
            $('#sp_id').trigger('change');

            // 方案數量變更
            $('#buy_number').on('change', function() {
                alertCheck = false;
                buy_number = $(this).val(); // 方案數量
                totalRadix = parseInt(buy_number, 10) * parseInt(radix, 10); // 計算應購買數量
                remainRadix = countRadix(selectedRadix, totalRadix); // 重新計算剩餘可買數量
                // 如果 totalRadix != 0 且 remainRadix == 0，代表有應選商品數量且已經剛好選滿
                formCheck = (totalRadix != 0 && remainRadix == 0) ? true : false;
                $('.select_buy_number').text(totalRadix); // 可選商品應有數量塞入「您的購物清單商品總和」後方
                if ($(this).val() != 0) {
                    $('#buy_number').removeClass('form-control-error');
                    $('.no-empty').fadeOut();
                } else {
                    $('#buy_number').addClass('form-control-error');
                    $('.no-empty').fadeIn();
                }
                if (!formCheck) {
                    // 「規格」跟「數量」回到"請選擇"選項，並清空其他數字
                    $('.input_css').each(function() {
                        $(this).find('option[value="0"]').prop('selected',true);
                    })
                    $('select[name="inventory_quantity"]').prop('disabled', false).find('option').each(function(i, v) {
                        if (i == 0) {
                            $(this).text('請選擇').prop('selected', true);
                            return;
                        }
                        $(this).remove();
                    })
                }
                alertCheck = true;
            })

            if ($('#inventoryCheck').val() != 0) {
                // 商品規格欄位有改變
                $('.input_css').off().on('change', function() {
                    selectChange($(this), groupId, alertCheck, quantity);
                })

                $(document).on('change', '.group_id', function() {
                    var groupId = $(this).val();
                    let tr = $(this).parent().parent().parent().parent().find('tr');
                    tr.eq(0).html(table[`group_${groupId}`]['specTh']);
                    tr.eq(1).html(table[`group_${groupId}`]['specTd']);
                    tr.find(`option[value="${groupId}"]`).prop('selected', true);
                    $('.input_css').off().on('change', function() {
                        selectChange($(this), groupId, alertCheck, quantity);
                    })
                })

                // 新增商品項目按鈕
                $('#add-item a').on('click', function() {

                    if ($('select[name="inventory_quantity"]').val() == 0) {
                        $('select[name="inventory_quantity"]').addClass('form-control-error');
                        $('.input_css').each(function() {
                            if ($(this).val() == 0) {
                                $(this).addClass('form-control-error')
                            }
                        })
                        // 如果規格沒有選數量
                        return false;
                    }

                    // 如果 inventory_ids 為空，代表此規格沒有庫存了
                    if ($('input[name="inventory_ids"]').val() == '') {
                        alert('此商品庫存數量不足，請選擇其他規格，謝謝！');
                        return false;
                    }

                    groupId = $('#group_id').val();
                    let tbody = $('.list-table tbody');
                    let tbodyMM = $('.mm-list-table tbody')
                    let length = $('.input_css').length;
                    let specArray = []; // 規格陣列
                    let specString = ''; // 規格ID組成字串，例 36850,36851
                    let specName = ''; // 規格中文，例 經典原味/大包
                    let specDetail = ''; // PC規格HTML
                    let specDetailMM = ''; // MM規格HTML

                    $('.input_css').each(function(index, element) {
                        specArray.push($(this).val());
                        specName += $(this).find('option:selected').text() + '/';
                        specDetail += ((length - 1) != index)
                            ? `<span class="list_punit" data-punit="punit[${groupId}]" data-value="${$(this).find('option:selected').val()}">${$(this).find('option:selected').text()}</span> / `
                            : `<span class="list_punit" data-punit="punit[${groupId}]" data-value="${$(this).find('option:selected').val()}">${$(this).find('option:selected').text()}</span>`;
                        specDetailMM += `<p>${$(this).find('option:selected').text()}</p>`;
                    })
                    specName = specName.slice(0, -1); // 除去規格文字最後一個'/'
                    specString = specArray.join(); // 點擊改變的這一行規格 ex:款式,顏色,尺寸
                    quantity[specString].selectedNo += parseInt($('select[name="inventory_quantity"]').val()); // 該規格總計已選數量
                    // 如果超過規格庫存上限 Start
                    if (quantity[specString].selectedNo > quantity[specString].maxNo) {
                        alert(`${specName} 數量已超過最高可訂購量，請調整數量或規格，謝謝！`);
                        quantity[specString].selectedNo -= parseInt($('select[name="inventory_quantity"]').val());
                        countSelectableNum(quantity, specString); // 計算規格可選數量
                        return;
                    }
                    // 如果超過規格庫存上限 End

                    let list = `
                        <tr>
                            <td width="40%">
                                <p class="list_group_id" data-value="${$('.group_id').find('option:selected').val()}">${$('.group_id').find('option:selected').text()}</p>
                            </td>
                            <td width="30%" class="relative">
                                <p class="specString" data-string="${specString}">${specDetail}</p>
                            </td>
                            <td width="15%">
                                數量：<span class="list_inventory_quantity" data-value="${$('select[name="inventory_quantity"]').val()}">${$('select[name="inventory_quantity"]').val()}</span>
                            </td>
                            <td width="15%" class="relative">
                                <a class="remove-btn btn btn-plan radius" href="javascript: void(0);">
                                    移除
                                </a>
                                <input type="hidden" class="list_inventory_ids" value="${$('input[name="inventory_ids"]').val()}"></input>
                            </td>
                        </tr>
                    `;
                    let listMM = `
                        <tr>
                            <td width="75%">
                                <p class="specString" data-string="${specString}">${$('.group_id').find('option:selected').text()}</p>
                                ${specDetailMM}
                                <p class="list_inventory_quantity" data-value="${$('select[name="inventory_quantity"]').val()}">數量：${$('select[name="inventory_quantity"]').val()}</p>
                            </td>
                            <td width="25%" class="relative">
                                <a class="remove-btn btn btn-plan radius" href="javascript: void(0);">
                                    移除
                                </a>
                            </td>
                        </tr>
                    `;
                    selectedRadix += parseInt($('select[name="inventory_quantity"]').val());
                    remainRadix = countRadix(selectedRadix, totalRadix);
                    countSelectableNum(quantity, specString); // 計算規格可選數量

                    // 如果 totalRadix != 0 且 remainRadix == 0，代表有應選商品數量且已經剛好選滿
                    formCheck = (totalRadix != 0 && remainRadix == 0) ? true : false;

                    tbody.append(list);
                    tbodyMM.append(listMM);

                    // 點擊移除按鈕
                    $('.remove-btn').off();
                    $('.remove-btn').on('click', function() {
                        let tbody = $('.list-table tbody');
                        let tbodyMM = $('.mm-list-table tbody')
                        let row = $(this).parent().parent(); // 叉叉按鈕的 <tr>
                        let index = ($('.list-table').find('tr').index(row) != -1)
                            ? $('.list-table').find('tr').index(row)
                            : $('.mm-list-table').find('tr').index(row)

                        selectedRadix -= parseInt(row.find('.list_inventory_quantity').data('value'));
                        remainRadix = countRadix(selectedRadix, totalRadix);
                        let specString = row.find('.specString').data('string');
                        quantity[specString].selectedNo -= parseInt(row.find('.list_inventory_quantity').data('value'));

                        $('.input_css').each(function() {
                            $(this).trigger('change');
                        })

                        tbody.find('tr').eq(index).remove();
                        tbodyMM.find('tr').eq(index).remove();
                        // 如果 totalRadix != 0 且 remainRadix == 0，代表有應選商品數量且已經剛好選滿
                        formCheck = (totalRadix != 0 && remainRadix == 0) ? true : false;
                    })
                })
            }




            $('.formCheck').on('click', function() {

                if (!formCheck) {
                    if (buy_number  == 0) {
                        alert('您尚未選擇數量，請重新選擇數量。');
                        return false;
                    }
                    alert(`數量錯誤，選擇數量總和應等於 ${totalRadix}，目前為 ${selectedRadix}`);
                    return false;
                }

                selectedRadix = ($('#inventoryCheck').val() != 0) ? selectedRadix : totalRadix;
                if (totalRadix != selectedRadix || selectedRadix == 0) {
                    alert(`數量錯誤，選擇數量總和應等於 ${totalRadix}，目前為 ${selectedRadix}`);
                    return false;
                }

                $('select[name="inventory_quantity"]').each(function() {
                    // 數量仍然為「請選擇」的行清除掉
                    if ($(this).val() == 0) {
                        $(this).parent().parent().remove();
                    }
                })

                let jsonAry = new Array;
                // 選擇方案 sp_id
                jsonAry.push({
                    name: 'sp_id',
                    value: sp_id
                });

                // 方案數量 buy_number
                jsonAry.push({
                    name: 'buy_number',
                    value: buy_number
                });

                // 詳細規格 punit
                $('.list_punit').each(function() {
                    jsonAry.push({
                        name: $(this).data('punit'),
                        value: `${$(this).data('value')}`
                    })
                })

                // 該規格數量 inventory_quantity
                $('.list_inventory_quantity').each(function() {
                    jsonAry.push({
                        name: 'inventory_quantity',
                        value: `${$(this).data('value')}`
                    })
                })

                // 該規格id inventory_id
                $('.list_inventory_ids').each(function() {
                    jsonAry.push({
                        name: 'inventory_ids',
                        value: `${$(this).val()}`
                    })
                })

                // 品項 group_id
                $('.list_group_id').each(function() {
                    jsonAry.push({
                        name: 'group_ids',
                        value: `${$(this).data('value')}`
                    })
                })

                const Obj = {};
                jsonAry.forEach((item) => (!Obj[item.name]) ? Obj[item.name] = [item.value] : Obj[item.name].push(item.value))
                $('#json').val(JSON.stringify(Obj));

                if (0 == preview) {
                    gaSend();
                }

                $('#sendForm').submit();
            })

            function gaSend ()
            {
                // Google追蹤使用(Google Tag Manager)
                ga('send', {
                    hitType: 'event',
                    eventCategory: 'Button',
                    eventAction: 'Click',
                    eventLabel: 'Web_purchase',
                    eventValue: '0'
                });
            }

            function selectChange(obj, groupId, alertCheck, quantity = []) {
                // 商品規格欄位有改變
                let row = $('.spec_td'); // 規格選擇那一行 <tr></tr>
                let specArray = []; // 每次點擊都把規格陣列先清空
                let stopCheck;
                // 如果上面方案數量尚未選擇，請使用者先選擇方案數量
                if (alertCheck && buy_number == 0) {
                    alert('請先選擇方案購買份數');
                    obj.find('option').eq(0).prop('selected', true);
                    $('#buy_number').addClass('form-control-error');
                    $('.no-empty').fadeIn();
                    return false;
                }

                // 如果點擊的是「數量」欄位，則不在這邊處理
                if( obj.attr('name') == 'inventory_quantity' ){
                    return false;
                }

                // 如果有紅框，選擇後且不為零，則取消紅框
                if (obj.val() != 0 && obj.hasClass('form-control-error')) {
                    obj.removeClass('form-control-error')
                }

                // 把本行規格欄位跑一遍，如果有規格的欄位仍然處於「請選擇 value="0"」則跳過
                row.find(`select[name="punit[${groupId}]"]`).each(function() {
                    if ($(this).val() == 0){
                        stopCheck = true;
                        row.find('select[name="inventory_quantity"]').html('<option value="0" selected>請選擇</option>');
                        $('select[name="inventory_quantity"]').eq(0).trigger('change');
                        return false;
                    } else {
                        stopCheck = false;
                    }
                    specArray.push($(this).val());
                })

                if (!stopCheck) {
                    specString = specArray.join(); // 點擊改變的這一行規格 ex:款式,顏色,尺寸
                    countSelectableNum(quantity, specString); // 計算規格可選數量
                }

                $('select[name="inventory_quantity"]').on('change', function() {
                    if ($(this).hasClass('form-control-error') && $(this).val() != 0) {
                        $(this).removeClass('form-control-error');
                    }
                })
            }

            function countSelectableNum(quantity, specString) {
                let row = $('.spec_td'); // 規格選擇那一行 <tr></tr>
                let quantity_option = 0; // 「數量」欄位下拉選單
                let remainNo =  quantity[specString] != undefined
                    ? parseInt(quantity[specString].maxNo) - parseInt(quantity[specString].selectedNo) // 規格剩餘可選數量
                    : 0;
                $('select[name="inventory_quantity"]').off();
                let inventory_quantity = remainNo != 0
                    ? `<option value="0" selected>請選擇</option>`
                    : `<option value="0" selected>已完售</option>`
                // 比對該規格可選數量以及應選數量
                if (quantity[specString] == undefined || quantity[specString].maxNo == 0) {
                    // 如果此規格沒庫存
                    quantity_option = totalRadix;
                    inventoryId = '';
                } else {
                    quantity_option = (totalRadix > remainNo) ? remainNo : totalRadix;
                    inventoryId = quantity[specString].inventoryId;
                }

                for (let i = 1; i <= quantity_option; i++) {
                    inventory_quantity += `<option value="${i}">${i}</option>`
                }
                row.find('select[name="inventory_quantity"]').html(inventory_quantity);
                row.find('input[name="inventory_ids"]').val(inventoryId);

                if (remainNo == 0) {
                    row.find('select[name="inventory_quantity"]').prop('disabled', true);
                } else {
                    row.find('select[name="inventory_quantity"]').prop('disabled', false);
                }
            }

            function countRadix(selectedRadix, totalRadix) {
                let remainRadix = (totalRadix - selectedRadix);
                if (remainRadix >= 0) {
                    $('.warning').text('').hide();
                    // 要繼續選商品
                    $('.remainRadix').text(remainRadix);
                    if (remainRadix != 0) {
                        $('.warning').text('未達商品總數，請繼續新增').fadeIn();
                    }
                    return remainRadix;
                }
                $('.remainRadix').text(remainRadix);
                return remainRadix;
            }
        })
    </script>
@endsection
