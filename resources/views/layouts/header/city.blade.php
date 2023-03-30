@if (!empty($cityData['cityList']))
    <div class="site-city-menu">
        <button class="nav-link dropdown-toggle ellipsis" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $cityData['activeName'] }}
        </button>
        <div id="cityarea-wrap" class="cityarea-wrap">
            <div class="city-menu relative">
                <ul class="city-list">
                    @foreach ($cityData['cityList'] as $id => $city)
                        @if (empty($city['subCity']))
                            <li><a href="{{ $cityData['url'] . $city['paramValue'] }}" >{{ $city['name'] }}</a></li>
                        @else
                            <li
                                @if (!empty($city['subCity']))
                                    id="tab-{{ $id }}"
                                    class="selected focus"
                                @endif
                            ><a href="javascript:;" >{{ $city['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="city-contentWrapper">
                    <div class="city-content">
                        @foreach ($cityData['cityList'] as $id => $city)
                            @if (!empty($city['subCity']))
                                <div id="content-tab-{{ $id }}" class="page" style="display:none;">
                                    <ul>
                                        <li class="first-area"><a href="{{ $cityData['url'] . $city['paramValue'] }}">{{ $city['name'] }} 全部</a></li>
                                        @foreach ($city['subCity'] as $subId => $subCity)
                                            <li><a href="{{ $cityData['url'] . $subCity['paramValue'] }}">{{ $subCity['name'] }}</a>
                                                @if (!empty($subCity['subCity']))
                                                    <ul>
                                                        @foreach ($subCity['subCity'] as $subChildId => $subChildCity)
                                                            <li><a href="{{ $cityData['url'] . $subChildCity['paramValue'] }}">{{ $subChildCity['name'] }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--End:下拉城市-->
    </div>
@endif