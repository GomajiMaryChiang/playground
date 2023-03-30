
<!-- 填寫手機號碼 -->
<body>
    <div class="loginBox border border-r">
        <div class="verifyPhone">
            <h2 class="t-main text-center t-13 mb-2 mt-4">手機驗證</h2>
            <p class="t-main text-center t-10 mb-4">為確保您是本人 需先認證您的手機</p>
            <form>
                <input type="tel" placeholder="請輸入手機號碼" maxlength="10" class="form-control" value="" name="phone"><br />
                <a href="#" style="width:150px;height:50px;" id="submitPhone">同意條款並驗證號碼</a>
            </form>
        </div>
    </div>
</body>

<script src="{{ asset('js/assets/jquery.min.js?1671419877') }}"></script>
<!-- <script src="{{ asset('js/assets/axios.min.js?1671419877') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script>

    var g_phone = '';

    $(function () {

        // 填寫手機號碼頁 - 填寫的手機號碼更動時
        $('body').on('keyup', 'input[type=tel][name=phone]', function () {
            let phoneRegex = /^09[0-9]{8}$/; // 驗證手機號碼需數值並且為8位數

            // 確認按鈕是否反灰
            if (phoneRegex.test(this.value)) {
                g_phone = this.value;
                // $('#submitPhone').removeClass('btn-gray disabled');
                // $('#submitPhone').addClass('btn-main');
            } else {
                // $('#submitPhone').removeClass('btn-main');
                // $('#submitPhone').addClass('btn-gray disabled');
            }
        });

        // 填寫手機號碼頁 - 點選確認按鈕
        $('body').on('click', '#submitPhone', function (e) {
            e.preventDefault(); // 防止url連結被開啟
            curlLogin();
        });
    });

    /*
    * 登入 API
    */
    function curlLogin() {//console.log(g_phone);return false;
        axios({
            method: 'post',
            url: '/api/login',
            data: {
                mobile_phone: g_phone
            },
            /*config: {
                headers: { 'Content-Type': 'application/json' },
                responseType: 'json',
            },*/
        }).then(function(response) {
            let res = response['data'];console.log(res);return false;
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
</script>