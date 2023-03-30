<div class="sectionBox">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-head relative padding-0">
                <h2>
                    @if (!empty($pictureList['icon']))
                        <i class="sectionhead-icon {{ $pictureList['icon'] }}"></i>
                    @endif

                    {{ $pictureList['title'] ?? '' }}

                    @if (!empty($pictureList['sub_title']))
                        <span class="t-11">{{ $pictureList['sub_title'] }}</span>
                    @endif
                </h2>
                <div class="more">
                    <a href="{{ $pictureList['more_link'] ?? '#' }}" class="{{ $pictureList['more_link_class'] ?? '' }}" data-id="{{ $pictureList['ch_id'] ?? '' }}">更多<i class="fas fa-angle-right"></i></a>
                </div>
            </div>
            <div class="col-md-12 section-stage padding-02">
                <div class="owl-carousel owl-theme {{ $pictureList['carouel_class'] ?? '' }}" id="{{ $pictureList['carouel_id'] ?? '' }}">
                    @foreach ($pictureList['picture'] as $picture)
                        <div class="item">
                            <a href="{{ $picture['link'] ?? '#' }}" class="{{ $picture['more_link_class'] ?? '' }}" data-id="{{ $picture['chId'] ?? ''}}" {{ !empty($picture['isBlank']) ? 'target="_blank"' : '' }}>
                                <img class="img-fluid border border-r owl-lazy" data-src="{{ $picture['img'] ?? '' }}" alt="{{ $picture['name'] ?? '' }}">
                                @if (!empty($picture['subject_tag']))
                                    <div class="subject-tag">
                                        <span class="subject ellipsis">{!! $picture['subject_tag'] !!}</span>
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
