@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">投資人管理專區</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">投資人管理專區</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                    <div class="row no-gutters help-faq-wrapper">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="sticky-top">
                                <div id="faq" class="list-group faq stakeholder">
                                    <a class="list-group-item list-group-item-action active" href="#pip-1">公司投資人管理專區介紹</a>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="heading01">
                                                <h3>
                                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                                        公司概況
                                                    </button>
                                                </h3>
                                            </div>
                                            <div id="collapse-1" class="collapse" aria-labelledby="heading01">
                                                <div class="card-body">
                                                    <a class="list-group-item list-group-item-action" href="#pip-2">基本資料</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-3">產品介紹</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-4">公司沿革</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-5">組織架構</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-6">經營團隊</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="heading02">
                                                <h3>
                                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-1">
                                                        公司治理
                                                    </button>
                                                </h3>
                                            </div>
                                            <div id="collapse-2" class="collapse" aria-labelledby="heading02">
                                                <div class="card-body">
                                                    <a class="list-group-item list-group-item-action" href="#pip-7">公司規章</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-8">董事長成員</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-21">董事會成員多元化政策</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-22">董事會成員及重要管理階層之接班規劃</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-24">董事會績效評估</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-9">董事會決議事項</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-10">獨立董事選任資訊</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-11">功能性委員會</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-23">獨立董事與內部稽核主管及會計師之溝通情形</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-12">內部稽核之組織與運作</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-25">不合法或不道德行為檢舉制度</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-26">防範內線交易</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-27">風險管理</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="heading03">
                                                <h3>
                                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-1">
                                                        企業社會責任
                                                    </button>
                                                </h3>
                                            </div>
                                            <div id="collapse-3" class="collapse" aria-labelledby="heading03">
                                                <div class="card-body">
                                                    <a class="list-group-item list-group-item-action" href="#pip-13">運作情形</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-14">員工關懷</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="list-group-item list-group-item-action" href="#pip-15">財務資訊-公司財務報表</a>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="heading04">
                                                <h3>
                                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-1">
                                                        股東資訊
                                                    </button>
                                                </h3>
                                            </div>
                                            <div id="collapse-4" class="collapse" aria-labelledby="heading04">
                                                <div class="card-body">
                                                    <a class="list-group-item list-group-item-action" href="#pip-16">股利資訊</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-17">股東會和股價等資訊</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-18">法說會</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-19">股務代理機構</a>
                                                    <a class="list-group-item list-group-item-action" href="#pip-20">主要股東</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="help-faq-content stakeholderTerm">
                                <!-- 公司投資人管理專區介紹 -->
                                @include('about.stakeholder.pip1')
                                <!-- 公司概況 - 基本資料 -->
                                @include('about.stakeholder.pip2')
                                <!-- 公司概況 - 產品介紹 -->
                                @include('about.stakeholder.pip3')
                                <!-- 公司概況 - 公司沿革 -->
                                @include('about.stakeholder.pip4')
                                <!-- 公司概況 - 組織架構 -->
                                @include('about.stakeholder.pip5')
                                <!-- 公司概況 - 經營團隊 -->
                                @include('about.stakeholder.pip6')
                                <!-- 公司治理 - 公司規章 -->
                                @include('about.stakeholder.pip7')
                                <!-- 公司治理 - 董事會成員 -->
                                @include('about.stakeholder.pip8')
                                <!-- 公司治理 - 董事會成員多元化政策 -->
                                @include('about.stakeholder.pip21')
                                <!-- 公司治理 - 董事會成員及重要管理階層之接班規劃 -->
                                @include('about.stakeholder.pip22')
                                <!-- 公司治理 - 董事會績效評估 -->
                                @include('about.stakeholder.pip24')
                                <!-- 公司治理 - 董事會決議事項 -->
                                @include('about.stakeholder.pip9')
                                <!-- 公司治理 - 獨立董事選任資訊 -->
                                @include('about.stakeholder.pip10')
                                <!-- 公司治理 - 功能性委員會 -->
                                @include('about.stakeholder.pip11')
                                <!-- 公司治理 - 獨立董事與內部稽核主管及會計師之溝通情形 -->
                                @include('about.stakeholder.pip23')
                                <!-- 公司治理 - 內部稽核之組織與運作 -->
                                @include('about.stakeholder.pip12')
                                <!-- 公司治理 - 不合法或不道德行為檢舉制度 -->
                                @include('about.stakeholder.pip25')
                                <!-- 公司治理 - 防範內線交易 -->
                                @include('about.stakeholder.pip26')
                                <!-- 公司治理 - 風險管理 -->
                                @include('about.stakeholder.pip27')
                                <!-- 企業社會責任 - 運作情形 -->
                                @include('about.stakeholder.pip13')
                                <!-- 企業社會責任 - 員工關懷 -->
                                @include('about.stakeholder.pip14')
                                <!-- 財務資訊 - 公司財務報表 -->
                                @include('about.stakeholder.pip15')
                                <!-- 股東資訊 - 股利資訊 -->
                                @include('about.stakeholder.pip16')
                                <!-- 股東資訊 - 股東會和股價等資訊 -->
                                @include('about.stakeholder.pip17')
                                <!-- 股東資訊 - 法說會 -->
                                @include('about.stakeholder.pip18')
                                <!-- 股東資訊 - 股務代理機構 -->
                                @include('about.stakeholder.pip19')
                                <!-- 股東資訊 - 主要股東 -->
                                @include('about.stakeholder.pip20')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script>
        // 滾動監控
        $('body').scrollspy({ target: '#faq' })
        $(document).ready(function () {
            $("#faq").sticky({ topSpacing: 0 });
            $(window).scrollTop(0);
        });
    </script>
@endsection
