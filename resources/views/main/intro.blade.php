@extends('modules.common')

@section('content')
    <main class="main">
        <div class="sectionBox store-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- 店家商品介紹 -->
                        @if (!empty($store['store_intro']))
                            <div class="sectionBox section-head">
                                {!! $store['store_intro'] !!}
                            </div>
                        @endif
                        <!-- End:店家商品介紹 -->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        // for APP 店家介紹頁不需要 TOP 按鈕
        if ($('#topBtn').length) {
            $('#topBtn').remove();
        }
    </script>
@endsection
