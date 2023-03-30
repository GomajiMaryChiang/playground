@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">我要評價</h1>
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
                        <ol class="breadcrumb rating">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">我要評價</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper rating-wrapper border border-r">
                        <p><img class="maji" src="{{ url('/images/maji-rating.png') }}" alt="麻吉妹妹感謝您"></p>
                        <p class="text-center sub-title t-12">感謝您對 GOMAJI 的支持，如有任何疑問或建議，請您不吝指教。謝謝！</p>
                        <div class="contactBox">
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="title">商品名稱</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <h3 class="store-name">{{ $data['product_name'] }}</h3>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="title">核銷日期</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <h3 class="store-name">{{ $use_time }}</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="rating-sub-title">評價</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <label class="rating-smile {{ empty($data['rating_history']) ? '' : 'rating_' . $data['rating_history']['rating'] }}">
                                        <span data-rating="1">&nbsp;</span>
                                        <span data-rating="2">&nbsp;</span>
                                        <span data-rating="3">&nbsp;</span>
                                        <span data-rating="4">&nbsp;</span>
                                        <span data-rating="5">&nbsp;</span>
                                    </label>
                                    <p id="rating-word" class="rating_00 {{ empty($data['rating_history']) ? 'rating_0_0' : 'rating_0_' . $data['rating_history']['rating'] }}">請按笑臉給予滿意度評價！</p>
                                    <select name="review_id" class="mt-3 form-control check-select w-75" style="display: none">
                                        @foreach ($data['filter_low_rated_reviews'] as $review)
                                            <option selected="" value="{{ $review['review_id'] }}">{{ $review['review'] }}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="rating-sub-title second">特色<br>推薦</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <div class="rating-category">
                                        @foreach ($data['rating_type'] as $type)
                                            <a href="javascript:void(0)" data-value="{{ $type['id'] }}" class="@if (!empty($data['rating_history']['rating_type']) && (in_array($type['id'], $data['rating_history']['rating_type']))){{ 'on' }}@else{{ '' }}@endif">{{ $type['comment_type'] }}</a>
                                        @endforeach
                                        <p class="t-09 t-main">請選擇此店家您最推薦的項目，可複選，最多三項。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-3 col-sm-12 col-12">
                                    <label class="rating-sub-title">意見</label>
                                </div>
                                <div class="col-md-9 col-sm-12 col-12">
                                    <textarea id="comment" name="comment" cols="60" class="form-control rating-textarea mb-1" rows="6" maxlength="120" placeholder="為尊重評價機制，發表內容GOMAJI不主動進行審查。評價採公開性質，須負法律責任。請勿發表毀謗、謾罵、不實或惡意評價、色情、人身攻擊、個資或隱私權等違反法律行為。若經判斷違反使用規則或逾合理評論將進行移除。">@if(!empty($data['rating_history'])){{ $data['rating_history']['comment'] }}@endif</textarea>
                                    <p class="t-gray t-09 mb-2">尚可輸入<span id="comment-length">120</span>個字每筆兌換券序號可評價一次，評價過後不可再重複評價。</p>
                                    <p class="t-gray t-09">兌換使用後30天可進行評價及一次修改，請把握時間分享您的心得體驗喔！</p>
                                </div>
                            </div>
                            <div class="row no-gutters input-group contact-panel">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <a id="submit" class="btn btn-main m-auto w-75" href="javascript:;" role="button">
                                        送出評價
                                    </a>
                                </div>
                            </div>
                        </div>
                        <form id="form" action="{{ url('/rating-done') }}" method="POST" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="cmd" value="{{ $cmd ?? '' }}">
                            <input type="hidden" name="version" value="{{ $version ?? '' }}">
                            <input type="hidden" name="purchaseId" value="{{ $purchaseId ?? '' }}">
                            <input type="hidden" name="rating" value="">
                            <input type="hidden" name="response" value="">
                            @if (!empty($data['rating_history']))
                                <input type="hidden" name="mod" value="1">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection

@section('script')
    <script>
        /*-- 評價Start --*/

        let reviewId = null //低評等id，當rating <= 2時才看
        let ratingWordArray = {
            '1': '非常不滿意！',
            '2': '不滿意！',
            '3': '普通！',
            '4': '滿意！',
            '5': '非常滿意！',
        }
        let ratingFrom = '{{ $data['rating_from'] ?? '' }}';
        let rating = {{ $data['rating_history']['rating'] ?? 0 }};
        if (rating != '') {
            // 評價低於普通會顯示下拉選項
            if (rating <= 2) {
                $('select[name=review_id]').css('display', 'block')
                reviewId = $('select[name=review_id]').val()
            } else {
                $('select[name=review_id]').css('display', 'none')
                reviewId = null
            }
            // 顯示評價滿意程度
            $('#rating-word').text(ratingWordArray[rating])
        }

        $('.rating-smile>span').on('click', function(){
            let newRating = $(this).attr('data-rating');console.log(newRating)
            $(this).parent().removeClass('rating_'+rating)
            $(this).parent().addClass('rating_'+newRating)
            if (newRating <= 2) {
                $('select[name=review_id]').css('display','block')
                reviewId = $('select[name=review_id]').val()
            } else {
                $('select[name=review_id]').css('display','none')
                reviewId = null
            }
            console.log('rating_'+rating+'_0')
            $('#rating-word').removeClass('rating_0_'+rating)
            $('#rating-word').addClass('rating_0_'+newRating)
            $('#rating-word').text(ratingWordArray[newRating])
            rating = newRating
        })

        $('select[name=review_id]').on('change', function(){
            reviewId = $('select[name=review_id]').val()
        })

        /*-- 評價End --*/

        /*-- 選擇特色推薦Start --*/

        let ratingTypeNum = {{ $ratingTypeNum }};
        let ratingTypeArray = []
        // 若已經有推薦的項目內容
        if (ratingTypeNum != 0) {
            ratingTypeList = {!! $ratingTypeArr !!}
            ratingTypeList.forEach(function(val, index, arr) {
                ratingTypeArray[index] = val;
            })
        }

        $('.rating-category > a').click(function(event) {
            let ratingType = $(this).attr('data-value')
            if ($(this).hasClass('on')) {
                $(this).removeClass('on')
                ratingTypeArray = $.grep(ratingTypeArray, function( n, i ) {
                    return ( n != ratingType )
                })
                ratingTypeNum -= 1
            } else {
                if (ratingTypeNum == 3) {
                    alert('最多只能選三項')
                } else {
                    $(this).addClass('on')
                    ratingTypeArray.push(ratingType)
                    ratingTypeNum += 1
                }
            }
        })
        /*-- 選擇特色推薦End --*/

        /*-- 意見Start --*/
        let commentLength = 120
        let writeLength = 0
        let commentRecord = $("#comment").val().length;

        // 檢查是否有留言內容
        if (commentRecord != 0) {
            commentLengthRemain = commentLength - commentRecord;
            // 更新限制的長度
            $('#comment-length').text(commentLengthRemain);
        }

        $('#comment').on('keyup', function(){
            writeLength = $(this).val().length;
            $('#comment-length').text(commentLength - writeLength)
        })
        /*-- 意見End --*/

        /*-- 是否贈點 --*/
        let isSendPoint = {{ $isSendPoint }};
        let mod = {{ $mod }};

        $('#submit').on('click', function(){
            // 由於複製貼上時，不會觸發 keyup 事件，變數 writeLength 不會更新值，所以送出表單時，重新抓一次意見欄字數比較準確
            let writeCommentLength = $('#comment').val().length;

            if (rating <= 0) {
                alert('請至少給我們總體評價')
                return false
            }

            if (rating <= 2 && writeCommentLength == 0) {
                alert('請於意見欄描述此次消費不滿意的狀況，以提供給店家改進參考，謝謝您！')
                return false
            }

            if ($('#comment-length').val().length > 120) {
                alert('評價不能超過120個字喔')
                return false
            }

            // [Feature #4456] UE_宅配商品好評機制
            // 2.評價為三星(含)以上未留言，送出評價時需跳alert提醒
            // 3.僅於app透過訂單的「請評價」可獲得贈點；若透過任何連結進入評價則不贈點
            // 贈點的而且不是再次修改的
            if (isSendPoint == 1 && mod == 0 && writeCommentLength < 10 && ratingFrom != 'email') {
                $.fancybox.open({
                    src  : `<div class="popup w-30">
                                <p class="t-11 mb-4 mt-2 text-center">哇～謝謝您的評價！<br>是否再寫下你的開箱心得讓更多人參考呢？為感謝您的分享（至少10個字），送出後即可獲贈點數喔！</p>
                                <p class="d-flex justify-content-center">
                                    <a class="btn btn-main w-25 mr-3" data-fancybox-close href="javascript:;">好，馬上寫</a>
                                    <a class="btn btn-main w-25" href="javascript:;" onclick="sendRating();">忍痛放棄</a>
                                </p>
                            </div>`,
                    type : 'inline',
                    opts : {
                        toolbar  : false,
                        smallBtn : false,
                        clickSlide : false,
                    }
                });
                return false
            }

            if (rating >= 4 && writeCommentLength == 0 && ratingFrom != 'email') {
                $.fancybox.open({
                    src  : `<div class="popup w-30">
                                <p class="t-11 mb-4 mt-2 text-center">哇～您給了很棒的評價！<br>是否再寫下您的美好體驗及意見讓更多人參考呢？</p>
                                <p class="d-flex justify-content-center">
                                    <a class="btn btn-main w-25 mr-3" data-fancybox-close href="javascript:;">返回留言</a>
                                    <a class="btn btn-main w-25" href="javascript:;" onclick="sendRating();">不了，直接送出</a>
                                </p>
                            </div>`,
                    type : 'inline',
                    opts : {
                        toolbar  : false,
                        smallBtn : false,
                        clickSlide : false,
                    }
                });
                return false
            }

            sendRating();
        })

        function sendRating()
        {
            $('#submit').addClass("disabled"); // 點選送出評價按鈕後，即更改為disabled狀態
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  //Laravel內建csrf驗證
                }
            });
            $.ajax({
                type: 'POST',
                url: '/sendRatingForm',
                data: {
                    c: '{{ $c ?? '' }}',
                    mod: '{{ $mod ?? '' }}',
                    rating: rating,
                    reviewId: reviewId,
                    ratingType: ratingTypeArray,
                    comment: $('#comment').val(),
                },
                beforeSend: function() {
                    $.fancybox.open({
                        src  : `<div>
                                    <img src="{{ url('/images/loading-1.gif') }}" alt="麻吉妹妹">
                                </div>`,
                        type : 'inline',
                        opts : {
                            toolbar  : false,
                            smallBtn : false,
                            clickSlide : false,
                        }
                    });
                    $('.fancybox-stage').css('background', 'white')
                },
                success: function(res) {
                    if (res.return_code === '0000') {
                        res = JSON.stringify(res['data'])
                        $('input[name=response]').val(res)
                        $('input[name=rating]').val(rating)
                        $('#form').submit()
                    } else if(res.return_code === '3103') {
                        alert(res['description'])
                        window.history.back()
                        $('#submit').removeClass("disabled"); // 將送出評價按鈕刪除disabled狀態
                    } else {
                        alert(res['description'])
                        $('#submit').removeClass("disabled"); // 將送出評價按鈕刪除disabled狀態
                    }
                    $.fancybox.close();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('停留網頁過久～請重新整理後再評價')
                    $.fancybox.close();
                    $('#submit').removeClass("disabled"); // 將送出評價按鈕刪除disabled狀態
                },
            })
        }
    </script>
@endsection
