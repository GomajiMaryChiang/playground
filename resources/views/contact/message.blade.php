@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">客服留言瀏覽系統</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main main-contact">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/help') }}">客服中心</a></li>
                            <li class="breadcrumb-item active" aria-current="page">客服留言瀏覽系統</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper border border-r">
                        <p><i class="i-help-mail"></i></p>
                        <h2 class="text-center">有任何建議都歡迎聯絡我們！</h2>

                        <!-- 留言列表 -->
                        @if (!empty($messageList))
                            <div class="recordBox">
                                @foreach ($messageList as $message)
                                    <div class="record-message">
                                        <p class="t-gray">
                                            {{ $message['reply_ts'] ?? '' }}
                                            <span class="t-main ml-2">
                                                @if (isset($message['support_id']) && $message['support_id'] > 0)
                                                    客服回覆
                                                @else
                                                    {{ $message['name'] ?? '' }}留言
                                                @endif
                                            </span>：
                                        </p>
                                        <p class="mt-2 t-11">{{ $message['content'] ?? '' }}</p>
                                    </div>
                                @endforeach

                                <!-- 回覆留言 -->
                                @if ($messageStatus != 4)
                                    <div class="record-message" id="replyMessageBlock">
                                        <textarea class="form-control" id="messageContent" rows="5"></textarea>
                                        <button class="btn btn-main mt-3" id="replyMessage">回覆留言</button>
                                    </div>
                                @endif
                                <!-- End: 回覆留言 -->
                            </div>
                        @endif
                        <!-- End: 留言列表 -->

                        <!-- 重新建立留言 -->
                        @if ($messageStatus == 4)
                            <div class="message required-text text-center mt-5 pb-3">
                                本問題已結案，如有新問題請重新建立留言<a href="{{ url('/help/contact/6') }}">
                                    <button class="d-inline btn-main pl-2 pr-2 ml-1">重新建立留言</button>
                                </a>
                            </div>
                        @endif
                        <!-- End: 重新建立留言 -->

                        <div class="help-info-warpper">
                            <div class="row no-gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="help-info">
                                        <p class="text-center"><a class="underline t-main t-14" href="{{ url('/help/contact/6') }} ">客服信箱</a></p>
                                        <p class="text-center mb-2 t-main t-11">02-2711-1758</p>
                                        <p class="text-center">(週一至週五 9:00AM ~ 6:00PM)<br>建議 / 退費 / 疑問 / 合作<br>我們為客戶隨時隨地解決任何問題。</p>
                                    </div>
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
    <script>
        $(function () {
            $('#replyMessage').click(function (e) {
                e.preventDefault();

                let messageId = '{{ $messageId }}';
                let messageContent = $('#messageContent').val().trim();

                if (messageContent == '') {
                    swal('請輸入留言內容呦～', '', 'warning');
                    return;
                }

                axios({
                    method: 'post',
                    url: '/api/message',
                    data: { messageId, messageContent },
                    config: {
                        headers: { 'Content-Type': 'multipart/form-data' },
                        responseType: 'json',
                    },

                }).then(function(response) {
                    let appendMessage = '';
                    let res = response.hasOwnProperty('data') ? response.data :{};
                    let returnCode = res.hasOwnProperty('return_code') ? res.return_code : '0';
                    let description = res.hasOwnProperty('description') ? res.description : '留言失敗>< 請稍後再試～';
                    let data = res.hasOwnProperty('data') ? res.data : {};

                    if (returnCode != '0000') {
                        swal(`${description}（${returnCode}）`, '', 'warning');
                        return;
                    }
                    
                    appendMessage = `
                        <div class="record-message">
                            <p class="t-gray">
                                ${data.reply_ts}
                                <span class="t-main ml-2">
                                    ${data.name}留言
                                </span>：
                            </p>
                            <p class="mt-2 t-11">${data.content}</p>
                        </div>
                    `;
                    $('#replyMessageBlock').before(appendMessage);
                    $('#messageContent').val('');

                }).catch(function (error) {
                    console.log(error);
                });
            });
        });
    </script>
@endsection