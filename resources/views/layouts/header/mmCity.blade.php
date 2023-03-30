@if (!empty($cityData['cityList']))
    <div class="site-city-menu">
        <button id="dropdownButton" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $cityData['activeName'] }}
        </button>
        <div id="dropdown-menu" class="city-menu-list">
            <ul class="item-list">
                @foreach ($cityData['cityList'] as $id => $city)
                    <li>
                        <a class="item" href="{{ $cityData['url'] . $city['paramValue'] }}">{{ $city['name'] }}</a>

                        @if (!empty($city['subCity']))
                            <ul class="city-erea">

                                @if (empty($cityData['isShowThirdLayer']))
                                    <li>
                                        <ul>
                                            @foreach ($city['subCity'] as $subId => $subCity)
                                                <li><a href="{{ $cityData['url'] . $subCity['paramValue'] }}">{{ $subCity['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    @foreach ($city['subCity'] as $subId => $subCity)
                                        <li><a class="item" href="{{ $cityData['url'] . $subCity['paramValue'] }}">{{ $subCity['name'] }}</a>

                                            @if (!empty($subCity['subCity']))
                                                <ul>
                                                    @foreach ($subCity['subCity'] as $subChildId => $subChildCity)
                                                        <li><a href="{{ $cityData['url'] . $subChildCity['paramValue'] }}">{{ $subChildCity['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif