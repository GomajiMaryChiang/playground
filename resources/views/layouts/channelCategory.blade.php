@if (!empty($categories))
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="hot-categoryBox channel-page">
            <div class="row no-gutters">
                <div class="col-md-1 section-head relative padding-0">
                    <h3>熱門類別</h3>
                </div>
                <div class="col-md-11 section-stage padding-02">
                    <div class="hot-category">
                        <ul>
                            @foreach ($categories as $key => $category)
                                <li class="hot-category-item">
                                    @if ($categoryId == $category['cat_id'])
                                        <a href="{{ url($category['link']) }}" class="active">{{ $category['cat_name'] }}</a>
                                    @else
                                        <a href="{{ url($category['link']) }}">{{ $category['cat_name'] }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
