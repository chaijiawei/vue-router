<template>
    <div>
        <div v-if="loading">
            loading...
        </div>
        <form v-if="!loading" @submit.prevent="update">
            <div v-if="message" class="alert alert-success">
                {{ message }}
            </div>

            <div v-if="errors" class="alert alert-danger">
                <ul v-for="(error, name) in errors">
                    <li>{{ error[0] }}</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="name">用户名</label>
                <input class="form-control" id="name" type="text" v-model="user.name">
            </div>
            <div class="form-group">
                <label for="email">邮箱</label>
                <input class="form-control" id="email" type="text" v-model="user.email">
            </div>
            <button type="submit" :disabled="saving" class="btn btn-primary">更新</button>
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
                id: '',
            },
            saving: false,
            loading: true,
            message: null,
            errors: null,
        }
    },

    created() {
        axios.get('/api/users/' + this.$route.params.id)
            .then(({data}) => {
                this.user = data
            }).then(() => this.loading = false);
    },
    methods: {
        back(){
            this.$router.back()
        },

        update(){
            this.saving = true;
            axios.put('/api/users/' + this.user.id, {
                name: this.user.name,
                email: this.user.email
            }).then(response => {
                this.message = '更新成功'
                setTimeout(() => this.message = null, 2000)
            }).catch( error => {
                this.errors = error.response.data.errors
            }).then(()=> this.saving = false);
        }
    },
}
</script>
