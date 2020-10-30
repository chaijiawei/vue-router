<template>
    <div>
        <form>
            <div class="form-group">
                <label for="name">用户名</label>
                <input class="form-control" id="name" type="text" v-model="user.name">
            </div>
            <div class="form-group">
                <label for="email">邮箱</label>
                <input class="form-control" id="email" type="text" v-model="user.email">
            </div>
            <button class="btn btn-primary">更新</button>
            <a class="ml-4" href="#" @click.prevent="back">返回</a>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
            }
        }
    },

    created() {
        axios.get('/api/users/' + this.$route.params.id)
            .then(({data}) => {
                this.user = data
            })
    },
    methods: {
        back(){
            this.$router.back()
        },
    },
}
</script>
