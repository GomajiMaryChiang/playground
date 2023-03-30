<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row no-gutters">
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="first-cover carousel-first-cover owl-carousel owl-loaded owl-drag">
                @if (isset($banners) && !empty($banners))
                    @foreach ($banners as $key => $banner)
                        <div class="item">
                            <a href="{{ $banner['link'] }}"><img class="img-fluid lazyload" src="{{ $banner['img'] }}" alt="{{ $banner['subject'] }}"></a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 pl-2">
            @if (isset($second_banner) && !empty($second_banner))
                <div class="second-cover">
                    <a href="{{ $second_banner[0]['link'] }}">
                        <img class="img-fluid lazyload" src="{{ $second_banner[0]['img'] }}" alt="{{ $second_banner[0]['subject'] }}">
                    </a>
                </div>
            @endif
            @if (isset($third_banner) && !empty($third_banner))
                <div class="third-cover">
                    <a href="{{ $third_banner[0]['link'] }}">
                        <img class="img-fluid lazyload" src="{{ $third_banner[0]['img'] }}" alt="{{ $third_banner[0]['subject'] }}">
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>