@extends('modules.common')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/assets/bootstrap/5.1.1/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/fix-bootstrap.css') }}">
@endsection

@section('content')
    <div class="announement-wrapper">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-9 col-md-11 col-sm-12">
                    <h1 class="theme-header text-center t-white mb-5">宅配購物+ 終止服務公告</h1>
                    <div class="announementBox border rounded bg-white">
                        <p><i class="i-announement"></i></p>
                        <h2 class="text-center fs-4 mb-4">親愛的麻吉您好：</h2>
                        <p class="t-11 lh-lg mb-3">感謝您對 GOMAJI 及「宅配購物+頻道」一直以來的支持，由 GOMAJI 與生活市集合作之「宅配購物+頻道」將於 2023/03/31 23:59 停止頻道導購入口，相關「宅配購物+」已成立訂單，GOMAJI 客服中心將協助服務至 2023/04/30 止。</p>
                        <p></p>
                        <p class="t-11 mb-1">自 2023/05/01 起，訂單及相關售後服務敬請直接與生活市集客服聯繫，如造成您的不便，敬請見諒。</p>
                        <div class="announement-info">
                            <p class="t-11 lh-lg">生活市集客服聯繫方式：<br>線上客服：<a href="https://help.buy123.com.tw/zh-TW/articles/4297289-%E5%A6%82%E4%BD%95%E8%81%AF%E7%B9%AB%E5%AE%A2%E6%9C%8D" target="_blank">操作說明</a> 進入客服中心 → 點擊畫面右下角的[橘色圓形(我要發問)]，連線線上客服 (平日/假日：09:30-18:30)
                            <br>客服專線：02-5575-1810 (平日 09:30-18:30)
                            </p>
                        </div>
                        <p class="text-center lh-lg fs-4 t-main import">GOMAJI 所經營的 <a class="shop relative" href="{{ $shopifyUrl }}" target="_blank"><i class="sh-icon"></i>宅配嚴選頻道<i class="angle-right"><img src="{{ url('/images/angle-right.png') }}"></i></a> 將持續提供優質完善的宅配服務，給您更貼近需求的美好購物體驗。</p>
                        <p class="text-center lh-lg fs-4 t-main mm-import">GOMAJI 所經營的<br> <a class="shop relative" href="{{ $shopifyUrl }}" target="_blank"><i class="sh-icon"></i>宅配嚴選頻道<i class="angle-right"><img src="{{ url('/images/angle-right.png') }}"></i></a> 將持續提供優質完善的宅配服務，給您更貼近需求的美好購物體驗。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('/js/assets/bootstrap/5.1.1/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/assets/bootstrap/5.1.1/bootstrap.min.js') }}"></script>
@endsection
