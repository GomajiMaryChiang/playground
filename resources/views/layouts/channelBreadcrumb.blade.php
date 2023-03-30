<div class="col-lg-12 col-md-12 col-sm-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
            @if ($categoryId == 0)
                <li class="breadcrumb-item acive" aria-current="page">{{ $chTitle }}</li>
            @endif
            @if ($categoryId != 0 && !empty($subChTitle))
                <li class="breadcrumb-item"><a href="{{ url($chTitleUrl) }}">{{ $chTitle }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $subChTitle }}</li>
            @endif
        </ol>
    </nav>
</div>
