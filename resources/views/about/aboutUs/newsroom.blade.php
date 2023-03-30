@extends('modules.common')

@section('content')
    <main class="main">
        <div class="about-banner">
            <div class="container-fluid">
                <div class="row">
                    <img class="img-fluid" src="{{ url('/images/about/about.jpg') }}" alt="關於我們">
                </div>
            </div>
        </div>
        <!-- End:我們的banner -->
        <div class="mm-about-banner">
            <div class="container-fluid">
                <div class="row">
                    <img class="w-100" src="{{ url('/images/about/about-mm.jpg') }}" alt="關於我們">
                </div>
            </div>
        </div>
        <!-- End:mm-about-banner -->
        <div class="about-menubar sticky" data-toggle="sticky-onscroll">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-12">
                        <div class="menubar">
                            <ul class="nav">
                                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">關於我們</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/about/event') }}">公司記事</a></li>
                                <li class="nav-item active"><a class="nav-link" href="{{ url('/about/newsroom') }}">媒體報導</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sectionBox about-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mt-2">GOMAJI 媒體報導</h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                                @if (!empty($newsList))
                                    @foreach ($newsList as $news)
                                        @if (!empty($news['report_list']))
                                            <h3 class="timeline-year t-main">{{ $news['year'] ?? '' }}<span>年</span></h3>

                                            <ul class="timeline">
                                                @foreach ($news['report_list'] as $report)
                                                    <li>
                                                        <p class="timeline-date">{{ date('Y/m/d', strtotime($report['date'])) ?? '' }}</p>
                                                        <p class="timeline-content">
                                                            <a class="underline" href="{{ $report['url'] ?? '' }}" target="_blank">{{ $report['desc'] ?? '' }}</a>
                                                            <em class="t-darkgray">- {{ $report['report_from'] ?? '' }}</em>
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection
