@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">我要評價</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main main-contact">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb mt-2">
                        <ol class="breadcrumb rating">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">評價完成</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper rating-wrapper border border-r">
                        <p><img class="maji" src="{{ url('images/maji-rating-done.png') }}" alt="麻吉妹妹感謝您"></p>
                        <h2 class="text-center mb-2">感謝您的評價！</h2>
                        @if ($shareFlag == 1)
                            <p class="text-center sub-title mb-4 t-10">您的美好體驗應該讓更多人知道～<br>現在分享您的好評還能賺取點數喔！</p>
                            <a class="btn btn-main m-auto w-50" href="{{ $shareUrl }}" role="button">
                                分享賺點
                            </a>
                        @elseif ($shareFlag == 2)
                            <p class="text-center">感謝您的寶貴意見，我們將持續提供更優質的服務～</p>
                        @else
                            <p class="text-center">感謝您提供的寶貴意見，我們將與店家溝通改善，以提供更優質的服務！</p>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </main>
    <!-- End:main -->
@endsection