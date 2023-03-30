@extends('modules.common')

@section('content')
    <main class="main">
        <div class="informationBox bg-white box-shadow">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div id="infoDetail">
                            <p>歡迎您參與加入 GOMAJI<span class="t-danger">【填問卷賺點數】</span>活動，當您完成首次基本資料填寫 (限 15 歲以上會員參加)，即代表同意參加本活動，將您填寫的資料提供給 GOMAJI 問卷小組進行問卷使用。您有機會接收到更多問卷邀請，完成問卷內容即可獲贈得點數。</p>
                            <p>可使用的答題設備：電腦、手機。(視個別問卷實際要求，將於每份問卷邀請信中註明)</p>
                            <p>問卷類型可能涵蓋範圍：一般商業調查、屬性調查、招募調查、體驗調查等預計獲贈點數將於每份邀請信中載明 (依問卷時間長度而定)。</p>
                            <hr>
                            <form>
                                <div class="group-form">
                                    <label class="label" for="">訂購人Email</label>
                                    <input id="email" name="email" type="email" maxlength="45" class="form-control border-white" placeholder="請填寫Email" autocomplete="off" value="{{ $userInfo['email'] ?? '' }}">
                                </div>
                                <hr>
                                <div class="group-form">
                                    <label class="label" for="">性別</label>
                                    <div class="input-wrapper">
                                        <input type="radio" name="sex_cd" value="1" aria-label="Radio button input ml-2" {{ empty($userInfo['sex_cd']) ? '' : ($userInfo['sex_cd'] == 1 ? 'checked' : '') }}><span class="ml-2 mr-2">男</span>
                                        <input type="radio" name="sex_cd" value="2" aria-label="Radio button input ml-2" {{ empty($userInfo['sex_cd']) ? '' : ($userInfo['sex_cd'] == 2 ? 'checked' : '') }}><span class="ml-2">女</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="group-form">
                                    <label class="label i-check" for="">出生年月日</label>
                                    <div class="input-wrapper d-flex">
                                        <select class="form-control check-select border-white" name="year" id="year">
                                            <option selected>請選擇年份</option>
                                        </select>
                                        <select class="form-control check-select border-white" name="month" id="month">
                                            <option selected>請選擇月份</option>
                                        </select>
                                        <select class="form-control check-select border-white" name="day" id="day">
                                            <option selected>請選擇日期</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="group-form">
                                    <label class="label i-check" for="">居住地</label>
                                    <div class="input-wrapper">
                                        <select class="form-control check-select border-white" name="pref_cd" style="width:100%;">
                                            <option value="" selected>請選擇縣市...</option>
                                            @if (!empty($areaList))
                                                @foreach ($areaList as $area)
                                                    <option value="{{ $area['id'] }}" {{ empty($userInfo['pref_cd']) ? '' : ($userInfo['pref_cd'] == $area['id'] ? 'selected' : '') }} >
                                                        {{ $area['name']}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            </form>
                            <div class="notices mt-3">
                                <h3 class="t-gray mb-2">注意事項 ：</h3>
                                <ul>
                                    <li class="t-gray">本公司保留新增、修改、變更規定及判定點數贈送相關辦法之權利。</li>
                                    <li class="t-gray">您填答的問卷內容不會涉及您在 GOMAJI 的歷次購買資料，本調查不會因此知曉或取得您不願意提供的個人資料。</li>
                                    <li class="t-gray">GOMAJI 問卷小組將委託協力廠商【創市際市場研究顧問公司】，提供本專案的調查與研究服務，您同意本公司於問卷基本資料調查中所獲得的資料皆會提供給上述之協力廠商進行問卷邀請和 email 發送。</li>
                                    <li class="t-gray">請確認您填寫的基本資料及 email 正確，以保障您收到問卷邀請通知以及贈點的權益。</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sendBtn">
            <div class="mt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <a class="btn btn-main m-auto" href="javascript:void(0);" id="profile-done">
                                確認
                            </a>
                            <div class="cancelBox">
                                <a data-fancybox data-src="#modal" href="javascript:void(0);" class="text-center t-gray underline d-block mt-1 mb-3">我要取消</a>
                                <!-- popup -->
                                <div style="display: none;" id="modal" class="popup">
                                    <p class="t-11 mb-3 mt-2">確定要去取消此免費賺點的機會嗎？</p>
                                    <a class="btn btn-main w-75 m-auto" href="javascript:void(0);" id="cancel-done">確定</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    
    <script type="text/javascript">
        let msg      = '{{ $msg }}';
        let userInfo = {{ count($userInfo) }};
        let birth    = '{{ $userInfo['birthday'] ?? '' }}';

        $(function () {
            // 檢查是否使用 APP
            if ('' != msg) {
                $('#infoDetail').html('<div class="profile bg-white"><img class="majimama" src="{{ url('/images/maji.png') }}" alt="麻吉妹妹"><p class="text-center t-12">' + msg + '</p></div>');
            }

            // 如未填寫過資料 不顯示“我要取消”按鈕
            if (0 == userInfo) {
                $('.cancelBox').hide();
            }

            // 點擊確認送出資料
            $('body').on('click', '#profile-done', function(e) {
                e.preventDefault();
                let email    = $('input[name=email]').val();
                let sexCd   = $('input[name=sex_cd]:checked').val();
                let year     = $('select[name=year]').val();
                let month    = $('select[name=month]').val();
                let day      = $('select[name=day]').val();
                let prefCd  = $('select[name=pref_cd]').val();

                if (!email) {
                    alert('請輸入email');
                    return;
                }
                if (!sexCd) {
                    alert('請輸入性別');
                    return;
                }
                if (!year) {
                    alert('請選擇生日年份');
                    return;
                }
                if (!month) {
                    alert('請選擇生日月份');
                    return;
                }
                if (!day) {
                    alert('請選擇生日日期');
                    return;
                }
                if (!prefCd) {
                    alert('請選擇居住地');
                    return;
                }

                $.post('/api/investigate', 
                    { 
                        email: email,
                        sexCd: sexCd,
                        birthday: year + ('0'+ month).substr(-2) + ('0'+ day).substr(-2), // 補零
                        prefCd: prefCd
                    }, 
                    function (data) {
                        if (data.return_code == '0000') {
                            $('#infoDetail').html('<p><img class="maji m-auto d-block" src="{{ url('/images/maji-rating-done.png') }}" alt="訂閱問券"></p><p class="text-center t-11 mt-2">資料已送出，感謝您的參與！</p>');
                        } else {
                            $('#infoDetail').html('<p><img class="majimama m-auto d-block" src="{{ url('/images/maji.png?1620636991') }}1" alt="麻吉妹妹"><p class="text-center t-12">' + data.description + '</p><a class="text-center t-gray underline d-block mt-1 mb-3" href="gomaji://mine" style="display: block;">回”我的”頁面</a></p>');
                        }
                        $('#sendBtn').hide();
                        return;
                    }
                );
            });

            // 點擊確認取消
            $('body').on('click', '#cancel-done', function(e) {
                e.preventDefault();
                $.fancybox.close();

                axios["delete"]('/api/investigate').then(function (res) {
                    if (res.data.return_code === '0000') {
                        $('#infoDetail').html('<p><img class="maji m-auto d-block" src="{{ url('/images/maji.png?1620636991') }}" alt="取消訂閱問券"></p><p class="text-center t-11 mt-2">已為您取消<span class="t-danger">【填問卷賺點數】</span>相關服務，<br>感謝您的參與！</p>');
                    } else {
                        $('#infoDetail').html('<p><img class="majimama m-auto d-block" src="{{ url('/images/maji.png?1620636991') }}" alt="麻吉妹妹"><p class="text-center t-12">' + data.description + '</p><a class="text-center t-gray underline d-block mt-1 mb-3" href="gomaji://mine" style="display: block;">回”我的”頁面</a></p>');
                    }
                    $('#sendBtn').hide();
                })["catch"](function (error) {
                    console.error(error);
                });
            });

            let date         = new Date();
            let thisYear     = date.getFullYear();
            let currentYear  = ('' != birth ? birth.substring(0, 4) : 0);
            let currentMonth = ('' != birth ? birth.substring(5, 7) : 0);
            let currentDay   = ('' != birth ? birth.substring(8, 10) : 0);
            let year  = document.getElementById('year');
            let month = document.getElementById('month');
            let day   = document.getElementById('day');

            year.innerHTML  = genOption(thisYear - 120, thisYear, currentYear, '年份');
            month.innerHTML = genOption(1, 12, currentMonth, '月份');
            day.innerHTML   = genOption(1, getDays(currentYear, currentMonth), currentDay, '日期');
            
            // 當年份或月份變動時重新計算天數
            month.onchange = year.onchange = function() {
                day.innerHTML = genOption(1 , getDays(year.value, month.value), currentDay, '日期');
            }

            // 產生選項
            function genOption(start, end, current, type) {
                let options = '<option value="" selected="selected">請選擇' + type + '</option>';
                for (let i = start; i <= end ; i++) {
                    //  判斷是否為預選
                    if (i == current) {
                        options = options + '<option value="' + i + '" selected="selected">' + i + '</option>';
                    } else {
                        options = options + '<option value="' + i + '">' + i + '</option>';
                    }
                }
                return options;
            }

            // 利用月數差計算當月天數
            function getDays(year, month) {
                let dayBefore = new Date();
                let dayAfter  = new Date();
                year  = parseInt(year);
                month = parseInt(month);

                if (0 == year || '' == year) {
                    year = dayBefore.getFullYear();
                }
                if (0 == month || '' == month) {
                    month = dayBefore.getMonth() + 1;
                }

                // 指定年月的一號
                dayBefore.setDate(1);
                dayBefore.setMonth(month - 1);
                dayBefore.setFullYear(year);

                // 指定年月的後一個月一號
                dayAfter.setDate(1);
                dayAfter.setMonth(month);
                dayAfter.setFullYear((12 == month) ? (year + 1) : year);

                return (dayAfter - dayBefore) / 1000 / 60 / 60 / 24; // 把毫秒轉換成天數
            }
        });
    </script>
@endsection