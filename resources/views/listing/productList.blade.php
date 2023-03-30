@extends('modules.common')

@section('content')
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            @isset($subChTitle)
                                <li class="breadcrumb-item"><a href="{{ url('' . $chTitleUrl) }}">{{ $chTitle }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $subChTitle }}</li>
                            @else
                                <li class="breadcrumb-item active">{{ $chTitle }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
                <!-- End:breadcrumb -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header">
                        @isset($subChTitle)
                            {{ $subChTitle }}
                        @else
                            {{ $chTitle }}
                        @endisset
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <main class="main">
        <div class="channel-sectionBox">
            <div class="container">
                <div class="row" id="container__row">
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
                    var _url = '{{ url('') }}' + loadMoreUrl + page;

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
