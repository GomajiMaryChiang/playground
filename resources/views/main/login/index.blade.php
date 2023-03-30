@extends('modules.common')

@section('content')
    <main class="main">
        <div class="login-wapper bg-main relative">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="loginads">
                            <a href="{{ url('/app') }}" target="_blank"><img class="d-block" src="{{ url('/images/login-ads_v2.png') }}" alt="GOMAJI APP 下載"></a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12" id="loginStep">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script>
        var g_phone = '';
        var g_gmUid = '';
        var g_code = '';
        var g_resendSeconds = 30;
        var g_verifyCode = '';
        var g_extra = '';
        var g_chooseEmail = '';
        var g_email = '';
        var g_cookie = {};
        var g_isLine = false;

        $(function () {
            // 檢查是否已登入
            checkIsLogin();

            // 顯示填寫手機號碼頁
            showPhoneBlade();

            // 填寫手機號碼頁 - 填寫的手機號碼更動時
            $('body').on('keyup', 'input[type=tel][name=phone]', function () {
                let phoneRegex = /^09[0-9]{8}$/;

                // 確認按鈕是否反灰
                if (phoneRegex.test(this.value)) {
                    g_phone = this.value;
                    $('#submitPhone').removeClass('btn-gray disabled');
                    $('#submitPhone').addClass('btn-main');
                } else {
                    $('#submitPhone').removeClass('btn-main');
                    $('#submitPhone').addClass('btn-gray disabled');
                }
            });

            // 填寫手機號碼頁 - 點選確認按鈕
            $('body').on('click', '#submitPhone', function (e) {
                e.preventDefault();
                curlLogin();
            });

            // 填寫驗證碼頁 - 填寫的驗證碼更動時
            $('body').on('keyup', 'input[type=tel][name^=verifyCode]', function () {
                let code = '';
                let codeRegex = /^[0-9]{4}$/;

                $('input[type=tel][name^=verifyCode]').each(function (index, obj) {
                    if (!obj.value) {
                        $(this).focus();
                        return false;
                    }
                    code += obj.value;
                });

                // 確認按鈕是否反灰
                if (codeRegex.test(code)) {
                    g_code = code;
                    $('#submitVerifyCode').removeClass('btn-gray disabled');
                    $('#submitVerifyCode').addClass('btn-main');
                } else {
                    $('#submitVerifyCode').removeClass('btn-main');
                    $('#submitVerifyCode').addClass('btn-gray disabled');
                }
            });

            // 填寫驗證碼頁 - 點選確認按鈕
            $('body').on('click', '#submitVerifyCode', function (e) {
                e.preventDefault();
                curlVerify();
            });

            // 填寫驗證碼頁 - 點選重發驗證碼
            $('body').on('click', '#resendVerifyCode', function (e) {    
                e.preventDefault();

                if (g_resendSeconds > 0) {
                    swal('請稍候再重發送驗證碼喔！', '', 'warning');
                    return;
                }

                curlLogin();
            });

            // 選擇登入的 email 頁 - 選擇的 email 更動時
            $('body').on('change', 'input[type=radio][name=email]', function () {
                // 確認按鈕是否反灰
                if (typeof(this.value) != 'undefined' && this.value != '') {
                    g_chooseEmail = this.value;
                    $('#submitChooseEmail').removeClass('btn-gray disabled');
                    $('#submitChooseEmail').addClass('btn-main');
                } else {
                    $('#submitChooseEmail').removeClass('btn-main');
                    $('#submitChooseEmail').addClass('btn-gray disabled');
                }
            });

            // 選擇登入的 email 頁 - 點選確認按鈕
            $('body').on('click', '#submitChooseEmail', function (e) {
                e.preventDefault();
                curlBindEmail();
            });

            // 填寫 email 頁 - 填寫的 email 更動時
            $('body').on('keyup', 'input[type=text][name=email]', function () {
                let emailRegex = /^\w+((-\w+)|(\.\w+)|(\+\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

                // 確認按鈕是否反灰
                if (emailRegex.test(this.value)) {
                    g_email = this.value;
                    $('#submitEmail').removeClass('btn-gray disabled');
                    $('#submitEmail').addClass('btn-main');
                } else {
                    $('#submitEmail').removeClass('btn-main');
                    $('#submitEmail').addClass('btn-gray disabled');
                }
            });

            // 填寫 email 頁 - 點選確認按鈕
            $('body').on('click', '#submitEmail', function (e) {
                e.preventDefault();

                if (g_isLine === true) {
                    loginLine();
                } else {
                    loginShopify();
                }
            });

            /*
             * 登入 API
             */
            function curlLogin() {
                axios({
                    method: 'post',
                    url: 'https://ccc.gomaji.com/oneweb/2/user/login',
                    data: {
                        mobile_phone: g_phone
                    },
                    config: {
                        headers: { 'Content-Type': 'application/json' },
                        responseType: 'json',
                    },
                }).then(function(response) {
                    let res = response['data'];
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let gmUid = data.hasOwnProperty('gm_uid') ? data.gm_uid : '';

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        return;
                    }

                    if (!gmUid) {
                        swal('請重新輸入手機號碼', '', 'warning');
                        return;
                    }

                    g_gmUid = gmUid;
                    showVerifyCodeBlade();
                    return;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 確認驗證碼 API
             */
            function curlVerify() {
                axios({
                    method: 'post',
                    url: 'https://ccc.gomaji.com/oneweb/2/user/verify',
                    data: {
                        gm_uid: g_gmUid,
                        mobile_phone: g_phone,
                        code: g_code
                    },
                    config: {
                        headers: { 'Content-Type': 'application/json' },
                        responseType: 'json',
                    },
                }).then(function(response) {
                    let res = response['data'];
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let multiMail = data.hasOwnProperty('multi_mail') ? data.multi_mail : [];
                    let verifyCode = data.hasOwnProperty('verify_code') ? data.verify_code : '';
                    let extra = data.hasOwnProperty('extra') ? data.extra : '';
                    let gomaji = data.hasOwnProperty('gomaji') ? data.gomaji : {};

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    if (multiMail.length !== 0) {
                        g_verifyCode = verifyCode;
                        g_extra = extra;
                        showChooseEmailBlade(multiMail);
                        return;
                    }

                    if (JSON.stringify(gomaji) === '{}') {
                        swal('請重新登入', '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    setCookie(gomaji);
                    return;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 綁定 Email API
             */
            function curlBindEmail() {
                axios({
                    method: 'post',
                    url: 'https://ccc.gomaji.com/oneweb/2/user/bind_email',
                    data: {
                        email: g_chooseEmail,
                        mobile_phone: g_phone,
                        verify_code: g_verifyCode,
                        extra: g_extra
                    },
                    config: {
                        headers: { 'Content-Type': 'application/json' },
                        responseType: 'json',
                    },
                }).then(function(response) {
                    let res = response['data'];
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let gomaji = data.hasOwnProperty('gomaji') ? data.gomaji : {};

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    if (JSON.stringify(gomaji) === '{}') {
                        swal('請重新登入～', '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    setCookie(gomaji);
                    return;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 登入生活市集
             */
            function loginBuy123(url) {
                let t = g_cookie.hasOwnProperty('t') ? g_cookie.t : `{{ $cookieAry['t'] }}`;

                axios({
                    method: 'post',
                    url: '/api/loginBuy123',
                    data: {
                        t
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {

                    if (typeof(response) == 'undefined' || response == '') {
                        window.location.href = url;
                    }

                    let gmcSitePay = $('#gmcSitePay').val();
                    let res = response.data;
                    let param = {
                        gm_uid: $.cookie('gm_uid'),
                        token: res.data.gb_t,
                        ts: res.data.gb_ts,
                        expire_ts: res.data.gb_ets,
                        reg_email: res.data.gb_el
                    };
                    if (gmcSitePay === 'ref_457') {
                        param.s_banner = '85shop';
                    }

                    window.location.href = `https://buy123.gomaji.com/redirect/gomaji_login?${jQuery.param(param)}&redirect=${encodeURI(url)}`;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 登入 ES 商城
             */
            function loginEsmarket(url) {
                let t = g_cookie.hasOwnProperty('t') ? g_cookie.t : `{{ $cookieAry['t'] }}`;

                axios({
                    method: 'post',
                    url: '/api/loginEsmarket',
                    data: {
                        t
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {

                    if (typeof(response) == 'undefined' || response == '') {
                        window.location.href = url;
                    }

                    let urlObj = new URL(url);
                    let res = response.hasOwnProperty('data') ? response.data : {};
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let gb_t = data.hasOwnProperty('gb_t') ? data.gb_t : '';
                    let gb_ts = data.hasOwnProperty('gb_ts') ? data.gb_ts : '';
                    let gb_ets = data.hasOwnProperty('gb_ets') ? data.gb_ets : '';
                    let gb_el = data.hasOwnProperty('gb_el') ? data.gb_el : '';
                    let param = {
                        gm_uid: $.cookie('gm_uid'),
                        gb_t,
                        gb_ts,
                        gb_ets,
                        gb_el
                    };

                    if (urlObj.search === '') {
                        window.location.href = `${url}?${jQuery.param(param)}`;
                    } else {
                        window.location.href = `${url}&${jQuery.param(param)}`;
                    }

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 登入 Shopify
             */
            function loginShopify() {
                let t = g_cookie.hasOwnProperty('t') ? g_cookie.t : `{{ $cookieAry['t'] }}`;
                let gb_el = g_cookie.hasOwnProperty('gb_el') ? g_cookie.gb_el : decodeURIComponent(`{{ $cookieAry['gb_el'] }}`);
                let url = '{{ $goto }}';

                axios({
                    method: 'post',
                    url: '/api/loginShopify',
                    data: {
                        t,
                        gb_el,
                        url,
                        email: g_email
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {

                    if (typeof(response) == 'undefined' || response == '') {
                        swal('登入異常～請稍後再試', '', 'warning');
                        return;
                    }

                    let res = response.hasOwnProperty('data') ? response.data : {};
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let gb_sel = data.hasOwnProperty('gb_sel') ? data.gb_sel : '';
                    let multipassUrl = data.hasOwnProperty('multipass_url') ? data.multipass_url : '';

                    if (returnCode === '6001') {
                        showEmailBlade();
                        return;
                    }

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    document.cookie = `gb_sel=${encodeURIComponent(gb_sel)}; domain=.gomaji.com; path=/`;
                    window.location.href = multipassUrl;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 取得 Shopify 網址
             */
            function redirectShopify() {
                let t = g_cookie.hasOwnProperty('t') ? g_cookie.t : `{{ $cookieAry['t'] }}`;
                let gb_sel = g_cookie.hasOwnProperty('gb_sel') ? g_cookie.gb_sel : decodeURIComponent(`{{ $cookieAry['gb_sel'] }}`);
                let url = '{{ $goto }}';

                axios({
                    method: 'post',
                    url: '/api/redirectShopify',
                    data: {
                        t,
                        gb_sel,
                        url
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {

                    if (typeof(response) == 'undefined' || response == '') {
                        swal('登入異常～請稍後再試！', '', 'warning');
                        return;
                    }

                    let res = response.hasOwnProperty('data') ? response.data : {};
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let multipassUrl = data.hasOwnProperty('multipass_url') ? data.multipass_url : '';

                    if (returnCode === '6001') {
                        showEmailBlade();
                        return;
                    }

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    window.location.href = multipassUrl;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 登入 line
             */
            function loginLine() {
                let l_i = $.cookie('l_i');
                let l_n = $.cookie('l_n');
                let l_e = $.cookie('l_e');
                let gb_el = g_cookie.hasOwnProperty('gb_el') ? g_cookie.gb_el : decodeURIComponent(`{{ $cookieAry['gb_el'] }}`);
                let gm_uid = $.cookie('gm_uid');
                let url = '{{ $goto }}';

                axios({
                    method: 'post',
                    url: '/api/loginLine',
                    data: {
                        l_i,
                        l_n,
                        l_e,
                        gb_el,
                        email: g_email,
                        gm_uid
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {

                    if (typeof(response) == 'undefined' || response == '') {
                        swal('登入異常～請稍後再試～', '', 'warning');
                        return;
                    }

                    let res = response.hasOwnProperty('data') ? response.data : {};
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '';
                    let description = res.hasOwnProperty('description') ? res.description : '';
                    let data = res.hasOwnProperty('data') ? res.data : {};
                    let email = data.hasOwnProperty('email') ? data.email : '';

                    if (returnCode === '6001') {
                        showEmailBlade();
                        return;
                    }

                    if (returnCode !== '0000') {
                        swal(description, '', 'warning');
                        showPhoneBlade();
                        return;
                    }

                    document.cookie = `l_ee=${email}; domain=.gomaji.com; path=/`;
                    window.location.href = url;

                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 顯示填寫手機號碼樣板
             */
            function showPhoneBlade() {
                g_phone = '';
                g_gmUid = '';
                g_code = '';
                g_resendSeconds = 30;
                g_verifyCode = '';
                g_extra = '';
                g_chooseEmail = '';
                g_email = '';

                $('#loginStep').html(`@include('main.login.phone')`);
                $('input[type=tel][name=phone]').focus();
                clearInterval(this.timeinterval);
            }

            /*
             * 顯示填寫驗證碼樣板
             */
            function showVerifyCodeBlade() {
                g_code = '';
                g_resendSeconds = 30;
                g_verifyCode = '';
                g_extra = '';
                g_chooseEmail = '';
                g_email = '';

                $('#loginStep').html(`@include('main.login.verifyCode')`);
                $('input[type=tel][name=verifyCode1]').focus();
                setCountdown();
            }

            /*
             * 顯示選擇 Email 樣板
             */
            function showChooseEmailBlade(emailAry) {
                let emailHtml = '';
                g_chooseEmail = '';
                g_email = '';

                emailAry.forEach(function (value, index) {
                    emailHtml += `
                        <div class="form-check mb-2">
                            <input class="form-check-input mt-2" type="radio" name="email" id="radios${index}" value="${value}">
                            <label class="form-check-label t-11" for="radios${index}">
                                ${value}
                            </label>
                        </div>`;
                });
                $('#loginStep').html(`@include('main.login.chooseEmail')`);
                $('#emailList').html(emailHtml);
            }

            /*
             * 顯示填寫 Email 樣板
             */
            function showEmailBlade() {
                g_email = '';
                $('#loginStep').html(`@include('main.login.email')`);
                $('input[type=text][name=email]').focus();

                if (g_isLine === true) {
                    $('.loginBox .message').text('請提供正確E-mail，以便後續發送優惠券及好康通知唷！');
                }
            }

            /*
             * 倒數重新發送驗證碼
             */
            function setCountdown() {
                let t = 30;
                this.timeinterval = setInterval(() => {
                    if (t <= 0) {
                        clearInterval(this.timeinterval);
                        $('#resendCountdown').hide();
                        $('#resendVerifyCode').show();
                    }

                    t -= 1;
                    g_resendSeconds = t;
                    $('#resendCountdown span').html(t);
                }, 1000);
            }

            /*
             * 寫 cookie
             */
            function setCookie(data) {
                let gm_uid = data.hasOwnProperty('gm_uid') ? data.gm_uid : '';
                let t = data.hasOwnProperty('t') ? data.t : '';
                let gb_t = data.hasOwnProperty('gb_t') ? data.gb_t : '';
                let gb_ts = data.hasOwnProperty('gb_ts') ? data.gb_ts : '';
                let gb_ets = data.hasOwnProperty('gb_ets') ? data.gb_ets : '';
                let gb_el = data.hasOwnProperty('gb_el') ? data.gb_el : '';
                let gb_sel = data.hasOwnProperty('gb_sel') ? data.gb_sel : '';

                document.cookie = `gm_uid=${gm_uid}; domain=.gomaji.com; path=/`;

                axios({
                    method: 'post',
                    url: '/api/setLoginCookie',
                    data: {
                        t,
                        gmm_t: t,
                        gb_t,
                        gb_ts,
                        gb_ets,
                        gb_el: encodeURIComponent(gb_el),
                        reg_email: gb_el,
                        gb_sel: encodeURIComponent(gb_sel),
                    },
                    config: {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        responseType: 'json',
                    },
                }).then(function(response) {
                    if (typeof(response) == 'undefined' || response == '') {
                        swal('登入異常～請稍後再試！！', '', 'warning');
                        return;
                    }
                    g_cookie = data;
                    handleGoto();
                }).catch(function (error) {
                    console.log(error);
                });
            }

            /*
             * 處理登入後要導的連結
             */
            function handleGoto() {
                let url = '{{ $goto }}';
                let urlObj = new URL(url);

                if (decodeURIComponent(url).indexOf('buy123') !== -1) {
                    loginBuy123(url);
                    return;
                }

                if (urlObj.hostname.indexOf('.trippacker.com.tw') !== -1) {
                    loginEsmarket(url);
                    return;
                }

                if (urlObj.hostname.indexOf('myshopify.com') !== -1
                    || urlObj.hostname === 'shop.gomaji.com'
                    || urlObj.hostname === 'shop-dev.gomaji.com'
                ) {
                    handleShopify();
                    return;
                }

                if (urlObj.hostname.indexOf('gomaji.com') !== -1 && urlObj.pathname.indexOf('/event/pcode/coupon93') !== -1) {
                    g_isLine = true;
                    handleLine(url);
                    return;
                }

                window.location.href = url;
            }

            /*
             * 處理 Shopify 登入後的流程
             */
            function handleShopify() {
                let gb_sel = g_cookie.hasOwnProperty('gb_sel') ? g_cookie.gb_sel : `{{ $cookieAry['gb_sel'] }}`;
                let gb_el = g_cookie.hasOwnProperty('gb_el') ? g_cookie.gb_el : `{{ $cookieAry['gb_el'] }}`;

                if (gb_sel) {
                    redirectShopify();
                    return;
                }

                if (gb_el) {
                    loginShopify();
                    return;
                }

                showEmailBlade();
                return;
            }

            /*
             * 處理 line 登入後的流程
             */
            function handleLine(url) {
                let l_i = $.cookie('l_i');
                let l_n = $.cookie('l_n');
                let l_e = $.cookie('l_e');
                let gb_el = g_cookie.hasOwnProperty('gb_el') ? g_cookie.gb_el : `{{ $cookieAry['gb_el'] }}`;

                if (!l_i || !l_n) {
                    window.location.href = url;
                    return;
                }

                if (l_e || gb_el) {
                    loginLine();
                    return;
                }

                showEmailBlade();
                return;
            }

            /*
             * 檢查是否已登入
             */
            function checkIsLogin() {
                let t = `{{ $cookieAry['t'] }}`;
                let gm_uid = $.cookie('gm_uid');

                if (t && gm_uid) {
                    handleGoto();
                }
            }
        });
    </script>
@endsection
