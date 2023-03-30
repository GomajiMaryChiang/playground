@extends('modules.common')

@section('content')
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">搜尋結果</li>
                        </ol>
                    </nav>
                </div>
                <!-- End:breadcrumb -->
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main">
        <div class="channel-sectionBox">
            <div class="container">
                <div class="row" id="container__row">
                    <div class="col-md-12 filter-menuBox bg-white">
                        <div class="filter-menu">
                            <nav class="search-filter border-b d-flex">
                                <h3 class="head t-gray">排序：</h3>
                                <div class="filter">
                                    <ul class="d-flex">
                                        <li>
                                            <a class="nav-link @if ($sort == 0) active @endif" href="{{ url('search?keyword=' . $searchKeyword . '&city=' . $city . '&cross=' . $cross . '&sort=0') }}">依關聯性</a>
                                        </li>
                                        <li>
                                            <a class="nav-link @if ($sort == 1) active @endif" href="{{ url('search?keyword=' . $searchKeyword . '&city=' . $city . '&cross=' . $cross . '&sort=1') }}">依評價</a>
                                        </li>
                                        <li>
                                        @if ($sort == 0 || $sort == 1)
                                            <a class="nav-link toggle toggle-up" href="{{ url('search?keyword=' . $searchKeyword . '&city=' . $city . '&cross=' . $cross . '&sort=2') }}">依價格</a>
                                        @elseif ($sort == 2)
                                            <a class="nav-link toggle toggle-up active" href="{{ url('search?keyword=' . $searchKeyword . '&city=' . $city . '&cross=' . $cross . '&sort=3') }}">依價格</a>
                                        @else
                                            <a class="nav-link toggle toggle-down active" href="{{ url('search?keyword=' . $searchKeyword . '&city=' . $city . '&cross=' . $cross . '&sort=2') }}">依價格</a>
                                        @endif
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        @if ($cross == 1)
                            <p class="text-center">您搜尋的『{{ $searchKeyword }}』結果如下，共{{ $totalItems }}筆！</p>
                        @else
                            <p class="text-center">以下是『{{ $searchKeyword }}』的搜尋結果，想看所有跨城市的結果嗎？<a href="{{ url('search?keyword=' . $searchKeyword . '&sort=' . $sort . '&cross=1') }}"><span class="badge btn-main">GO</span></a></p>
                        @endif
                    </div>
                    @if ($totalItems >= 1)
                        @include('layouts.channelProduct')
                    @endif
                </div>
                @if ($totalPages > 1)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <input class="btn-loadmore btn btn-outline-main w-30" value="看更多" data-lt="載入中…" type="button">
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        untilTsCaculate();
        function untilTsCaculate ()
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


                    time = parseInt(second_time) + "秒";
                    if( parseInt(second_time )> 60) {

                        let second = parseInt(second_time) % 60;
                        let min = parseInt(second_time / 60);
                        time = min + "分" + second + "秒";

                        if( min > 60 ) {
                            min = parseInt(second_time / 60) % 60;
                            let hour = parseInt( parseInt(second_time / 60) /60 );
                            time = hour + "時" + min + "分" + second + "秒";

                            if( hour > 24 ){
                                hour = parseInt( parseInt(second_time / 60) /60 ) % 24;
                                let day = parseInt( parseInt( parseInt(second_time / 60) /60 ) / 24 );
                                time = day + "天" + hour + "時" + min + "分" + second + "秒";
                            }
                        }
                    }
                }
                $obj.html(time);
            });
            setTimeout(untilTsCaculate, 1000);
        }
    </script>
    @isset($loadMoreUrl)
        <script>
            $(function()
            {
                let page = 1;
                let loadMoreUrl = '{!! $loadMoreUrl !!}';
                let isLoading = 0;
                let isMore = @if ($totalPages <= 1) 0 @else 1 @endif

                function imgLazyLoad()
                {
                    $("img.lazyload").lazyload();
                }
                function loadMore()
                {
                    $(window).on("scroll", function() {
                        var windowHeight = $(window).height();
                        var scrollHeight = $(document).height();
                        var scrollPosition = $(window).height() + $(window).scrollTop();
                        if ((scrollHeight - scrollPosition) <= windowHeight) {
                            $('.btn-loadmore').trigger('click');
                        }
                    });
                }

                imgLazyLoad();
                loadMore();

                $('body').on('click', '.btn-loadmore', function()
                {

                    if (1 == isLoading) {
                        return;
                    }
                    if (0 == isMore) {
                        return;
                    }

                    page++;
                    var _url = '{{ url('') }}' + '/' + loadMoreUrl + page;

                    isLoading = 1;
                    $.get(_url, function(json)
                    {
                        isLoading = 0;
                        result = $.parseJSON(json);

                        if (result.code != 1) {
                            alert(result.message);
                            return;
                        }

                        if (page >= result.total_pages) {
                            isMore = 0;
                            $('.btn-loadmore').hide();
                        }

                        $('#container__row').append(result.html);
                        imgLazyLoad();
                    })
                })
            })
        </script>
    @endisset
@endsection
