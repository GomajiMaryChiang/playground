@extends('modules.common')

@section('content')
    <!-- 檔次頁 -->
    <div class="mm-product-purchase-wrap">
        <div class="flag d-flex justify-content-center">
            @if ($product['order_no'] > 10 && $product['display_flag'] == 1)
                <!-- 公益 -->
                @if ($product['city_id'] == Config::get('city.baseCityList.publicWelfare'))
                    <p class="t-main t-09">{{ $product['order_no'] }}份專案捐款</p>
                @else
                    <p class="t-main t-09">已銷售{{ $product['order_no'] }}份</p>
                @endif
            @elseif ($product['display_flag'] == 2)
                <p class="t-main t-09">剩{{ $product['remain_no'] }}份</p>
            @endif

            @if (!empty($product['untilTs']) && $preview != 1)
                <!-- 橘色的倒數時間 -->
                <div class="tagBox tagBox-org" id="untilTsOrange">
                    <div class="label-icon i-clock-org">
                        <span class="t-09 t-main until-ts" data-untilts="{{ $product['untilTs'] }}"></span>
                    </div>
                </div>
                <!-- 黃色的倒數時間 -->
                <div class="tagBox tagBox-yellow" id="untilTsYellow" style="display: none;">
                    <div class="label-icon i-clock-yellow ml-1">
                        <span class="t-085 t-yellow until-ts" data-untilts="{{ $product['untilTs'] }}"></span>
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex purchase">
            <div class="flex-fill">
                @if (!empty($resDetail['html_purchaseBox_mm']))
                    {!! $resDetail['html_purchaseBox_mm'] !!}
                @endif
            </div>
            @if (!in_array($ref, Config::get('ref.id')))
                <div class="flex-fill">
                    <a class="btn btn-danger openapp" onclick="handleOpenApp();" href="javascript:void(0);" role="button">
                        ${{ $product['price'] }}
                        @if (!empty($product['sub_products']) && count($product['sub_products']) > 0)
                            <span>起</span>
                        @endif
                        開APP購買<br><span>首次賺$100、限定贈點</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- End:mm 馬上購買區塊 -->
    @if ($product['order_status'] == 'END' && $preview != 1)
        <div class="mm-product-endRecommend-wrap">
            <div class="endRecommendBox">
                <div class="expand" onclick="$('.endRecommend').toggle();">
                    <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMzc1cHgiIGhlaWdodD0iNTZweCIgdmlld0JveD0iMCAwIDM3NSA1NiIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4KICAgIDx0aXRsZT7llYblk4HmjqjolqZCYXI8L3RpdGxlPgogICAgPGcgaWQ9IkNoYW5uZWzpoLvpgZMrUHJvZHVjdOWVhuWTgemggemdoiIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPGcgaWQ9IlJT5ZWG5ZOB6aCB6Z2iLeWujOWUrijmjqjolqYpIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxLjAwMDAwMCwgLTM1My4wMDAwMDApIj4KICAgICAgICAgICAgPGcgaWQ9IuWVhuWTgeaOqOiWpkJhciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEuMDAwMDAwLCAzNTMuMDAwMDAwKSI+CiAgICAgICAgICAgICAgICA8ZyBpZD0iZHJhcGJhci11cCIgZmlsbD0iI0ZGODgwMCI+CiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTIwNi42NDA0MSwwIEMyMDcuNTMwNDY5LDEuNjEyODU1NjVlLTE1IDIwOC4zMTM0MjYsMC41ODgxODQwNzggMjA4LjU2MTI5MiwxLjQ0MzAzMzMyIEwyMTIuNzgyLDE2IEwzNzUsMTYgTDM3NSw1NiBMMCw1NiBMMCwxNiBMMTY4LjIxNiwxNiBMMTcyLjQzODE2MiwxLjQ0MzAzMzMyIEMxNzIuNjg2MDI4LDAuNTg4MTg0MDc4IDE3My40Njg5ODUsMS4wNTE2Nzk2MWUtMTUgMTc0LjM1OTA0NCwwIEwyMDYuNjQwNDEsMCBaIiBpZD0iQ29tYmluZWQtU2hhcGUiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDwvZz4KICAgICAgICAgICAgICAgIDxwb2x5Z29uIGlkPSJwcm9kdWN0X2dyYXlfYXJyb3dfZG93biIgZmlsbD0iI0ZGRkZGRiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTg5LjAwMDAwMCwgMTEuNTAwMDAwKSByb3RhdGUoOTAuMDAwMDAwKSB0cmFuc2xhdGUoLTE4OS4wMDAwMDAsIC0xMS41MDAwMDApICIgcG9pbnRzPSIxODUgNi41IDE4Ni41IDUgMTkzIDExLjUgMTg2LjUgMTggMTg1IDE2LjUgMTkwIDExLjUiPjwvcG9seWdvbj4KICAgICAgICAgICAgPC9nPgogICAgICAgIDwvZz4KICAgIDwvZz4KPC9zdmc+"
                        alt="商品已售完，推薦您相關好康！">
                    <h3 class="title">商品已售完，推薦您相關好康！</h3>
                </div>
                <div class="endRecommend bg-white">
                    <p class="text-center">感謝麻吉們熱烈搶購，已全數賣光光嘍！<br>填寫 E-mail，如有加碼或再次上架，我們會發信通知您喔！</p>
                    <div class="input-group no-border mt-2">
                        <input id="sold-out-mail-mm" type="text" value="" class="form-control" placeholder="請輸入您的E-mail ...">
                        <button class="input-group-text mm-input-group t-white" type="button" id="sold-out-btn-mm" data-fancybox data-src="#soldout-popup">
                            送出
                        </button>
                        <!--完售通知條件-->

                    </div>
                    <div class="product-recommend">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 padding-02">
                                    <div class="endRecommend-carouel owl-carousel owl-theme">
                                        @if (!empty($product['hot_products']))
                                            @foreach ($product['hot_products'] as $hot_product)
                                                <div class="item">
                                                    <div class="product-card mm-product-card border border-r bg-white">
                                                        <a href="{{ $hot_product['link'] }}">
                                                            <div class="product-img relative">
                                                                <img class="img-fluid lazyload" title="{{ $hot_product['group_name'] }}" data-original="{{ $hot_product['img'] }}"
                                                                    alt="{{ $hot_product['group_name'] }}">
                                                            </div>
                                                            <div class="product-detail">
                                                                <h3 class="ellipsis">{{ $hot_product['group_name'] }}</h3>
                                                            </div>
                                                            <div class="product-price d-flex">
                                                                <div class="price-card d-flex ml-auto">
                                                                    <div class="original line-through ml-auto t-gray">
                                                                        ${{ $hot_product['org_price'] }}
                                                                    </div>
                                                                    <div class="current t-danger">
                                                                        ${{ $hot_product['price'] }}

                                                                        @if (!empty($hot_product['sp_flag']))
                                                                            <span>起</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- 手機 mm 上會出現 -->
                                                            @if ($hot_product['order_no'] > 10 && $hot_product['display_flag'] == 1)
                                                                <div class="mm-sell t-main t-085">售{{ $hot_product['order_no'] }}份</div>
                                                            @elseif ($hot_product['display_flag'] == 2)
                                                                <div class="mm-sell t-main t-085">剩{{ $hot_product['remain_no'] }}份</div>
                                                            @endif
                                                            <!-- End:手機 mm 上會出現 -->
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End:推薦更多商品 -->
                </div>
            </div>
            <div class="flag d-flex justify-content-center">
                <p class="t-main t-09">已銷售{{ $product['order_no'] }}份</p>
            </div>
            <div class="d-flex purchase">
                <div class="flex-fill">
                    <a class="btn btn-gray" role="button">
                        搶購一空
                    </a>
                </div>
            </div>
        </div>
        <!-- End:mm 馬上購買區塊(搶購一空) -->
    @endif
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ $resDetail['sub_link'] }}">{{ $resDetail['sub_name'] }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ $resDetail['sub_child_link'] }}">{{ $resDetail['sub_child_name'] }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $resDetail['sub_child_name_detail'] }}</li>
                        </ol>
                    </nav>
                </div>
                <!-- End:breadcrumb -->
                @if (!$isShowMmBanner && !empty($product['banners']) && count($product['banners']) > 0 )
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="first-cover carousel-product-ad owl-carousel owl-loaded owl-drag mb-3">
                            @foreach ($product['banners'] as $banner)
                                <div class="item">
                                    <a href="{{ $banner['link_url'] }}"><img class="img-fluid" src="{{ $banner['img'] }}" alt="{{ $banner['subject'] }}"></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <!-- End:product-head廣告 -->
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    @if ($product['order_status'] == 'END' && $preview == 0)
        <div class="soldout-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-5">
                        <div class="product-img relative">
                            <img class="img-fluid lazyload" title="{{ $product['store_name'] ?? '' }}" data-original="{{ $product['img'][0] ?? '' }}" alt="{{ $product['store_name'] ?? '' }}">
                            <div class="sold-out-label">
                                <img class="d-block w-100 lazyload" data-original="{{ url('images/snapped_label.png') }}" alt="搶購一空">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-7">
                        <div class="soldout">
                            <h3>【{{ $product['store_name'] }}】感謝麻吉們熱烈搶購，已全數賣光光。</h3>
                            <p>感謝麻吉們熱烈搶購，已全數賣光光嘍！請填寫 E-mail 如有加碼或再次上架，我們會發信通知您喔！</p>
                            <div class="input-group soldout-input w-50">
                                <input type="text" id="sold-out-mail" class="form-control" placeholder="輸入您的E-mail" aria-label="輸入您的E-mail">
                                <button class="btn btn-main" type="button" id="sold-out-btn" data-fancybox data-src="#soldout-popup">送出</button>
                            </div>
                            <!--完售通知條件-->
                            @if ($product['order_no'] < $product['max_order_no'])
                                <input type="hidden" name="soldout_type" id="soldout_type" value="1"/>
                            @else
                                <input type="hidden" name="soldout_type" id="soldout_type" value="2"/>
                            @endif
                            <p><a class="app-download" href="{{ url('app') }}" target="_block">下載 APP，輸入優惠碼 "GOMAJI" 即可獲得$100點數！</a></p>
                        </div>
                    </div>
                    <!-- 完售 soldout-popup-->
                        <div style="display: none;" id="soldout-popup" class="popupBox popupBox-400">
                            <h2 data-selectable="true" class="t-11 mb-2"><span class="t-song">感謝您</h2>
                            <p data-selectable="true" class="text-center" id="soldout-message">
                            </p>
                        </div>
                    <!-- End:soldout-popup -->
                    <div class="col-md-12">
                        <div class="hot-recommendBox">
                            <h3 class="title"><i class="sectionhead-icon i-flash-sale"></i>熱銷推薦</h3>
                            <div class="hot-recommend-carouel owl-carousel owl-theme">
                                @if (!empty($product['hot_products']))
                                    @foreach ($product['hot_products'] as $hot_product)
                                        <div class="item">
                                            <div class="product-card mm-product-card border border-r bg-white">
                                                <a href="{{ $hot_product['link'] }}">
                                                    <div class="product-img relative">
                                                        <img class="img-fluid lazyload" title="{{ $hot_product['group_name'] }}" data-original="{{ $hot_product['img'] }}"
                                                            alt="{{ $hot_product['group_name'] }}">
                                                    </div>
                                                    <div class="product-detail">
                                                        <h3 class="ellipsis">{{ $hot_product['group_name'] }}</h3>
                                                    </div>
                                                    <div class="product-price d-flex">
                                                        @if ($hot_product['order_no'] > 10 && $hot_product['display_flag'] == 1)
                                                            <div class="sell t-main t-085">售{{ $hot_product['order_no'] }}份</div>
                                                        @elseif ($hot_product['display_flag'] == 2)
                                                            <div class="sell t-main t-085">剩{{ $hot_product['remain_no'] }}份</div>
                                                        @endif
                                                        <div class="price-card d-flex ml-auto">
                                                            <div class="original line-through ml-auto t-gray">
                                                                ${{ $hot_product['org_price'] }}
                                                            </div>
                                                            <div class="current t-danger">
                                                                ${{ $hot_product['price'] }}

                                                                @if (!empty($hot_product['sp_flag']))
                                                                    <span>起</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 手機 mm 上會出現 -->
                                                    @if ($hot_product['order_no'] > 10 && $hot_product['display_flag'] == 1)
                                                        <div class="mm-sell t-main t-085">售{{ $hot_product['order_no'] }}份</div>
                                                    @elseif ($hot_product['display_flag'] == 2)
                                                        <div class="mm-sell t-main t-085">剩{{ $hot_product['remain_no'] }}份</div>
                                                    @endif
                                                    <!-- End:手機 mm 上會出現 -->
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- End:熱銷推薦 -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End:soldout-wrap搶購一空 -->
    @endif
    <main class="main">
        <!-- 檔次內容 -->
        <div class="sectionBox product-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 padding-0">
                        <div class="product-content-warp">
                            <div class="product-content-head relative">
                                <h1>@if (!empty($preview))<span style='font-weight: 900; color:red'>{預覽}</span> @endif{{ $product['store_name'] }}</h1>
                                <div class="d-flex">
                                    @if ($product['city_id'] != Config::get('city.baseCityList.publicWelfare'))
                                        @if ($product['product_kind'] != Config::get('product.kindId.coffee'))
                                            <div class="label-smile i-smile-{{ $product['smile_class'] }} font-weight-bold">
                                                <span class="t-10 number t-main">{!! $product['store_rating_score'] !!}</span>
                                                <span class="t-085 t-main total">
                                                    &nbsp;({{ $product['store_rating_people'] }})
                                                </span>
                                            </div>
                                        @endif
                                        @if (!empty($product['group_promo']))
                                            <div class="label-icon i-point mt-2 ml-2">
                                                <span class="t-085 t-darkdanger">{{ $product['group_promo'] }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="product-imgBox relative">
                                <div class="location-tag d-flex">
                                    @if ($product['extra_labels'] == '紙本票券寄送')
                                        <div class="i-coupon ml-1">
                                            <span class="t-085 t-yellow">{{ $product['extra_labels'] }}</span>
                                        </div>
                                    @else
                                        @if ($product['city_id'] == 19)
                                            <div class="label-icon i-map">
                                                <span class="t-085 t-white">@lang('公益')</span>
                                            </div>
                                        @elseif ($product['spot_name'])
                                            <div class="label-icon {{ $resDetail['displayMap'] }}">
                                                <span class="t-085 t-white">{{ $product['spot_name'] }}</span>
                                            </div>
                                        @endif
                                        <div class="i-coupon ml-1">
                                            <span class="t-085 t-yellow">{{ $product['extra_labels'] }}</span>
                                        </div>
                                    @endif
                                </div>
                                <!-- mm的現有空tag -->
                                @if ($resDetail['availableType'] == 'show')
                                    <div class="mm-product-available">
                                        <a data-fancybox="" data-src="#available-info" href="javascript:;" class="btn tag tag-available i-greenquesion">現有空</a>
                                    </div>
                                @endif

                                <!-- mm banner -->
                                @if ($isShowMmBanner && !empty($product['banners']))
                                    <div class="sectionBox linebanner">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12 section-stage padding-00">
                                                    <div class="line-special-carouel owl-carousel owl-theme">
                                                        @foreach ($product['banners'] as $banner)
                                                            <div class="item">
                                                                <a href="{{ $banner['link_url'] ?? '#' }}"><img class="img-fluid border border-r" src="{{ $banner['img'] ?? '' }}" alt="{{ $banner['subject'] ?? '' }}"></a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- End: mm banner -->

                                <div class="first-cover product-carousel owl-carousel owl-loaded owl-drag">
                                    @foreach ($product['img'] as $img)
                                        <div class="item">
                                            <img class="img-fluid" src="{{ $img }}" alt="{{ $product['display_store_name'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End:product images -->
                            <!-- mm手機上 title head商家名 -->
                            <div class="mm-product-content-head">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/">首頁</a></li>
                                        <li class="breadcrumb-item"><a href="{{ $resDetail['sub_link'] }}">{{ $resDetail['sub_name'] }}</a></li>
                                        <li class="breadcrumb-item"><a href="{{ $resDetail['sub_child_link'] }}">{{ $resDetail['sub_child_name'] }}</a></li>
                                    </ol>
                                </nav>
                                <h1>@if (!empty($preview))<span style='font-weight: 900; color:red'>{預覽}</span> @endif {{ $product['store_name'] }}</h1>
                                <div class="d-flex label">
                                    @if ($product['product_kind'] != Config::get('product.kindId.coffee'))
                                        <div class="label-smile i-smile-{{ $product['smile_class'] }} font-weight-bold">
                                            <span class="t-10 number t-main">{!! $product['store_rating_score'] !!}</span>
                                            <span class="t-085 t-main total">
                                                &nbsp;({{ $product['store_rating_people'] }})
                                            </span>
                                        </div>
                                    @endif
                                    @if (!empty($product['group_promo']))
                                        <div class="label-icon i-point ml-2">
                                            <span class="t-085 t-darkdanger">{{ $product['group_promo'] }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-price d-flex">
                                    <div class="shareBox">
                                        <ul>
                                            <li>
                                                <p class="t-09">分享</p>
                                            </li>
                                            <li>
                                                <div data-href="#" data-layout="button">
                                                    <a class="fb-xfbml-parse-ignore share" data-type="facebook" data-city="{{ $product['city_id'] }}" data-pid="{{ $product['product_id'] }}" title="Facebook 分享" data-product_name="{{ $product['product_name'] }}" href="#" onclick="return false;">
                                                        <i class="social-icon i-facebook"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="lineShare mmShare func-item line" title="Line">
                                                    <i class="social-icon i-line"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="copy-share" id="share-copy" data-fancybox data-src="#social-copy-popup" href="javascript:;" data-clipboard-text="" title="分享複製連結">
                                                    <i class="social-icon i-social-link"></i>
                                                </a>
                                                <input type="hidden" name="copy" id="copy" value="{{ $product['url'] }}">
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="price-card d-flex ml-auto">
                                        @if ($product['org_price'] != 0 && $product['city_id'] != Config::get('city.baseCityList.publicWelfare'))
                                            <div class="original line-through ml-auto t-gray">
                                                ${{ $product['org_price'] }}
                                            </div>
                                        @endif
                                        <div class="current t-danger mr-2">
                                            ${{ $product['price'] }}
                                            @if (!empty($product['sub_products']) && count($product['sub_products']) > 0)
                                                <span>起</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End:mm手機上 title head商家名 -->
                            <div class="product-share">
                                <div class="categoryBox float-left">
                                    @if (!empty($resDetail['tag']))
                                        @foreach ($resDetail['tag'] as $tag)
                                            <div class="list">
                                                <a href="{{ $tag['tag_link'] }}">{{ $tag['tag_name'] }}</a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="shareBox float-right">
                                    <ul>
                                        <li>
                                            <p class="t-09">分享</p>
                                        </li>
                                        <li>
                                            <div data-href="#" data-layout="button">
                                                <a class="fb-xfbml-parse-ignore share" data-type="facebook" data-city="{{ $product['city_id'] }}" data-pid="{{ $product['product_id'] }}" title="Facebook 分享" data-product_name="{{ $product['product_name'] }}" href="#" onclick="return false;">
                                                    <i class="social-icon i-facebook"></i>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" class="lineShare func-item line" title="Line" target="_blank" rel="noopener">
                                                <i class="social-icon i-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="copy-share" id="share-copy" data-fancybox data-src="#social-copy-popup" data-clipboard-text="" href="javascript:;" title="分享複製連結">
                                                <i class="social-icon i-social-link"></i>
                                            </a>
                                            <input type="hidden" name="copy" id="copy" value="{{ $product['url'] }}">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End:分類and分享 -->
                            <div class="product-detailBox">
                                <div class="product-menu sticky-top" style="{{ $resDetail['platform'] }} z-index: 995;">
                                    <ul class="nav nav-tabs nav-justified menubar" id="myNavbar" role="tablist">
                                        <!-- 公益內容 -->
                                        @if ($product['city_id'] == Config::get('city.baseCityList.publicWelfare'))
                                            <li class="nav-item active">
                                                <h2>
                                                    <a class="nav-link" href="#package" role="button" aria-haspopup="true">公益內容</a>
                                                </h2>
                                            </li>
                                            <li class="nav-item">
                                                <h2>
                                                    <a class="nav-link" href="#info" role="button" aria-haspopup="true">相關規定</a>
                                                </h2>
                                            </li>
                                        @else
                                            <!-- 咖啡檔次 -->
                                            @if ($product['product_kind'] == Config::get('product.kindId.coffee'))
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#package" role="button" aria-haspopup="true">方案內容</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#exchange" role="button" aria-haspopup="true">兌換說明</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#store" role="button" aria-haspopup="true">適用店家</a>
                                                    </h2>
                                                </li>
                                            @elseif (!empty($product['is_paper_ticket']))
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#info" role="button" aria-haspopup="true">方案內容</a>
                                                    </h2>
                                                </li>
                                                @if (!empty($product['ticket_use_rule']))
                                                    <li class="nav-item">
                                                        <h2>
                                                            <a class="nav-link" href="#rule" role="button" aria-haspopup="true">使用規則</a>
                                                        </h2>
                                                    </li>
                                                @endif
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#package" role="button" aria-haspopup="true">配送資訊</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#rate" role="button" aria-haspopup="true">評價
                                                            <span class="t-085 ml-1 t-gray" id='rating__ratingCount'>(0)</span>
                                                        </a>
                                                    </h2>
                                                </li>
                                            <!-- 宅配 -->
                                            @elseif ($product['ch_id'] == Config::get('channel.id.sh') && $product['is_paper_ticket'] == 0)
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#info" role="button" aria-haspopup="true">商品介紹</a>
                                                    </h2>
                                                </li>
                                                @if (!empty($product['ticket_use_rule']))
                                                    <li class="nav-item">
                                                        <h2>
                                                            <a class="nav-link" href="#rule" role="button" aria-haspopup="true">商品規格</a>
                                                        </h2>
                                                    </li>
                                                @endif
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#package" role="button" aria-haspopup="true">宅配資訊</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#rate" role="button" aria-haspopup="true">
                                                            評價<span class="t-085 ml-1 t-gray" id='rating__ratingCount'>(0)</span>
                                                        </a>
                                                    </h2>
                                                </li>
                                            @else
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#info" role="button" aria-haspopup="true">兌換說明</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#package" role="button" aria-haspopup="true">方案內容</a>
                                                    </h2>
                                                </li>
                                                <li class="nav-item">
                                                    <h2>
                                                        <a class="nav-link" href="#store" role="button" aria-haspopup="true">適用店家</a>
                                                    </h2>
                                                </li>
                                                @if ($product['ch_id'] != Config::get('channel.id.lf'))
                                                    <li class="nav-item">
                                                        <h2>
                                                            <a class="nav-link" href="#rate" role="button" aria-haspopup="true">
                                                                評價<span class="t-085 ml-1 t-gray" id='rating__ratingCount'>(0)</span>
                                                            </a>
                                                        </h2>
                                                    </li>
                                                @endif
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                                @if ($product['city_id'] == Config::get('city.baseCityList.publicWelfare'))
                                    <h3 class="t-plan mb-3">{{ $product['product_name'] }}</h3>
                                @else
                                    <div id="info" class="contentBox menu-01">
                                        <div class="tagBox product-tag d-flex flex-wrap mb-2">
                                            @if (!empty($resDetail['bitwise']))
                                                <div class="tag-square" style="color:#FF8800;border: 1px solid #FF8800;">
                                                    即買即用
                                                </div>
                                            @endif

                                            @if ($product['order_no'] >= 10000)
                                                <div class="tag-square" style="color:#FF5D00; border: 1px solid #FF5D00;">
                                                    破萬銷售
                                                </div>
                                            @elseif ($product['order_no'] >= 1000)
                                                <div class="tag" style="color:#FF8800;border: 1px solid #FF8800;">
                                                    破千
                                                </div>
                                            @endif

                                            @foreach ($product['sale_flag'] as $sf)
                                                @if ($sf['title'] == '限時')
                                                    <div class="tag" style="color:#6F9EE2;border: 1px solid #6F9EE2;">
                                                        {{ $sf['title'] }}
                                                    </div>
                                                @elseif ($sf['title'] == '品牌')
                                                    <div class="tag" style="color:#F8846F;border: 1px solid #F8846F;">
                                                        {{ $sf['title'] }}
                                                    </div>
                                                @else
                                                    <div class="tag" style="border: 1px solid {{ $sf['color'] }};color: {{ $sf['color'] }};">
                                                        {{ $sf['title'] }}
                                                    </div>
                                                @endif
                                            @endforeach

                                            @if ($product['is_general_product'] == 1)
                                                <div class="tag" style="color:#6B72F0;border: 1px solid #6B72F0;">
                                                    跨店適用
                                                </div>
                                            @endif
                                        </div>

                                        <h3 class="t-plan mb-3">
                                            @if (isset($product['discount']) && $product['discount'] > 0 && $product['discount'] < 10)
                                                <div class="i-bubble mr-1">
                                                    <span class="t-08 t-white">
                                                        {{ $product['discount'] }}折
                                                    </span>
                                                </div>
                                            @endif
                                            {{ $product['product_name'] }}
                                        </h3>

                                    </div>
                                @endif
                                <!-- End:menu-content-1 -->

                                <!-- 公益內容 -->
                                @if ($product['city_id'] == Config::get('city.baseCityList.publicWelfare'))
                                    <div id="info" class="contentBox menu-02 relative">
                                        <div class="content-detail">
                                            <h4>
                                                <i class="icon i-info mr-1"></i>
                                                相關規定
                                            </h4>

                                            <div class="exchange-info">
                                                <ul>
                                                    @foreach ($product['fine_print'] as $fp)
                                                        {!! $fp !!}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-detail" id="package">
                                        <h4>
                                            <i class="icon i-package mr-1"></i>
                                            方案介紹
                                        </h4>

                                        @if (is_string($product['product_intro']))
                                            {!! $product['product_intro'] !!}
                                        @endif
                                    </div>
                                @else
                                    <!-- (LF or ES)的紙本 改變順序規則 -->
                                    @if (!empty($product['is_paper_ticket']) || ($product['is_paper_ticket'] == 0 && $product['ch_id'] == Config::get('channel.id.sh')))
                                        <div class="content-detail" id="info">
                                            <h4>
                                                <i class="icon i-package mr-1"></i>
                                                商品介紹
                                            </h4>

                                            @if (is_string($product['product_intro']))
                                                {!! $product['product_intro'] !!}
                                            @endif

                                            @if ($product['ch_id'] != Config::get('channel.id.sh'))
                                                <hr>
                                                <div class="exp">
                                                    <img class="w-100 lazyload" data-original="{{ url('/images/use_way.jpeg') }}" alt="吃喝玩樂券怎麼使用">
                                                </div>
                                            @endif
                                        </div>
                                        @if (!empty($product['ticket_use_rule']))
                                            <div id="rule" class="contentBox menu-02 relative">
                                                <div class="content-detail">
                                                    <h4>
                                                        <i class="icon i-productShopping mr-1"></i>
                                                        @if ($product['ch_id'] == Config::get('channel.id.sh') && $product['is_paper_ticket'] == 0)
                                                            商品規格
                                                        @else
                                                            使用規則
                                                        @endif
                                                    </h4>
                                                    <div class="exchange-info">
                                                        {!! $product['ticket_use_rule'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div id="package" class="contentBox menu-02 relative">
                                            <div class="content-detail">
                                                <h4>
                                                    <i class="icon i-info mr-2"></i>
                                                    @if ($product['ch_id'] == Config::get('channel.id.sh') && $product['is_paper_ticket'] == 0)
                                                        宅配資訊
                                                    @else
                                                        配送資訊
                                                    @endif
                                                </h4>
                                                @if (count($product['fine_print_labels']) > 0)
                                                    <div class="d-flex tagBox product-tag">
                                                        @foreach ($product['fine_print_labels'] as $label)
                                                            <div class="tag-square" style="color:#9B9B9B; border: 1px solid #9B9B9B;">
                                                                {{ $label }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <div class="exchange-info">
                                                    <ul>
                                                        {!! $product['product_description'] !!}
                                                    </ul>
                                                </div>

                                                @if (($product['ch_id'] == Config::get('channel.id.lf') || $resDetail['sub_channels_status'] == true) && $product['store_page_name'] != '海外票券' && $product['org_price'] != 0)
                                                    <a class="btn btn-outline-main rating-btn d-block" style="width: 40%;" href="{{ url('/store_highPrice/pid/' . $product['product_id']) }}" target="_blank">
                                                        價高通報
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div id="exchange" class="contentBox menu-02 relative">
                                            <div class="content-detail">
                                                <h4>
                                                    <i class="icon i-info mr-1"></i>
                                                    兌換說明
                                                </h4>
                                                @if (count($product['fine_print_labels']) > 0)
                                                    <div class="d-flex tagBox product-tag">
                                                        @foreach ($product['fine_print_labels'] as $label)
                                                            <div class="tag-square" style="color:#9B9B9B; border: 1px solid #9B9B9B;">
                                                                {{ $label }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <div class="exchange-info">
                                                    <ul>
                                                        @foreach ($product['fine_print'] as $fp)
                                                            {!! $fp !!}
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @if (($product['ch_id'] == Config::get('channel.id.es') || $resDetail['sub_channels_status'] == true) && $product['store_page_name'] != '海外票券' && $product['org_price'] != 0)
                                                    <a class="btn btn-outline-main rating-btn d-block" style="width: 40%;" href="{{ url('/store_highPrice/pid/' . $product['product_id']) }}" target="_blank">
                                                        價高通報
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End:exchange -->

                                        <div class="content-detail" id="package">
                                            <h4>
                                                <i class="icon i-package mr-1"></i>
                                                商品介紹
                                            </h4>

                                            @if (is_string($product['product_intro']))
                                                {!! $product['product_intro'] !!}
                                            @endif

                                            @if ($product['ch_id'] != Config::get('channel.id.sh'))
                                                <hr>
                                                <div class="exp">
                                                    <img class="w-100 lazyload" data-original="{{ url('/images/use_way.jpeg') }}" alt="吃喝玩樂券怎麼使用">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($product['is_paper_ticket'] == 0 && $product['ch_id'] != Config::get('channel.id.sh'))
                                        <div id="store" class="contentBox menu-03">
                                            <div class="content-detail">
                                                <h4>
                                                    <i class="icon i-productShopping mr-1"></i>
                                                    適用店家
                                                </h4>
                                                @foreach ($product['branch'] as $branch)
                                                    <div class="store ml-1">
                                                        <h3 class="t-11">{{ $branch['branch_name'] }}</h3>
                                                        @if (!empty($branch['is_rstogo_store']) && $branch['is_rstogo_store'] == 1)
                                                            <div class="tagBox">
                                                                <div class="tag" style="color:#FF8800;border: 1px solid #FF8800; display: inline-block;">
                                                                    訂餐外帶
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if (!empty($branch['branch_phone']))
                                                            <p>電話：{{ $branch['branch_phone'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['branch_address']))
                                                            <p>地址：{{ $branch['branch_address'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['branch_business_hours']))
                                                            <p>營業時間：{{ $branch['branch_business_hours'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['closed_statement']))
                                                            <p>公休：{{ $branch['closed_statement'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['last_order_time']))
                                                            <p>
                                                                @if($product['ch_id'] == Config::get('channel.id.rs'))
                                                                    最晚預約或點餐時間：
                                                                @else
                                                                    最後預約或服務時間：
                                                                @endif
                                                                {{ $branch['last_order_time'] }}
                                                            </p>
                                                        @endif

                                                        @if (!empty($branch['line_id']))
                                                            <p>LINE ID：{{ $branch['line_id'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['prohibits']))
                                                            <p>禁止事項：{{ $branch['prohibits'] }}</p>
                                                        @endif

                                                        @if (!empty($branch['website_link']))
                                                            <p>官網：<a class="t-orange" href="{{ $branch['website_link'] }}" target="_blank">{{ $branch['website_link'] }}</a></p>
                                                        @endif

                                                        @if (!empty($branch['facebook_url']))
                                                            <p>粉絲團：<a class="t-orange" href="{{ $branch['facebook_url'] }}" target="_blank">{{ $branch['facebook_url'] }}</a></p>
                                                        @endif

                                                        <div class="d-flex justify-content-start">
                                                            <!-- 非咖啡檔次 -->
                                                            @if ($product['product_kind'] != Config::get('product.kindId.coffee'))
                                                                <a data-fancybox data-src="#map-popup" href="javascript:;" class="btn btn-outline-gray w-30 mt-3 mb-4 mr-2 map-btn">
                                                                    <i class="icon i-map-red"></i>
                                                                    查看地圖
                                                                </a>
                                                                @if (!empty($branch['branch_phone']))
                                                                    <a href="tel:{{ $branch['branch_phone'] }}" class="btn btn-outline-gray w-30 mt-3 mb-4 mr-2 contact"><i class="icon i-cellphone"></i>聯絡店家</a>
                                                                @endif
                                                            @endif
                                                            @if (($product['ch_id'] == Config::get('channel.id.es') || $product['ch_id'] == Config::get('channel.id.bt')) && $product['store_page_name'] != '海外票券' && $product['org_price'] != 0)
                                                                <a href="{{ url('/store_violation/pid/' . $product['product_id'] . '?branch_id=' . $product['group_id']) }}" class="btn btn-outline-main w-30 mt-3 mb-4 mr-2" target="_blank">洗單通報</a>
                                                            @endif
                                                        </div>
                                                        <!-- for google map popup data -->
                                                        <input type="hidden" name="map-title" class="map-title" value="{{ $branch['branch_name'] }}">
                                                        <input type="hidden" name="map-address" class="map-address" value="{{ $branch['real_branch_address'] }}">
                                                        <input type="hidden" name="map-geo" class="map-geo" value="{{ $branch['lat'] }},{{ $branch['lng'] }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- End:store -->
                                    @endif

                                    @if (!empty($preview) && !empty($product['performance_bond']))
                                        <div class="tabs" id="trust-info">
                                            <h3 class="t-13 mb-3 relative">
                                                <i class="icon i-store mr-2"></i>信託履約
                                            </h3>
                                            <div class="applicable store">
                                                <div class="store mb-3">
                                                    @foreach ($product['performance_bond'] as $performance_bond)
                                                        <p>{{ $performance_bond}}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endif

                                    @if ($product['ch_id'] != Config::get('channel.id.lf') && $product['product_kind'] != Config::get('product.kindId.coffee'))
                                        <div id="rate" class="contentBox menu-04">
                                            <div class="content-detail {{ $resDetail['ratingList'] }}">
                                                <h4>
                                                    <i class="icon i-rate mr-1"></i>
                                                    評價
                                                </h4>
                                                <p class="text-center t-main" id="not-rating" style="display: none;">現在未有任何評價或評分資料不足喔！</p>
                                                <div class="ratingDashboard" id='rating__totalDashboard'></div>
                                                <div class="ratingListBox ml-1" id='rating__totalList'>
                                                    <div class="ratingList"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End:menu-content-4 -->
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- End:檔次內容 -->
                    </div>
                    <div class="col-lg-4">
                        <div class="sticky-top">
                            <div class="product-purchase-wrap">
                                <div class="product-purchase border border-r {{ $resDetail['productBoder'] }} relative">
                                    <div class="tagBox product">
                                        @if ($product['available_info']['enable'] == 1)
                                            <button type="button" class="btn tag-available tag i-greenquesion" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom"
                                                data-content="{{ $product['available_info']['description'] }}">
                                                {{ $product['available_info']['label'] }}
                                            </button>
                                        @endif
                                    </div>
                                    <h3 class="border-b">{{ $product['store_name'] }}</h3>
                                    <h4 class="t-plan">{{ $product['product_name'] }}</h4>
                                    <div class="product-price d-flex justify-content-end">
                                        @if ($resDetail['dataDiscount'] != 0)
                                            <div class="discount t-085 t-danger calc-discount" data-city="{{ $product['city_id'] }}" data-discount="{{ $resDetail['dataDiscount'] }}"></div>
                                        @endif
                                        <div class="price-card d-flex">
                                            @if ($product['org_price'] != 0 && $product['city_id'] != Config::get('city.baseCityList.publicWelfare'))
                                                <div class="original line-through ml-auto t-gray">
                                                    ${{ $product['org_price'] }}
                                                </div>
                                            @endif
                                            <div class="current t-danger">
                                                ${{ $product['price'] }}
                                                @if (count($product['sub_products']) > 0)
                                                    <span>起</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="purchase-btn text-center">
                                        @if ($preview != 1 && $product['order_status'] == 'END')
                                            <a class="btn btn-gray mb-2 disabled" href="#" role="button">
                                                搶購一空
                                            </a>
                                        @endif
                                        {!! $resDetail['html_purchaseBox'] !!}
                                    </div>

                                    <!-- 公益 -->
                                    @if ($product['city_id'] == Config::get('city.baseCityList.publicWelfare'))
                                        <div class="welfareBar mt-1 text-center">
                                            <p class="mb-1 t-09">捐款目標達成率<span class="t-danger ml-2" id="achievingRate"></span></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 25%" id="achievingRateBar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="t-085 t-gray mt-1">目前已有<span class="t-danger">{{ $es['achieveNum'] }}</span>份愛心響應</p>
                                            <hr>
                                        </div>
                                    @endif

                                    @if ($product['order_status'] == 'END' && $product['order_no'] > 10)
                                        <div class="d-flex justify-content-center">
                                            <p class="t-danger t-10">{{ $product['order_no'] }}份已販售</p>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center">
                                            @if ($product['order_no'] > 10 && $product['display_flag'] == 1)
                                                <p class="t-danger t-10">{{ $product['order_no'] }}份已販售</p>
                                            @elseif ($product['display_flag'] == 2)
                                                <p class="t-danger t-10">剩{{ $product['remain_no'] }}份</p>
                                            @endif
                                            @if ($product['tk_type'] == 1 && $product['order_status'] != 'END')
                                                <div class="label-icon i-clock-org ml-2 mt-1">
                                                    @if (!empty($product['untilTs']))
                                                        <span class="t-085 t-main until-ts" data-untilts="{{ $product['untilTs'] }}"></span>
                                                        <input type="hidden" name="tk-type" id="tk-type" value="{{ $product['tk_type'] }}">
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($product['is_coupon_discount'] != 1)
                                        <p class="text-center t-gray t-09">此商品已為特惠價，恕不適用促銷活動</p>
                                    @endif
                                </div>
                            </div>
                            <div class="appdownloand-banner border-r mt-3 p-1">
                                <a class="d-flex" href="{{ url('/app') }}" target="_blank">
                                    <span class="title">立刻下載 APP，輸入邀請碼<br> " GOMAJI " 即可獲得$100點！<br><span class="t-main">下載APP</span></span>
                                    <img class="lazyload" data-original="{{ url('/images/app-download-banner.png') }}">
                                </a>
                            </div>
                            @if ($product['ch_id'] == Config::get('channel.id.bt'))
                                <div class="beauty-booking-banner mt-2">
                                    <a href="{{ url('/app') }}" target="_blank">
                                        <img class="lazyload" data-original="{{ url('/images/beautyorder.png') }}">
                                    </a>
                                </div>
                            @endif
                            @if ($product['ch_id'] == Config::get('channel.id.sh')
                                && $product['category_id'] != Config::get('product.categoryId.ticket')
                                && $date >= '2023-01-02 00:00:00'
                                && $date <= '2023-01-29 23:59:59'
                            )
                                <div class="beauty-booking-banner mt-2">
                                    <a href="{{ url('/app') }}" target="_blank">
                                        <img class="lazyload" data-original="{{ url('/images/delivery_2023.jpg') }}">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:檔次內容-->
        @if (count($product['other_products']) > 0)
            <div class="sectionBox product-recommend bg-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 section-head relative padding-0">
                            <h2>更多 {{ $resDetail['more_product'] }}商品</h2>
                        </div>
                        <div class="col-md-12 section-stage padding-02">
                            <div class="more-product-carouel owl-carousel owl-theme">
                                @foreach ($product['other_products'] as $other)
                                    <div class="item">
                                        <div class="product-card mm-product-card border border-r bg-white">
                                            <a href="{{ url('/store/' . $product['store_id'] . '/pid/' . $other['product_id'] ) }}">
                                                <div class="product-img relative">
                                                    <img class="img-fluid lazyload" title="{{ $other['group_name'] }}" data-original="{{ $other['img'] }}"
                                                        alt="{{ $other['group_name'] }}">
                                                </div>
                                                <div class="product-detail">
                                                    <h3 class="ellipsis">{{ $other['app_sub_product_name'] }}</h3>
                                                </div>
                                                <div class="product-price d-flex">
                                                    <div class="sell t-main t-085">{{ $resDetail['more_product_sell'] }}</div>
                                                    <div class="price-card d-flex ml-auto">
                                                        @if ( $other['org_price'] != 0)
                                                            <div class="original line-through ml-auto t-gray">
                                                                ${{ $other['org_price'] }}
                                                            </div>
                                                        @endif
                                                        <div class="current t-danger">
                                                            ${{ $other['price'] }}
                                                            @if ($other['multi_price'] > 1)<span>起</span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- 手機 mm 上會出現 -->
                                                <div class="mm-sell t-main t-085">{{ $resDetail['more_product_sell'] }}</div>
                                                <!-- End:手機 mm 上會出現 -->
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End:推薦更多商品 -->
        @endif
    </main>
    <!-- End:main -->
    <!-- End:wrapper -->

    <img src="https://clk.gomaji.com/{{ $clk['plat'] ?? '' }}/{{ $clk['bu'] ?? '' }}/product/pid={{ $clk['id'] ?? '' }}" style="display:none" height="1" width="1" />
@endsection

@section('popup')
    @if (isset($preview) && !$preview)
        <!-- GOMAJI 訂閱通知 -->
        <div style="display: none;" id="gomaji-push-notification" class="gomaji-push-notification popupBox w-25">
            <div class="gomaji-push-notification">
                <div class="head d-flex">
                    <img class="w-25 lazyload" data-original="{{ url('/images/maji-push-notification.png')  }}" alt="GOMAJI-push-notification">
                    <div class="text">
                        <h3>歡迎訂閱 GOMAJI 優惠通知</h3>
                        <p>每日特殺大檔及不定期全站折扣活動第一手通知！</p>
                    </div>
                </div>
                <div class="d-flex bd-highlight mt-2">
                    <button class="push-refuse push-btn btn-gray ml-auto mr-2">暫時不要</button>
                    <button class="push-confirm push-btn btn-main">訂閱</button>
                </div>

            </div>
        </div>
        <!-- End:GOMAJI 訂閱通知 -->
    @endif
    @if ($resDetail['availableType'] == 'show')
        <!-- popup: mm 現有空跳出說明 -->
        <div style="display: none;" id="available-info" class="popupBox">
            <h2 data-selectable="true" class="t-main">現有空</h2>
            <div class="text">
                <p>綠燈顯示「現有空」表示目前店家有空房 / 位可供 GOMAJI 會員使用，建議行前先與店家電話聯繫，仍請需遵守兌換券使用說明，謝謝！未亮燈顯示，有可能是店家並未使用此功能，不代表沒有空房 / 位。</p>
            </div>
        </div>
        <!-- End:mm 現有空跳出說明 -->
    @endif
    <!-- Popup social-copy -->
    <div style="display: none;" id="social-copy-popup" class="sweet-alert popupBox-400">
        <div class="sa-icon sa-success animate" style="display: block;">
            <span class="sa-line sa-tip animateSuccessTip"></span>
            <span class="sa-line sa-long animateSuccessLong"></span>
            <div class="sa-placeholder"></div>
            <div class="sa-fix"></div>
        </div>
        <p data-selectable="true" class="text-center t-15 t-orange">
            恭喜您複製成功！
        </p>
    </div>
    <!-- End:Popup social-copy -->
    <!-- Popup:更多評價 -->
    <div style="display: none;" id="review-popup" class="popupBox w-35">
        <h2 data-selectable="true" class="t-orange">評價</h2>
        <div class="filterbarBox d-flex justify-content-end">
            <a class="btn dropdown-toggle" role="button" id="btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                篩選條件
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-dropdown">
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="0">全部</a>
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="5">非常滿意</a>
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="4">滿意</a>
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="3">普通</a>
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="2">不滿意</a>
                <a class="dropdown-item" href="#" onclick="return false;" data-ratingfilter="1">非常不滿意</a>
            </div>
        </div>
        <div class="ratingListBox" id='rating__totalList__content'>
            <div class="ratingList"></div>
        </div>
    </div>
    <!-- End:更多評價 -->
    <!-- Popup:商品選擇 -->
    <div style="display: none;" id="purchaseBox" class="popupBox w-35">
        <h2 data-selectable="true" class="t-orange">商品選擇</h2>
        <div class="purchase-option">
            @if (count($product['sub_products']) > 0)
                @foreach ($product['sub_products'] as $sub)
                    <div class="option-list">
                        <div class="title">
                            <p class="t-plan t-095" data-selectable="true">{{ $sub['sp_name'] }}</p>
                        </div>
                        <div class="product-price d-flex justify-content-end">
                            @if ($sub['sp_org_price'] > 0)
                                <div class="discount t-085 t-danger calc-discount" data-discount="{{ (($sub['sp_price'] / $sub['sp_org_price']) * 100)/10 }}"></div>
                            @endif
                            <div class="price-card d-flex">
                                @if ($sub['sp_org_price'] > $sub['sp_price'])
                                    <div class="original line-through ml-auto t-gray">
                                        ${{ $sub['sp_org_price'] }}
                                    </div>
                                @endif
                                <div class="current t-danger" data-selectable="true">
                                    ${{ $sub['sp_price'] }}
                                </div>
                            </div>

                            <div class="purchas-btn ml-3">
                                @if ($sub['sp_max_order_no'] > 0 && $sub['sp_order_no'] >= $sub['sp_max_order_no'])
                                    <a class="btn btn-gray mb-2 disabled" href="#" role="button">
                                        搶購一空
                                    </a>
                                @else
                                    <!-- 預覽頁 -->
                                    @if ($preview == 1)
                                        <!-- 針對商品有多方案詳細規格選擇 -->
                                        @if ($product['inventory'] == 1)
                                            <a class="btn btn-main px-3" href="{{ url('/checkout/pid/' . $product['product_id'] . '/spid/' . $sub['sp_id'] . '?share_code=' . $shareCode . '&preview=1' . (!empty($ref) ? '&ref=' . $ref : '')) }}" rel="buy">
                                                馬上購買
                                            </a>
                                        @else
                                            <a class="btn btn-main px-3" href="{{ Config::get('setting.usagiDomain') }}" rel="buy">
                                                馬上購買
                                            </a>
                                        @endif
                                    {{-- 如果商品有多方案，且有詳細規格需要選擇 -> 到規格選擇頁面 --}}
                                    @elseif ($product['inventory'] == 1)
                                        <a class="btn btn-main px-3" href="{{ url('/checkout/pid/' . $product['product_id'] . '/spid/' . $sub['sp_id'] . '?share_code=' . $shareCode . (!empty($ref) ? '&ref=' . $ref : '')) }}" rel="buy">
                                            馬上購買
                                        </a>
                                    {{-- 如果商品有多方案，但並無詳細規格需要選擇 -> 直接到結帳頁 --}}
                                    @else
                                        <a class="btn btn-main px-3" href="javascript: void(0);" onclick="linkToCheckout('https://ssl.gomaji.com/checkout-1.php?pid={{ $product['product_id'] }}&sp_id={{ $sub['sp_id'] }}&share_code={{ $shareCode }}{{ !empty($ref) ? '&ref=' . $ref : '' }}')" rel="buy">
                                            馬上購買
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if (isset($sub['sp_avg_price']) && $sub['sp_avg_price'] > 0)
                            <p class="average-price" data-selectable="true">均價${{ $sub['sp_avg_price'] }}</p>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- End:商品選擇 -->

    <!-- Popup purchaseBox-preview 單方案預覽頁用 -->
    <div style="display: none;" id="purchaseBox-preview" class="popupBox w-35">
        <h2 data-selectable="true" class="t-orange">商品選擇</h2>
        <div class="purchase-option">
            <div class="option-list">
                <div class="title">
                    <p class="t-plan t-095" data-selectable="true">{{ $product['real_product_name'] }}</p>
                </div>
                <div class="product-price d-flex justify-content-end">
                    @if ($product['org_price'] > 0)
                        <div class="discount t-085 t-danger calc-discount" data-discount="{{ (($product['price'] / $product['org_price']) * 100)/10 }}"></div>
                    @endif
                    <div class="price-card d-flex">
                        @if ($product['previewOrgPrice'] > $product['previewPrice'])
                            <div class="original line-through ml-auto t-gray">
                                ${{ $product['previewOrgPrice'] }}
                            </div>
                        @endif
                        <div class="current t-danger" data-selectable="true">
                            ${{ $product['previewPrice'] }}
                        </div>
                    </div>

                    <div class="purchas-btn ml-3">
                        <a class="btn btn-main px-3" href="{{ $resDetail['buy_button_url'] }}" rel="buy">
                            {{ $resDetail['buyButtonName'] ?? '' }}
                        </a>
                    </div>
                </div>
                @if (isset($product['avg_price']) && $product['avg_price'] > 0)
                    <p class="average-price" data-selectable="true">均價${{ $product['avg_price'] }}</p>
                @endif
            </div>
        </div>
    </div>
    <!-- End:Popup purchaseBox-preview -->

    <!-- Popup:店家地圖 -->
    <div style="display: none;" id="map-popup" class="popupBox w-35">
        <h2 data-selectable="true" class="t-orange"></h2>
        <div class="gogole-map">
            <iframe src="" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <p style="text-align:center; display:none" id="no_address">此商家未提供地址！</p>
    </div>
    <!-- End:店家地圖 -->

@endsection

@section('script')

    <!-- jQuery -->
    @if (isset($preview) && !$preview && $product['order_status'] != 'END')
        <script type="text/javascript" src="{{ url('js/webpush-main.js?1648694185') }}"></script>
    @endif
    <script type="text/javascript" src="{{ url('js/assets/clipboard.min.js') }}"></script>
    <!-- == END: jQuery ==-->

    <script>
        let chId = {{ $product['ch_id'] }};
        let paperTicket = {{ $product['is_paper_ticket'] }};
        let productId = {{ $product['product_id'] }};
        let storeName = '{{ $product['store_name'] }}';
        let storeId = {{ $product['store_id'] }};
        let groupId = {{ $product['group_id'] }};
        let preview = {{ $preview }};
        let totalPage = 1;
        // 用來紀錄評價內容總頁數參數以便判斷scroll是否滑到底
        let allPage = 1;
        let ratingData = new Array();
        // 評價 html view
        let _html = '';
        let rating_filter_value = 0;

        // 公益
        var totalNum = {{ $es['totalNum'] }}; // 最大可募集份數
        var achieveNum = {{ $es['achieveNum'] }}; // 已募集份數

        var tabScrollTop = {{ $resDetail['tabScrollTop'] ?? 0 }}; // Tab 的錨點校準數值
        var tabScrollNum = {{ $resDetail['tabScrollNum'] ?? 0 }}; // Tab 的錨點校準增減數值

        var timeoutId; // 判斷 mm 倒數時間顏色的 setTimeout ID

        $(function ()
        {
            // 另開新視窗未有上一頁歷史紀錄 即導向頻道頁
            if (window.history.length == 1) {
                document.getElementById("toolBarLink").href = '{{ $goBack['toolBarLink'] }}';
            }

            // 頁面圖片、位移讀取完成後，進行Lazyload
            $(window).on('load', function() {
                $('img.lazyload').lazyload().each(function() {
                    if ($(this).offset().top < $(window).height()) {
                        $(this).trigger('appear');
                    }
                });
            })

            // banner
            $('.carousel-product-ad').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                items: 1,
                loop: true,
                autoplay: true,
                dots: false,
                nav: false,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
            });

            // mm banner
            $('.line-special-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                items: 1.3,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 4000,
            });

            // 熱銷推薦
            $('.hot-recommend-carouel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                loop: true,
                responsive: {
                    0: {
                        items: 2.2,
                        margin: 5
                    },
                    600: {
                        items: 2.5,
                        margin: 20
                    },
                    1000: {
                        items: 4,
                        margin: 20
                    }
                }
            });

            // 檔次主要圖片
            $('.product-carousel').owlCarousel({
                lazyLoad: true,
                lazyLoadEager: 1,
                items: 1,
                loop: true,
                margin: 0,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
            });

            // 如 menu 為3個 tab 加上 class，避免跑版
            let tabLen = $('#myNavbar ul li').length;
            if (3 == tabLen) {
                $('#myNavbar').addClass('rs-3');
            }

            // 點擊 Tab
            $('a[href^="#"]', $('#myNavbar')).on('click', function (e) {
                e.preventDefault();

                $(document).off("scroll");
                $('li').each(function () {
                    $(this).removeClass('active');
                })
                $(this).addClass('active');
                var target = this.hash;
                $target = $(target);
                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top
                }, 1500, 'swing', function () {
                    window.location.hash = target;
                    $(document).on("scroll", onScroll);

                    $('html, body').stop().animate({
                        scrollTop: $target.offset().top - tabScrollTop
                    }, 1000);
                });
            });

            // 判斷滑鼠點擊事件
            document.onmousedown = mouseClick;

            loadRating(1, buildTotalRating);

            // 分享facebook
            $('body').on('click', '.share', function () {
                let share_type  = $(this).data('type');
                let title       = $(this).data('product_name');
                let url = location.href.includes('?')
                    ? location.href.split('?')[0]
                    : location.href

                // 以 facebook分享需先開 popup window，不然會被擋掉
                if (share_type == 'facebook') {

                    let option = (share_type == 'facebook')
                        ? 'toolbar=0, status=0, width=626, height=436, resizable=yes'
                        : '';
                    let popwin = window.open('', 'share', option);

                    if (title.length > 95) {
                        title = title.substr(0, 91) + '...';
                    }
                    popwin.location = `https://www.facebook.com/sharer.php?u=${encodeURIComponent(url)}&t=${encodeURIComponent(title)}`;
                }
            });

            // Line分享（PC & Mobile）
            var mmLineLink = document.createElement('a');
            $('body').on('click', '.lineShare', function(e) {
                e.preventDefault();

                /*--  Line Share on PC  start --*/
                if (!$(this).hasClass('mmShare')) {
                    let height = '540';
                    let width = '720';
                    let top = (window.innerHeight - height) / 2;
                    let left = (window.innerWidth - width) / 2;
                    window.open(
                        `https://lineit.line.me/share/ui?url=${encodeURIComponent(location.href)}`,
                        'share',
                        `toolbar=0, status=0, width=${width}, height=${height}, top=${top}, left=${left}, resizable=yes`
                    );
                    return;
                }
                /*--  Line Share on PC  end --*/

                /*--- Line Share on Mobile  Start ---*/
                // 點擊過，直接進入短網址
                if ($(this).hasClass('clicked')) {
                    mmLineLink.click();
                    return;
                }
                // 首次點擊，打API建立短網址
                let mmLineButton = $(this);
                $.get('/api/lineShare', {storeName, storeId, productId}, function(res) {
                    if (res.return_code != 0000) {
                        console.info(`${res.description} ${res.return_code}`);
                        return;
                    }

                    Object.assign(mmLineLink, {
                        href: res.lineUrl,
                        target: '_blank',
                        rel: 'noopener'
                    });
                }).then(function() {
                    mmLineLink.click();
                    mmLineButton.addClass('clicked');
                })
                /*--- Line Share on Mobile  End ---*/
            })

            // 複製商品url連結
            new Clipboard('#share-copy', {
                text: function() {
                    return document.querySelector('#copy').value;
                }
            });

            // click location popup google map
            $('body').on('click', '.map-btn', function () {
                var title   = $(this).closest('.store').find('input[name="map-title"]').val();
                var address = $(this).closest('.store').find('input[name="map-address"]').val();
                var geo     = $(this).closest('.store').find('input[name="map-geo"]').val();

                $('#map-popup h2').text(title);

                let value = (address) ? address : geo;

                if ("" == value) {
                    $(".gogole-map").hide();
                    $("#no_address").show();
                } else {
                    $('.gogole-map iframe').attr("src","https://www.google.com/maps?f=q&source=s_q&hl=zh-TW&geocode=&ie=UTF8&z=17&iwloc=A&output=embed&hq=&q=" + value);
                }

            });

            // click review-rating popup
            $('body').on('click', '#click-review-popup', function () {
                // 初始化
                totalPage = 1;
                // 初始化清空 popup rating view
                _html = '';
                console.log('click-review-popup:' + rating_filter_value);
                loadRating2(totalPage, buildTotalRating2, rating_filter_value);
            });

            var nScrollHight    = 0;    // 滾動距離總長（注意不是滾動條的長度）
            var nScrollTop      = 0;    // 滾動到的當前位置
            var nDivHight       = $("#rating__totalList__content").height();

            // 判斷評價點更多到底
            $('#rating__totalList__content').scroll(function() {

                nScrollHight        = $(this)[0].scrollHeight;
                nScrollTop          = $(this)[0].scrollTop;
                var paddingBottom   = parseInt( $(this).css('padding-bottom') ),paddingTop = parseInt( $(this).css('padding-top') );

                // 滾動條到底部了
                if(nScrollTop + paddingBottom + paddingTop + nDivHight >= nScrollHight) {
                    if (allPage > totalPage) {
                        loadRating2(++totalPage, buildTotalRating2, rating_filter_value);
                    }
                }
            });

            // dropdown
            $('body').on('click', '.dropdown-item', function () {

                rating_filter_value = $(this).data('ratingfilter');

                $('#btn-dropdown').text($(this).text());

                console.log('rating_filter_value:' + rating_filter_value);

                // 初始化
                totalPage = 1;
                // 初始化清空 popup rating view
                _html = '';
                $('#rating__totalList__content').html(_html);
                loadRating2(totalPage, buildTotalRating2, rating_filter_value);

            });

            // 取得方案折數
            $( ".calc-discount" ).each(function(index) {

                var length  = $(".calc-discount").length;
                var city_id = $( this ).data('city');

                var dis     = formatFloat($( this ).data('discount'), 1);

                // 折數不等於10折 && 不能為NaN
                if(10 != dis && !isNaN(dis)) {
                    if (1 == length) {
                        $(this).text(dis + " 折  /");
                    } else {
                        $(this).text(dis + " 折");
                    }
                }

            });

            // tk_type = 1 開始顯示倒數
            var tk_type = $("#tk-type").val();
            if ('1' == tk_type) {
                untilTsCaculate();
                untilTsColor(); // 判斷 mm 的倒數時間顏色
            }

            //公益達成率
            var rate    = (achieveNum / totalNum) * 100;
            var size    = Math.pow(10, 1);
            var achieve = Math.round(rate * size) / size;
            $('#achievingRate').text(achieve + '%');
            $('#achievingRateBar').css("width", achieve+'%');

        });

        function onScroll(event)
        {
            if (tabScrollNum == 500 || tabScrollNum == 600) {
                var scrollPosition = $(document).scrollTop() - tabScrollNum;
            } else {
                var scrollPosition = $(document).scrollTop() + tabScrollNum;
            }

            $('.menubar li a').each(function () {
                var currentLink = $(this);
                var refElement = $(currentLink.attr("href"));
                if (refElement.position().top <= scrollPosition) {
                    $('.menubar li a').removeClass("active");
                    currentLink.addClass("active");
                }
                else {
                    currentLink.removeClass("active");
                }
            });
        }

        function mouseClick()
        {
            $('[data-toggle="popover"]').popover('hide');
        }

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })

        function loadRating(page, callback)
        {
            if(typeof ratingData[page] === 'undefined') {
                axios.get('/api/rating', { params: {chId: chId, groupId: groupId, productId: productId, apiType: 'info'} })
                    .then((res) => {
                        if (res.data.return_code === '0000') {
                            ratingData[page] = {ratings: res.data.data.ratings, recent_ratings: res.data.data.recent_ratings};
                            callback();
                        } else {
                            alert(res.data.description);
                        }
                    })
                    .catch((error) => {
                        console.error(error)
                    })

            } else {
                callback();
            }
        }

        function loadRating2(page, callback, filter_value)
        {
            axios.get('/api/rating', { params: { chId: chId, groupId: groupId, productId: productId, page: page, ratingFilterValue: filter_value, apiType: 'list'} })
                    .then((res) => {
                        if (res.data.return_code === '0000') {
                            ratingData[page] = {ratings: res.data.data};
                            totalPage = page;
                            callback();
                        } else {
                            alert(res.data.description);
                        }
                    })
                    .catch((error) => {
                        console.error(error)
                    })
        }

        function buildTotalRating()
        {
            if(typeof ratingData[totalPage] === 'undefined' || (0 === Object.keys(ratingData[totalPage].ratings).length) && (0 === Object.keys(ratingData[totalPage].recent_ratings).length)) {
                // 顯示沒有評價訊息的wording
                $('#not-rating').show();
                return;
            }

            if (1 == totalPage)
            {
                $('#rating__ratingCount').html("(" + ratingData[totalPage].ratings.rating_total_count+ ")");
                let _dash = buildDashboard(ratingData[totalPage].ratings, 'rating__totalDashboard');
                $('#rating__totalDashboard').html(_dash);
            }

            let _list = buildList(ratingData[totalPage].ratings.list, false);
            let _html = _list;
            $('#rating__totalList').html(_html);
        }

        function buildTotalRating2 ()
        {
            if(typeof ratingData[totalPage] === 'undefined' || (0 === Object.keys(ratingData[totalPage].ratings).length)) {
                return;
            }
            allPage = ratingData[totalPage].ratings.total_pages;
            console.log("current page => " + totalPage);
            var _list = buildList(ratingData[totalPage].ratings.list, true);
            let _html = _list;
            $('#rating__totalList__content').html(_html);
        }

        function buildDashboard(data)
        {

            let p5 = _p4 = _p3 = _p2 = _p1 = 0;
            if (data.rating_total_count > 0 ){
                _p5 = Math.round((data.score_cat_list[0].count * 100) / data.rating_total_count);
                _p4 = Math.round((data.score_cat_list[1].count * 100) / data.rating_total_count);
                _p3 = Math.round((data.score_cat_list[2].count * 100) / data.rating_total_count);
                _p2 = Math.round((data.score_cat_list[3].count * 100) / data.rating_total_count);
                _p1 = Math.round((data.score_cat_list[4].count * 100) / data.rating_total_count);
            }

            let _feature = '';
            if (data.feature != '') {
                _feature = data.feature.join('、');

                _feature = '<p class="text-center t-09 t-pink">' +
                                '<i class="icon i-nosale d-inline-block"></i>' +
                                _feature +
                            '</p>' +
                        '</div>';
            }

            let _html = '<div class="row no-gutters"> ' +
                            '<div class="col-md-4">' +
                                '<div class="rating-number text-center">' +
                                    '<h5 class="t-main">' + data.avg_score.toFixed(1) + '</h5>' +
                                    '<p class="lab mt-1">共' + data.rating_total_count + '人評價</p>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-8">' +
                                '<ul class="rating-overview">' +
                                    '<li class="d-flex">' +
                                        '<p class="lab">非常滿意</p>' +
                                        '<div class="progress">' +
                                            '<div class="progress-bar" role="progressbar" style="width: ' + _p5 + '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>' +
                                        '</div>' +
                                        '<p class="number">'+ data.score_cat_list[0].count + '</p>' +
                                    '</li>' +
                                    '<li class="d-flex">' +
                                        '<p class="lab">滿意</p>' +
                                        '<div class="progress">' +
                                            '<div class="progress-bar" role="progressbar" style="width: ' + _p4 + '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>' +
                                        '</div>' +
                                        '<p class="number">'+ data.score_cat_list[1].count + '</p>' +
                                    '</li>' +
                                    '<li class="d-flex">' +
                                        '<p class="lab">普通</p>' +
                                        '<div class="progress">' +
                                            '<div class="progress-bar" role="progressbar" style="width: ' + _p3 + '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>' +
                                        '</div>' +
                                        '<p class="number">'+ data.score_cat_list[2].count + '</p>' +
                                    '</li>' +
                                    '<li class="d-flex">' +
                                        '<p class="lab">不滿意</p>' +
                                        '<div class="progress">' +
                                            '<div class="progress-bar" role="progressbar" style="width: ' + _p2 + '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>' +
                                        '</div>' +
                                        '<p class="number">'+ data.score_cat_list[3].count + '</p>' +
                                    '</li>' +
                                    '<li class="d-flex">' +
                                        '<p class="lab">非常不滿意</p>' +
                                        '<div class="progress">' +
                                            '<div class="progress-bar" role="progressbar" style="width: ' + _p1 + '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>' +
                                        '</div>' +
                                        '<p class="number">'+ data.score_cat_list[4].count + '</p>' +
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</div>' +
                        _feature;

            return _html;
        }

        function buildList(data, more)
        {
            let count = (true == more) ? 0 : 2;
            if (data.length > count) {

                for (var i = 0; i < data.length; i++) {

                    let _reply = '';
                    if (data[i].reply != '') {
                        _reply = '<i class="icon i-signin-red"></i>' +
                                    '<span class="t-plan">店家回覆：</span>' + data[i].reply + '</div>';
                    }

                    let _feature = '';
                    if (data[i].feature != '') {
                        let _arr = data[i].feature.split('、');
                        for (var j = 0; j < _arr.length; j++) {
                            if (j == _arr.length - 1) {
                                _feature +=  _arr[j];
                            } else {
                                _feature +=  _arr[j] + '、';
                            }

                        }
                    }

                    _html += '<div class="ratingList">' + 
                                '<div class="d-flex">' +
                                    '<div class="user">' + data[i].name + '</div>' +
                                    '<div class="t-gray t-09 ml-2">' + data[i].date + '</div>' +
                                    '<div class="t-gray t-09 ml-auto storename ellipsis">' + data[i].type + '</div>' +
                                '</div>' +
                                '<div class="label-smile i-smile-' + data[i].rating + '"></div>' +
                                '<p class="t-gray">' + data[i].sp_name + '</p>' +
                                '<p>' + data[i].feedback + '</p>' +
                                '<div class="store-feedback ml-4 mt-1">' +
                                    _reply +
                                '</div>' +
                                '<p class="t-main">' + _feature + '</p>' +
                                '<hr>' +
                            '</div>';
                }

                if (!more) {
                    _html += '<a data-fancybox data-src="#review-popup" id="click-review-popup" href="javascript:;" class="btn btn-outline-main rating-btn d-block" style="width: 40%;">看更多評價</a>'+
                    '<p class="text-center t-09 t-gray">評價留言最多顯示三年內之資料喔！</p>';
                }
            } else {
                _html = '<div class="ratingList"><p class="text-center t-orange p-5">現在未有任何評價或評分資料不足喔！</p></div>';
            }

            return _html;
        }

        // 計算折數取幾位
        function formatFloat(num, pos)
        {
            var size = Math.pow(10, pos);
            return Math.floor(num * size) / size;
        }

        function linkToCheckout (link)
        {
            // Google追蹤使用(Google Tag Manager)
            if (0 == preview) {
                ga('send', {
                    hitType: 'event',
                    eventCategory: 'Button',
                    eventAction: 'Click',
                    eventLabel: 'Web_purchase',
                    eventValue: '0'
                });
            }

            window.location = link;
        }

        // 領取成功的跳窗
        document.querySelector('.copy-share').onclick = function () {
            swal("恭喜您複製成功！","","success")

        };

        // 當完售 消費者送出 mail
        $('body').on('click', '#sold-out-btn', function () {

            var mail = $('#sold-out-mail').val();

            if (mail == '') {
                alert('請輸入您的電子信箱！！');
                return false;
            }

            var soldOutType = $('#soldout_type').val();

            if (emailValidate(mail)) {
                $.post('/api/soldOut', { productId: productId, email: mail, soldOutType: soldOutType }, function (data) {
                    $('#soldout-message').text(data.description);
                });
            } else {
                alert('email格式錯誤！！');
            }

        });

        // 當完售 消費者送出 mail(mm版)
        $('body').on('click', '#sold-out-btn-mm', function () {

            var mail = $('#sold-out-mail-mm').val();

            if (mail == '') {
                alert('請輸入您的電子信箱！！');
                return false;
            }

            var soldOutType = $('#soldout_type').val();

            if (emailValidate(mail)) {
                $.post('/api/soldOut', { productId: productId, email: mail, soldOutType: soldOutType }, function (data) {
                    $('#soldout-message').text(data.description);
                });
            } else {
                alert('email格式錯誤！！');
            }

        });

        // 開啟下載APP頁或開啟APP
        function handleOpenApp() {

            // 取得url的網址參數shareCode
            var shareCode = location.search.split('share_code=')[1];
            // 設定參數內容
            var params = [];
            params.ch_id = chId;
            params.city_id = 1;
            params.share_code = (typeof(shareCode) == 'undefined' || shareCode == '') ? '' : shareCode ;
            params.pid = productId;

            var url = `gomaji://action?ch_id=${params.ch_id}&city_id=${params.city_id}&share_code=${params.share_code}&pid=${params.pid}`;

            // 咖啡檔次開啟App的deeplink需加上gid
            if ({{ $product['product_kind'] }} == {{ Config::get('channel.id.coffee') }}) {
                params.gid = groupId;
                url = url + `&groupId=${params.gid}`;
            }

            let action = encodeURIComponent(url);
            window.location = 'https://ddd.gomaji.com/redirect/open-dl-app?action=' + action;

        }

        // 商品頁面 - mm soldout  推薦
        $('.endRecommend-carouel').owlCarousel({
            loop: true,
            responsive: {
                0: {
                    items: 2.2,
                    margin: 5
                },
                375: {
                    items: 3.2,
                    margin: 5
                },
                600: {
                    items: 2.5,
                    margin: 20
                },
                1000: {
                    items: 4,
                    margin: 20
                }
            }
        });

        // 更多商品
        $('.more-product-carouel').owlCarousel({
            margin: 10,
            nav: true,
            stagePadding: 8,
            loop: false,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1025: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        /*
         * 判斷 mm 的倒數時間顏色
         *   >= 24 小時為橘色
         *   < 24 小時為黃色
         */
        function untilTsColor()
        {
            let untilts = parseInt($('.until-ts').data('untilts'));

            if (untilts < 60 * 60 * 24) {
                $('#untilTsOrange').hide();
                $('#untilTsYellow').show();
                clearTimeout(timeoutId);
                return;
            }

            timeoutId = setTimeout(untilTsColor, 1000);
        }

        /*
         * valid mail
         */
        function emailValidate(email)
        {
            let regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!regex.test(email)) {
                return false;
            } else {
                return true;
            }
        }

        /*
         * 倒數時間
         */
        function untilTsCaculate()
        {
            $('.until-ts').each(function ()
            {
                let $obj = $(this);
                let second_time = $obj.data('untilts');
                second_time = parseInt(second_time);

                let time = '';

                if (second_time > 0) {
                    second_time = second_time - 1;
                    $obj.data('untilts', second_time);

                    time = parseInt(second_time) + '秒';
                    if (parseInt(second_time) > 60) {

                        let second = parseInt(second_time) % 60;
                        let min = parseInt(second_time / 60);
                        time = min + '分' + second + '秒';

                        if (min > 60) {
                            min = parseInt(second_time / 60) % 60;
                            let hour = parseInt(parseInt(second_time / 60) / 60);
                            time = hour + '時' + min + '分' + second + '秒';

                            if (hour > 24) {
                                hour = parseInt(parseInt(second_time / 60) / 60) % 24;
                                let day = parseInt(parseInt(parseInt(second_time / 60) / 60) / 24);
                                time = day + '天' + hour + '時' + min + '分' + second + '秒';
                            }
                        }
                    }
                }
                $obj.html(time);
            });

            setTimeout(untilTsCaculate, 1000);
        }
    </script>
    <!-- == END: jQuery ==-->

@endsection
