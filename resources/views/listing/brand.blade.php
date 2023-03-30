@extends('modules.common')

@section('content')
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            @if (empty($breadcrumb['subTitle']))
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] ?? '' }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] ?? '' }}">{{ $breadcrumb['title'] ?? '' }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['subTitle'] ?? '' }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header">{{ $title ?? '' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- 品牌飯店＆餐廳列表 -->
    <main class="main">
        <div class="channel-sectionBox">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 padding-02">
                        @if (!empty($tabList))
                            <div class="product-menu theme-menu">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($tabList as $tabKey => $tabValue)
                                        <li class="nav-item @if ($tabKey == 0) active @endif">
                                            <a class="nav-link" href="#brands_0{{ $tabKey + 1 }}" role="button" aria-haspopup="true">{{ $tabValue }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($brandList))
                            @foreach ($brandList as $brandKey => $brand)
                                <div id="brands_0{{ $brandKey + 1 }}" class="brandsBox brands-0{{ $brandKey + 1 }}">
                                    <h2 class="t-main">{{ $tabList[$brandKey] ?? '' }}</h2>
                                    <ul class="d-flex align-content-start flex-wrap">
                                        @foreach ($brand as $value)
                                            <li class="item">
                                                <a href="{{ url($brandLink . '/' . ($value['pa_id'] ?? 0) . '?type=' . ($value['brand_type'] ?? '')) }}">
                                                    <img class="img-fluid border border-r" src="{{ $value['small_icon'] ?? '' }}" alt="{{ $value['title'] ?? '' }}">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End:星級飯店品牌 -->
    </main>
@endsection

@section('script')
    <script type="text/javascript">
    // 點擊tab滑動至品牌or餐廳區塊
    $('.nav-link').on('click', function()
    {
        const target = $(this).attr('href'); // 標記欲前往的目標
        if (location.pathname.endsWith('brand')) {
            $('html,body').animate({
                scrollTop: $(target).offset().top - 70
            }, 1000);
            $('.nav-item').removeClass('active'); // 移除所有.nav-item的active class
            $(this).parent().addClass('active'); // 點擊目標父層增加active class
        }
    })
    </script>
    <!-- == END: jQuery ==-->
@endsection
