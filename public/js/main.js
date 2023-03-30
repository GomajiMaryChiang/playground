// topBtn 滑上至top scroll up
$(function () {
    $(window).scroll(function () {
        var target = $(".topBtn");
        var isVisible = target.is(":visible");
        if ($(window).scrollTop() >= 600) {
            if (!isVisible) target.show();
        } else {
            if (isVisible) target.hide();
        }
    });
    $(".topBtn").on('click',function (event) {
        $('html,body').animate({
            scrollTop: '0'
        },1000);
    });
});

$(function() {
    /* pc mm header - 點選搜尋送出按鈕 */
    $('.searchbarBox').find('button[type="submit"]').click(function(e) {
        e.preventDefault();

        let thisObj = $(this);
        let searchText = thisObj.siblings('input[type="text"]').val();

        // 如果有輸入搜尋文字，才送出表單
        if (searchText != '') {
            thisObj.closest('form').submit();
        }
    });

    /* pc header - 點選城市按鈕 */
    $('#dropdownMenu').click(function() {
        $("#popularWrap").slideUp(300, function() {}); // 將搜尋的下拉選單收起來
        $('#cityarea-wrap').slideToggle(300, function() {}); // Show or NotShow 城市下拉選單
    });

    /* pc header - 點選子城市按鈕 */
    $('.city-list li').click(function() {               // on tab click
        if ($(this).hasClass('selected') === false) { // if tab is not selected
            $('.city-list li').removeClass('selected');    // remove class 'selected'
            $(this).addClass('selected');             // mark selected tab
        }
        var tabSelection = $(this).attr('id');    // determine tab relation
        $('.city-content').fadeOut('fast', function() { // fade out content
            $('div .page').css('display', 'none');   // hide all content
            $('#content-' + tabSelection).css('display', '');  // display selected tab
            $('.city-content').fadeIn('fast');           // fade the content in slowly
        });
    });

　　$(document).bind('click', function(e) {
        /* pc header - 點選搜尋下拉選單的其他區塊 */
        if ($(e.target).closest('#popularWrap').length == 0 && $(e.target).closest('input').length == 0){
            $("#popularWrap").slideUp(300, function() {});
        }

        /* pc header - 點選城市下拉選單的其他區塊 */
        if ($(e.target).closest('#cityarea-wrap').length == 0 && $(e.target).closest('input').length == 0){
            $("#cityarea-wrap").slideUp(300, function() {});
        }
    });

    /* mm header - 點選反灰區塊 */
    $('.overlay').click(function(e) {
        e.preventDefault();
        notShowSearchDropdown(); // 將搜尋的下拉選單收起來
    });

    /* mm header - 點選搜尋按鈕 */
    $('#searchtoggle').click(function(e) {
        e.preventDefault();
        notShowCityDropdown(); // 將城市的下拉選單收起來
        $('.overlay').toggleClass('show'); // Show or NotShow 背景反灰
        $('#searchbarBox').slideToggle(300, function() {}); // Show or NotShow 搜尋下拉選單
    });

    /* mm header - 搜尋輸入框內容改變時 */
    $('#mm-search-bar').keyup(function(e) {
        var searchText = $(this).val();

        // 輸入框有值顯示刪除按鈕
        if (!searchText || searchText == '') {
            $('#mm-search-remove').hide();
        } else {
            $('#mm-search-remove').show();
        }
    });

    /* mm header - 點選刪除搜尋文字的按鈕 */
    $('#mm-search-remove').click(function(e) {
        e.preventDefault();
        $('#mm-search-bar').val('');
        $('#mm-search-remove').hide();
    });

    /* mm header - 點選城市按鈕 */
    $('#dropdownButton').click(function(e) {
        e.preventDefault();
        notShowSearchDropdown(); // 將搜尋的下拉選單收起來
        $('#dropdown-menu').slideToggle(300, function() {}); // Show or NotShow 城市下拉選單
    });

    /* mm header - 點選側邊欄按鈕 */
    $('#nav-open').click(function(e) {
        e.preventDefault();
        notShowSearchDropdown();
        notShowCityDropdown();
        $('#nav-input').prop('checked', true);
    });

    /* mm header - 點選側邊欄反灰區塊 */
    $('#nav-close').click(function(e) {
        e.preventDefault();
        $('#nav-input').prop('checked', false);
    });

    /* pc mm header - 點選登出按鈕 */
    $('.logout').click(function(e) {
        e.preventDefault();
        logout('登出成功');
    });

    /* pc mm header - 是否要自動登出 */
    let autoLogout = $('#autoLogout').val();
    if (autoLogout) {
        logout(autoLogout);
    }

    /* autocomplete start */
    let cookieKeywords = [];
    let searchKeywords = $('#searchKeywords').val();
    try {
        if (searchKeywords) {
            let keywords = JSON.parse(searchKeywords);
            cookieKeywords = keywords.reverse();
        }
    } catch (e) {
        console.log('cookie search-keywords : ' + searchKeywords);
        console.log(e);
    }
    if (document.getElementById('search-bar')) {
        $('#search-bar').attr('autocomplete', 'off');
        autocomplete(document.getElementById('search-bar'), {
            autocompleteUrl: 'https://ccc.gomaji.com/oneweb/autocomplete',
            cleanDefault: true,
            defaultKeyword: cookieKeywords,
            cleanDefaultCallback: deleteSearchKeyword,
            plat: 'pc'
        });
    }
    if (document.getElementById('mm-search-bar')) {
        $('#mm-search-bar').attr('autocomplete', 'off');
        autocomplete(document.getElementById('mm-search-bar'), {
            autocompleteUrl: 'https://ccc.gomaji.com/oneweb/autocomplete',
            cleanDefault: true,
            defaultKeyword: cookieKeywords,
            cleanDefaultCallback: deleteSearchKeyword,
            plat: 'mm'
        });
    }
    /* autocomplete end */
});

/*
 * 將搜尋的下拉選單收起來
 */
function notShowSearchDropdown()
{
    if ($('.overlay').hasClass('show')) {
        $('.overlay').removeClass('show'); // 不顯示背景反灰
    }
    $('#searchbarBox').slideUp(300, function() {}); // 將搜尋下拉選單收起來
}

/*
 * 將城市的下拉選單收起來
 */
function notShowCityDropdown()
{
    $('#dropdown-menu').slideUp(300, function() {}); // 將城市下拉選單收起來
}

/*
 * 登出
 */
function logout(message, redirectUrl = '')
{
    axios({
        method: 'post',
        url: '/api/logout',
        data: {},
        config: {
            headers: {
                'Content-Type': 'application/json'
            },
            responseType: 'json',
        },
    }).then(function() {
        alert(message);

        if (redirectUrl) {
            window.location.href = redirectUrl;
        } else {
            location.reload();
        }
    }).catch(function (error) {
        console.log(error);
    });
}

/*
 * 刪除搜尋紀錄
 */
function deleteSearchKeyword()
{
    axios({
        method: 'delete',
        url: '/api/searchKeyword',
        data: {},
        config: {
            headers: {
                'Content-Type': 'application/json'
            },
            responseType: 'json',
        },
    }).then(function() {
        return true;
    }).catch(function (error) {
        console.log(error);
    });
}
