<!-- 填寫手機號碼 -->
<div class="loginBox border border-r">
    <div class="verifyPhone">
        <img class="m-auto d-block" src="{{ url('/images/maji-rating.png') }}" style="width: 35%;" alt="麻吉妹妹感謝您">
        <h2 class="t-main text-center t-13 mb-2 mt-4">手機驗證</h2>
        <p class="t-main text-center t-10 mb-4">為確保您是本人 需先認證您的手機</p>
        <form>
            <input type="tel" placeholder="請輸入手機號碼" maxlength="10" class="form-control" value="" name="phone">
            <a href="#" class="btn btn-gray mt-3 mb-2 d-block disabled" id="submitPhone">同意條款並驗證號碼</a>
            <div class="t-gray text-center t-09">
                <span><a class="t-gray underline" href="{{ url('/terms') }}" target="_blank">服務條款</a></span> 及
                <span><a class="t-gray underline" href="{{ url('/privacy') }}" target="_blank">隱私權政策</a></span>
            </div>
        </form>
    </div>
</div>