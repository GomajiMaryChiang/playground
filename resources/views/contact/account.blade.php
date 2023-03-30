@extends('modules.common')

@section('content')
    @if ($account['action_cd'] == 1)
        <div class="account-note">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="text-left">回填完整資料送30點，日後還能不定期收到專屬優惠喔！</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <main class="main accountBox">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p class="sub-head">基本資料</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 bg-white">
                    <form class="account-infoBox">
                        <!-- 手機 -->
                        <div class="form-group">
                            <div class="d-flex bd-highlight">
                                <label class="label-icon i-cellphone-gray">手機</label>
                                <p class="ml-auto bd-highlight">已認證</p>
                            </div>
                            <input class="form-control" type="text" placeholder="{{ $account['mobile_phone'] }}" aria-label="Disabled" disabled>
                        </div>
                        <!-- Emial -->
                        <div class="form-group">
                            <label class="label-icon i-mail-account">信箱</label>
                            <input class="form-control" type="text" placeholder="{{ $account['email'] }}" aria-label="Disabled" disabled>
                        </div>
                        <!-- 性別 -->
                        <div class="form-group">
                            <label class="label-icon i-gender">性別</label>
                            <div class="form-checkBox">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex_cd" id="genderMale" value="1" @if ($account['sex_cd'] == 1) checked @endif>
                                    <label class="form-check-label" for="genderMale">男性</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex_cd" id="genderFemale" value="2" @if ($account['sex_cd'] == 2) checked @endif>
                                    <label class="form-check-label" for="genderFemale">女性</label>
                                </div>
                            </div>
                        </div>
                        <!-- 生日 -->
                        <div class="form-group">
                            <div class="d-flex bd-highlight">
                                <label class="label-icon i-birthday">生日</label>
                                <p class="ml-auto bd-highlight">送出後將無法修改</p>
                            </div>
                            <input class="birthday date form-control" type="text" name="birthday" maxlength="10" id="datepicker" placeholder="yyyy/mm/dd" @if (!empty($account['birthday'])) value="{{ $account['birthday'] }}" disabled @endif>
                        </div>
                        <!-- 婚姻 -->
                        <div class="form-group">
                            <label class="label-icon i-love-gray">婚姻狀況</label>
                            <div class="form-checkBox">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="marital_status" id="married" value="1" @if ($account['marital_status'] == 1) checked @endif>
                                    <label class="form-check-label" for="married">已婚</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="marital_status" id="unmarried" value="2" @if ($account['marital_status'] == 2) checked @endif>
                                    <label class="form-check-label" for="unmarried">單身</label>
                                </div>
                            </div>
                        </div>
                        <!-- 小孩-->
                        <div class="form-group">
                            <label class="label-icon i-child">子女</label>
                            <div class="form-checkBox">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="child" id="positive" value="1" @if ($account['child'] == 1) checked @endif>
                                    <label class="form-check-label" for="positive">有</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="child" id="negative" value="2" @if ($account['child'] == 2) checked @endif>
                                    <label class="form-check-label" for="negative">無</label>
                                </div>
                            </div>
                        </div>
                        <!-- 居住地-->
                        <div class="form-group">
                            <label class="label-icon i-place">居住地</label>
                            <select name="city" class="form-control select">
                                <option value="0">請選擇地區</option>
                                @foreach ($cityList as $key => $value)
                                    <option value="{{ $value['id'] }}" @if ($account['city_id'] == $value['id']) selected @endif>{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 bg-white mt-2">
                    <form class="submitBox">
                        <a href="javascript:void(0)">
                            <button type="submit" class="btn-submit btn btn-main">確認送出</button>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Popup: 狀況一 未完成 -->
    <div style="display: none;" id="incomplete-1" class="popupBox w-25">
        <h2 data-selectable="true" class="t-main">感謝您的填寫</h2>
        <div class="incompleteBox">
            <p class="p-content test-center">就差一步！填寫完整資料即可獲贈30點！</p>
            <p class="mt-3 d-flex">
                <a class="close-fancybox btn btn-gray flex-fill bd-highlight mr-3 goBack" data-fancybox-close href="javascript:void(0)">下次再說</a>
                <a class="close-fancybox btn btn-main flex-fill bd-highlight" data-fancybox-close href="javascript:void(0)">好，馬上填寫</a>
            </p>
        </div>
    </div>
    <!-- End: 狀況一 -->
    <!-- Popup: 狀況二 完成 -->
    <div style="display: none;" id="incomplete-2" class="popupBox w-25">
        <h2 data-selectable="true" class="t-main">感謝您的填寫</h2>
        <div class="incompleteBox">
            <p class="p-content">我們將送您 GOMAJI 點數30點，日後還能不定期收到專屬優惠喔！</p>
            <p class="mt-3"><a class="btn btn-main" data-fancybox-close href="javascript:void(0)">謝謝您</a></p>
        </div>
    </div>
    <!-- End: 狀況二 -->
    <!-- Popup: 狀況三 更新資料 -->
    <div style="display: none;" id="incomplete-3" class="popupBox w-25">
        <h2 data-selectable="true" class="t-main">感謝您的填寫</h2>
        <div class="incompleteBox">
            <p class="p-content">您的個人資料已更新。</p>
            <p class="mt-3"><a class="btn btn-main" data-fancybox-close href="javascript:void(0)">關閉</a></p>
        </div>
    </div>
    <!-- End: 狀況三 -->
    <!-- Popup: 狀況四 其他 -->
    <div style="display: none;" id="incomplete-4" class="popupBox w-25">
        <h2 data-selectable="true" class="t-main"></h2>
        <div class="incompleteBox">
            <p class="p-content"></p>
            <p class="mt-3"><a class="btn btn-main" data-fancybox-close href="javascript:void(0)">關閉</a></p>
        </div>
    </div>
    <!-- End: 狀況四 -->
    <input type="hidden" id="isApp" value="{{ $isApp }}">
    <input type="hidden" id="gm_uid" value="{{ $account['gm_uid'] }}">
    <input type="hidden" id="action_cd" value="{{ $account['action_cd'] }}">
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('js/assets/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/assets/jquery-ui-datepicker-zh-TW.js') }}"></script>
    <script>
        $(function() {
            var submitted = false;
            var isApp = $('#isApp').val();
            var gm_uid = $('#gm_uid').val();
            if (!gm_uid) {
                gm_uid = 0;
            }
            var action_cd = $('#action_cd').val();
            if (!action_cd) {
                action_cd = 1;
            }
            $('#topBtn').remove();
            /*--- DatePicker 日期選擇器 --- */
            var currentMonth = new Date().getMonth();
            var defaultDate = `1990/${currentMonth + 1}/1`; // 預設1990年/當下月份/1號
            $("#datepicker").datepicker({
                firstDay: 1,
                showOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:c', // 1900 <-> current year
                dateFormat: "yy/mm/dd", // yyyy/mm/dd
                defaultDate: defaultDate,
            });
            $(".date").mousedown(function () {
                $(".ui-datepicker").addClass("active");
            });
            /*--- End: DatePicker 日期選擇器 --- */

            $('.goBack').on('click', function() {
                if (isApp) {
                    window.location = 'GOMAJI://mine';
                } else {
                    history.go(-1);
                }
            });

            $(document).on('click', '.btn-submit', function(e) {
                e.preventDefault();
                if (submitted == true) {
                    // 如果是「提交中」則不繼續
                    return;
                }
                submitted = true; // 表單狀態改為「提交中」
                var sex_cd = $('input[name="sex_cd"]:checked').val(); // 性別
                if (!sex_cd) {
                    sex_cd = 0;
                }
                var marital_status = $('input[name="marital_status"]:checked').val(); // 婚姻
                if (!marital_status) {
                    marital_status = 0;
                }
                var child = $('input[name="child"]:checked').val(); // 子女
                if (!child) {
                    child = 0;
                }
                var city = $('select[name="city"]').val(); // 城市
                if (!city) {
                    city = 0;
                }
                var birthday = $('input[name="birthday"]').val(); // 生日
                if (!birthday) {
                    birthday = '';
                }

                /*--- 有欄位未填寫--- */
                if (birthday ==''
                    || marital_status == 0
                    || child == 0
                    || city == 0
                    || sex_cd == 0
                ) {
                    $.fancybox.open({
                        src: '#incomplete-1',
                        afterClose: function() {
                            submitted = false; // 提交狀態解除
                        }
                    })
                    return;
                }
                /*--- End: 有欄位未填寫--- */

                /*--- 送出資料--- */
                $.post('/api/account', {
                    action_cd,
                    gm_uid,
                    sex_cd,
                    marital_status,
                    child,
                    city,
                    birthday,
                }, function(apiReturn) {
                    let return_code = apiReturn['return_code'];
                    if (!return_code) {
                        return_code = 0;
                    }
                    let description = apiReturn['description'];
                    if (!description) {
                        description = '';
                    }
                    /* --- API返回錯誤 --- */
                    if (apiReturn['return_code'] != '0000') {
                        $('#incomplete-4 .t-main').text('發生問題');
                        $.fancybox.open({
                            src: '#incomplete-4',
                            beforeShow: function() {
                                if (return_code == '102') {
                                    $('#incomplete-4 .p-content').text(description);
                                    return;
                                }
                                // $('#incomplete-4 .p-content').text('請稍後再試試看。');
                                $('#incomplete-4 .p-content').text(`(${return_code}) ${description}`);
                            },
                            afterClose: function() {
                                submitted = false; // 提交狀態解除
                            }
                        });
                        return;
                    };
                    /* --- End: API返回錯誤 --- */

                    // 首次填寫打開「感謝提交，給你30點」，其他則打開「資料已更新」
                    let fancybox = (action_cd == 1) ? '#incomplete-2' : '#incomplete-3';
                    action_cd = 2; // 帳號狀態由「初次填寫」改為「修改資料」
                    $('.account-note').remove(); // 移除上方紅色的「填完給30點」提醒區塊
                    $('input[name="birthday"]').prop('disabled', true); // 生日欄位填入後無法修改
                    $.fancybox.open({
                        src: fancybox,
                        afterClose: function() {
                            submitted = false; // 提交狀態解除
                        }
                    });
                })
                /*--- End: 送出資料--- */
            })
        })
    </script>
@endsection
