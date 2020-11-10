<template>
    <div>
        <form @submit.prevent="onCreate">
            <div v-if="message" class="alert alert-success">
                {{ message }}
            </div>

            <div v-if="errors" class="alert alert-danger">
                <ul v-for="error in errors">
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
            <button type="submit" :disabled="saving" class="btn btn-primary">
                {{ saving ? '创建中...' :  '创建'}}
            </button>
        </form>
    </div>
</template>
<script>
import api from '../api/user'

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                id: '',
            },
            saving: false,
            message: null,
            errors: null,
        }
    },

    methods: {
        onCreate(){
            this.saving = true;
            api.create({
                name: this.user.name,
                email: this.user.email
            }).then( ({data}) => {
                this.errors = null
                this.message = '创建成功'
                setTimeout(() => {
                    this.message = null
                    this.$router.push({name: 'users.edit', params: {id: data.id}})
                }, 2000)
            }).catch( error => {
                this.errors = error.response.data.errors || {
                    error: ['an error occur']
                }
                this.saving = false
            });
        },
    },
}
</script>
