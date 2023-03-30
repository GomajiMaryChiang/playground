<template>
    <div style="display: none;" id="epaper" class="popupBox epaper-popup">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="t-main text-center">立刻下載 APP，輸入優惠碼 “GOMAJI”即可獲得 $100 點！</h2>

                    <!-- Step 1: 選擇縣市 -->
                    <div class="enter-city" v-if="step === 1">
                        <select name="city" class="form-control check-select" v-model="selectedCity">
                            <option value="">請選擇縣市</option>
                            <option v-for="(cityName, cityValue) in cityList" v-bind:value="cityValue">{{ cityName }}</option>
                        </select>
                        <a href="#" class="btn btn-main mt-3" v-on:click="goStep2">下一步，填寫E-mail</a>
                    </div>

                    <!-- Step 2: 輸入Email -->
                    <div class="enter-mail" v-if="step === 2">
                        <input type="text" maxlength="50" size="50" class="form-control" placeholder="請填寫E-mail" aria-label="email" aria-describedby="email" v-model="email">
                        <a class="btn btn-main mt-3" href="javascript:;" v-on:click="subscribe">馬上訂閱取得優惠訊息</a>
                    </div>
                    <img class="d-block mt-3 mx-auto" src="/images/maji_sister.png" alt="GOMAJI妹妹">
                    <p class="t-09 t-dgray text-center mt-4">
                        <a href="https://www.gomaji.com/terms" target="_blank">服務條款</a> ｜
                        <a href="https://www.gomaji.com/privacy" target="_blank">隱私權政策</a> ｜
                        <a data-fancybox data-src="#unsubscribe" href="javascript:;">取消訂閱</a>
                    </p>
                </div>
                <div class="col-md-6 bg-main">
                    <h3 class="text-white text-center">最大吃喝玩樂平台！</h3>
                    <img class="mx-auto d-block" src="/images/popup_gomaji_app_v3.png" alt="GOMAJI APP">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                step: 1,
                selectedCity: '',
                email: '',
                cityList: {
                    Travel: '旅遊&旅遊行程',
                    Taiwan: '宅配美食',
                    Taipei: '台北',
                    Taoyuan: '桃園',
                    Hsinchu: '新竹',
                    Taichung: '台中',
                    Tainan: '台南',
                    Kaohsiung: '高雄'
                }
            }
        },
        methods: {
            goStep2() {
                if (this.selectedCity == '') {
                    alert('請選擇縣市！');
                    return false;
                }
                this.step = 2;
            },
            subscribe() {
                if (this.email == '') {
                    alert('請輸入email！');
                    return false;
                }

                axios.post('/api/epaper', { email: this.email, city: this.selectedCity })
                    .then((res) => {
                        if (res.data.return_code === '0000') {
                            this.step = 1;
                            this.selectedCity = '';
                            this.email = '';
                            $('#subscription .message').text(res.data.description);
                            $.fancybox.close();
                            $.fancybox.open({
                                src: '#subscription'
                            });
                        } else {
                            alert(res.data.description);
                        }
                    })
                    .catch((error) => {
                        console.error(error)
                    })
            }
        }
    }
</script>
