@extends('modules.common')

@section('content')
            <!-- 麵包屑＆品牌Banner == 開 始 == -->
            <div class="product-head-wrapper theme-bg">
                <div class="container padding-0">
                    <div class="row no-gutters">
                        @if (!empty($breadcrumbList))
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        @foreach ($breadcrumbList as $breadcrumb)
                                            @if (!empty($breadcrumb['link']))
                                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] ?? '#' }}">{{ $breadcrumb['title'] ?? '' }}</a></li>
                                            @else
                                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] ?? '' }}</li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </nav>
                            </div>
                        @endif

                        @if (!empty($img))
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h1 class="brand-banner">
                                    <img src="{{ $img }}" alt="{{ $title }}">
                                </h1>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- 麵包屑路徑＆品牌Banner == 結 束 == -->

            <!-- 檔次列表 == 開 始 == -->
            <main class="main">
                <div class="channel-sectionBox">
                    <div class="container">
                        <div class="row" id="container__row">
                            <!-- 排序按鈕 -->
                            <div class="col-md-12 mb-3">
                                <div class="filterbarBox d-flex justify-content-end mt-2">
                                    <!-- 預設顯示按鈕 -->
                                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $sortList[$sort] ?? $sortList[0] }}
                                    </a>
                                    <!-- 排序選項迴圈 -->
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        @foreach ($sortList as $key => $value)
                                            @if (!empty($value))
                                                @if (isset($ch) && $ch == Config::get('channel.id.coffee'))
                                                    <a class="dropdown-item" href="{{ $sortUrl }}?sort={{ $key }}">{{ $value }}</a>
                                                @else
                                                    <a class="dropdown-item" href="{{ $sortUrl }}&sort={{ $key }}">{{ $value }}</a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- 檔次內容 -->
                            @include('layouts.channelProduct')
                        </div>
                            @if ($totalPages > 1)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="btn-loadmore btn btn-outline-main w-30" value="看更多" data-lt="載入中…" type="button">
                                </div>
                            @endif
                    </div>
                </div>
            </main>
            <!-- 檔次列表 == 結 束 == -->
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
                    if( parseInt(second_time )> 60){

                        let second = parseInt(second_time) % 60;
                        let min = parseInt(second_time / 60);
                        time = min + "分" + second + "秒";

                        if( min > 60 ){
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

    <script>
        $(function()
        {
            let page = 1;
            let isLoading = 0;
            let isMore = @if ($totalPages <= 1) 0 @else 1 @endif

             function imgLazyLoad()
            {
                $("img.lazyload").lazyload();
            }

            imgLazyLoad();
            $(window).on("scroll", function() {
                var windowHeight = $(window).height();
                var scrollHeight = $(document).height();
                var scrollPosition = $(window).height() + $(window).scrollTop();
                if ((scrollHeight - scrollPosition) <= windowHeight) {
                    $('.btn-loadmore').trigger('click');
                }
            });

            $('.btn-loadmore').on('click', function()
            {
                if (1 == isLoading) {
                    return;
                }
                if (0 == isMore) {
                    return;
                }

                page++;

                var _url = '{{ url($loadMoreUrl) }}' + `&page=${page}`;

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
                })
            })

            imgLazyLoad();
        })
    </script>
@endsection
