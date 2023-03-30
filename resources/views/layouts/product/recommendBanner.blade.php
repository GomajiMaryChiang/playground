<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 padding-0">
    <div class="activity-banner border border-r bg-white">
        <a href="{{ $recommend['link'] ?? '#' }}"><img class="img-fluid lazyload" src="{{ url('/images/loading-540x359.jpg') }}" data-original="{{ $recommend['img'][0] ?? '' }}" alt="{{ $recommend['subject'] ?? '' }}"></a>
    </div>
</div>