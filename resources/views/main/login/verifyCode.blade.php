<!-- 填寫手機號碼驗證碼 -->
<div class="loginBox border border-r">
    <div class="verifyPhone">
        <img class="m-auto d-block" src="{{ url('/images/maji-rating.png') }}" style="width: 35%;" alt="麻吉妹妹感謝您">
        <h2 class="t-main text-center t-13 mb-2 mt-4">手機驗證</h2>
        <p class="t-main text-center t-10 mb-4">為確保您是本人 需先認證您的手機</p>
        <div class="verify">
            <p class="text-center t-gray">請輸入簡訊收到的四位數認證碼</p>
            <div class="d-flex bd-highlight w-75 m-auto">
                <input type="tel" class="otp flex-fill bd-highlight" maxlength="1" value="" name="verifyCode1">
                <input type="tel" class="otp flex-fill bd-highlight" maxlength="1" value="" name="verifyCode2">
                <input type="tel" class="otp flex-fill bd-highlight" maxlength="1" value="" name="verifyCode3">
                <input type="tel" class="otp flex-fill bd-highlight" maxlength="1" value="" name="verifyCode4">
            </div>
            <a href="#" class="btn btn-gray mt-3 mb-2 d-block disabled" id="submitVerifyCode">驗證</a>
            <p class="text-center t-09 t-gray" id="resendCountdown">重新發送 <span></span></p>
            <a href="#" class="text-center t-09 t-primary d-block" id="resendVerifyCode" style="display: none !important;">重發驗證碼</a>
        </div>
    </div>
</div>