/*
*
*  Push Notifications codelab
*  Copyright 2015 Google Inc. All rights reserved.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
*/

/* eslint-env browser, es6 */

'use strict';

const applicationServerPublicKey = 'BCVmSm2nnnGn-YM2ZGNcowdKlmzVe6XVjd3l8V_jaj1SRR3gJs7NW-e4Z6SEPr6Jn90Hmwux-2nDodAaWcbO6qg';

let isSubscribed = false;
let swRegistration = null;
let subscriptionAuth = '';
let gmuid = 0;
let cityid = 1;

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function initialiseUI() {
    let pushBox = $("#gomaji-push-notification");
    var buttonClicked = false;
    // 按下「訂閱」按鈕
    $(".push-confirm").on('click', function() {
        buttonClicked = true;
        pushBox.css('display', 'none');
        console.log('pushConfirmButton click');
        subscribeUser();
        $.fancybox.close();
    });

    // 按下「暫時不要」按鈕
    $(".push-refuse").on('click', function() {
        buttonClicked = true;
        console.log('pushRefuseButton click');
        pushBox.css('display', 'none');
        $.cookie('webpush_refuse_time', (Date.now() + 86400000), {path: '/'});
        $.fancybox.close();
    });

    // 進入檔次頁面先判斷 "Notification.permission" 是否允許訂閱
    if ('default' === Notification.permission || 'undefined' === Notification.permission) {
        // 如果尚未按下「訂閱」按鈕，pushBox 彈跳視窗要顯示
        $.fancybox.open({
            src: "#gomaji-push-notification",
            afterClose: function() {
                if (buttonClicked == false) {
                    $.cookie('webpush_refuse_time', (Date.now() + 86400000), {path: '/'});
                };
            }
        });
    } else if ('granted' === Notification.permission) {
        // 如果已經按下「訂閱」按鈕過，pushBox 彈跳視窗不要顯示，並且抓取訂閱內容
        // Get subscription value
        swRegistration.pushManager.getSubscription()
        .then(function(subscription) {
            if (!(subscription === null)) {
                subscriptionAuth = subscription.toJSON().keys.auth;
                updateInfo();
            }
        });
    }
}

function subscribeUser() {
    console.log('subscribeUser');
    const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);

    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
    .then(function(subscription) {
        console.log('User is subscribed:', subscription);
        subscriptionAuth = subscription.toJSON().keys.auth;

        updateInfo();

        let formData = new FormData();
        formData.append('subscription', JSON.stringify(subscription));
        formData.append('gmuid', gmuid);

        fetch('https://ddd.gomaji.com/oneweb/webpush/subscribe', {
            method: 'POST',
            body: formData,
        })
        .then(function(response) {
            return response.json().then(function(res) {
                console.log(res);
            });
        })
        .catch(function(error) {
            console.error('Error fetch!', error);
        });
    })
    .catch(function(error) {
        console.error('Failed to subscribe the user: ', error);
    });
}

function updateInfo() {
    if (!cityid || !subscriptionAuth) {
        return;
    }
    let formData = new FormData();

    if (gmuid) {
        formData.append('gmuid', gmuid);
    }
    formData.append('city_id', cityid);
    formData.append('auth', subscriptionAuth);

    let url = 'https://ddd.gomaji.com/oneweb/webpush/update'

    console.log(`city: ${cityid}, auth: ${subscriptionAuth}, gm_uid: ${gmuid}`)

    fetch(url, {
        method: 'POST',
        body: formData,
    })
        .then(function(response) {
            return response.json().then(function(res) {
                console.log(res);
            });
        })
        .catch(function(error) {
            console.error('Error update auth : ', error);
        });
}

function fetchClk() {
    let clkUrl = 'https://clk.gomaji.com/webpush/' + cityid + '/' + gmuid + '/' + subscriptionAuth;

    console.log(clkUrl);

    fetch(clkUrl, {
        method: 'GET',
        headers: new Headers({
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'text/plain'
        }),
        mode: 'no-cors'
    })
    .then(function(response) {
        return response.json().then(function(res) {
            console.log(res);
        });
    })
    .catch(function(error) {
        console.log('Error fetch CLK : ' + clkUrl);
    });
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');
    navigator.serviceWorker.register('/js/webpush-sw.js')
    .then(function(swReg) {
        console.log('Service Worker is registered', swReg);

        let gcCity = $('#gcCity').val();
        swRegistration = swReg;

        if (undefined !== gcCity && 0 < gcCity) {
            cityid = gcCity;
        }

        if (undefined !== $.cookie('gm_uid') && 0 < $.cookie('gm_uid')) {
            gmuid = $.cookie('gm_uid');
        }

        if (0 < gmuid) {
            updateInfo();
        }

        if (undefined !== $.cookie('webpush_refuse_time') && 0 < $.cookie('webpush_refuse_time') && $.cookie('webpush_refuse_time') >= Date.now()) {
            console.log('webpush_refuse_time : ' + $.cookie('webpush_refuse_time'));
        } else if (window.Notification) {
            $.removeCookie('webpush_refuse_time');
            initialiseUI();
        }
    }).catch(function(error) {
        console.error('Service Worker Error', error);
    });
} else {
    console.warn('Push messaging is not supported');
}
