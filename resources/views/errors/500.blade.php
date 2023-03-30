@extends('modules.common')

@section('content')
    <main class="main bg-gray">
        <div class="page-500-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-500 relative">
                            <img class="pc-img" src="{{ url('/images/main-500.png') }}" alt="500網頁無法正常運作">
                            <img class="mm-img" src="{{ url('/images/mm-500.png') }}" alt="500網頁無法正常運作">
                            <div class="main-500">
                                <h2>{{ $statusCode }}</h2>
                                <h3>@if($statusCode == 419){{ '閒置時間過久已逾時，請回首頁後再重新進入' }}@else{{ '啊呀！目前網頁無法正常運作....' }}@endif</h3>
                                <a class="btn btn-main w-50 mx-auto" href="{{ url('/') }}">回首頁</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection
