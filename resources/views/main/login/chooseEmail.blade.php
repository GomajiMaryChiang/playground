<!-- 選擇登入的 email -->
<div class="loginBox border border-r">
    <div class="verifyPhone">
        <img class="m-auto d-block" src="{{ url('/images/maji-rating.png') }}" style="width: 35%;" alt="@lang('麻吉妹妹感謝您')">
        <h2 class="t-main text-center t-13 mb-2 mt-4">@lang('E-MAIL 確認')</h2>
        <p class="t-main t-10 mb-4">@lang('請選擇一組您欲登入的 E-MAIL，以便後續交易及通知使用！')</p>
        <form>
            <div id="emailList"></div>
            <a href="#" class="btn btn-gray mt-3 mb-2 d-block disabled" id="submitChooseEmail">@lang('確認')</a>
        </form>
    </div>
</div>