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
                                <li class="nav-item active"><a class="nav-link" href="{{ url('/about/event') }}">公司記事</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/about/newsroom') }}">媒體報導</a></li>
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
                        <h2 class="text-center mt-2">GOMAJI 公司記事</h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                                @if (!empty($eventList))
                                    @foreach ($eventList as $event)
                                        @if (!empty($event['list']))
                                            <h3 class="timeline-year t-main">{{ $event['year'] ?? '' }}<span>年記事</span></h3>

                                            <ul class="timeline">
                                                @foreach ($event['list'] as $list)
                                                    <li>
                                                        <p class="timeline-date">{{ date('Y/m/d', strtotime($list['h_ts'])) ?? '' }}</p>
                                                        <p class="timeline-content">{{ $list['h_desc'] ?? '' }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        @if (!empty($event['media_list']))
                                            <div class="row mt-3">
                                                @foreach ($event['media_list'] as $media)
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-6">
                                                        <div class="hover-effect">
                                                            <div class="imgBox">
                                                                @if ($media['kind'] == 1)
                                                                    <img class="w-100" src="{{ $media['url'] ?? '' }}" alt="{{ $media['title'] ?? '' }}">
                                                                @elseif ($media['kind'] == 2)
                                                                    <iframe width="100%" height="255" src="{{ $media['url'] ?? '' }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                @endif
                                                            </div>
                                                            <div class="contentBox">
                                                                <div class="content">
                                                                    <p>{{ $media['title'] ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
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
