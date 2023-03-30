<template>
    <div style="display: none;" id="unsubscribe" class="popupBox w-25">
        <h2 data-selectable="true" class="t-orange">取消訂閱</h2>
        <div class="epaperBox">

            <!-- 填寫 Email -->
            <div class="cancel" v-if="status === 'form'">
                <input name="address" type="text" maxlength="50" size="50" class="form-control w-260 mx-auto" placeholder="請填寫E-mail" autocomplete="off" v-model="email">
                <a href="javascript:;" class="product-hint btn btn-main w-100 mt-3 mx-auto t-10" v-on:click="unsubscribe">確定</a>
            </div>

            <!-- 取消結果 -->
            <div class="cancel-success" v-if="status === 'result'">
                <p id="cancel_success" class="text-center t-12">{{ message }}</p>
                <a href="javascript:;" data-fancybox-close class="product-hint btn btn-main w-100 mt-3 mx-auto t-10">關閉</a>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                status: 'form',
                email: '',
                message: ''
            }
        },
        methods: {
            unsubscribe() {
                if (this.email == '') {
                    alert('請輸入email！');
                    return false;
                }

                axios.delete('/api/epaper', { data: { email: this.email } })
                    .then((res) => { 
                        this.status = 'result';
                        this.message = res.data.description;
                        if (res.data.return_code === '0000') {
                            this.email = '';
                        }
                    })
                    .catch((error) => { 
                        console.error(error) 
                    })
            }
        }
    }
</script>