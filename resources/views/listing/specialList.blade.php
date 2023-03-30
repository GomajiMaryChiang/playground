@extends('modules.common')

@section('content')
    <div class="product-head-wrapper theme-bg">
        <div class="container padding-0">
            <div class="row no-gutters">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header">{{ $title }}</h1>
                </div>
            </div>
        </div>
    </div>
    <main class="main">
        <!-- 特別企劃 -->
        @if ($type == 'special')
            <div class="channel-sectionBox specialBox">
                <div class="container">
                    <div class="row">
                        @foreach ($specialList as $special)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 padding-0">
                                <div class="item">
                                    <a href="{{ url('/special/' . $special['id'] . '?city=' . $special['city_id']) }}">
                                        <img class="img-fluid border border-r" src="{{ $special['image'] }}" alt="{{ $special['name'] }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        <!-- 排行榜 -->
        @else
            <div class="channel-sectionBox topBox">
                <div class="container">
                    <div class="row">
                        @foreach ($specialList as $special)
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 padding-0">
                                <div class="item relative">
                                    <a href="{{ url('/top/' . $special['id'] . '?city=' . $cityId) }}">
                                        <img class="img-fluid border border-r" src="{{ $special['image'] }}" alt="{{ $special['name'] }}">
                                        <div class="subject-tag">
                                            <span class="subject ellipsis">{{ $special['name'] }}<br>{{ $special['top'] }}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <!-- End:星級飯店品牌 -->
    </main>
@endsection
