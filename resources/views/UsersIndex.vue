<template>
    <div class="users">
        <div v-if="error" class="error">
            <p>{{ error }}</p>

            <p>
                <button @click.prevent="refresh">
                    Try Again
                </button>
            </p>
        </div>

        <ul v-if="users">
            <li v-for="{ name, email, id } in users">
                <strong>Name:</strong> {{ name }},
                <strong>Email:</strong> {{ email }}
                <router-link :to="{name: 'users.edit', params: {id} }">edit</router-link>
            </li>

        </ul>
        <button class="btn btn-primary" :disabled="!prevPage" @click="goPrev">前一页</button>
        <span>{{ pagination }}</span>
        <button class="btn btn-primary" :disabled="!nextPage" @click="goNext">后一页</button>
    </div>
</template>
<script>
import axios from 'axios';
const getUsers = (callback, page = 1) => {
    axios.get(`/api/users?page=${page}`)
        .then(response => {
            callback && callback(response)
        }).catch(error => {
            let msg = error.response.data.message || error.message
            callback && callback(error, msg)
        })
};
export default {
    data() {
        return {
            users: null,
            error: null,
            meta: null,
        };
    },
    computed: {
        pagination() {
            if(! this.meta) {
                return;
            }
            return `${this.meta.current_page} of ${this.meta.last_page}`;
        },

        prevPage() {
            if(!this.meta || this.meta.current_page == 1) {
                return;
            }
            return this.meta.current_page - 1;
        },

        nextPage() {
            if(!this.meta || this.meta.current_page == this.meta.last_page) {
                return;
            }
            return this.meta.current_page + 1;
        }
    },
    beforeRouteEnter(to, from, next) {
        getUsers(({data}, err) => {
            next( vm => {
                vm.setData(data, err)
            })
        })
    },
    beforeRouteUpdate(to, from, next) {
        getUsers(({data}, err) => {
            this.setData(data, err)
        }, to.query.page)
    },
    methods: {
        setData(data, error) {
            if(error) {
                this.error = error;
            } else {
                this.error = null;
                this.users = data.data;
                this.meta = data.meta;
            }
        },
        refresh() {
            this.$router.push({
                query: {
                    page: (this.meta && this.meta.current_page) || 1
                }
            })
        },
        goPrev() {
            this.$router.push({
                query: {
                    page: this.prevPage
                }
            })
        },
        goNext() {
            this.$router.push({
                query: {
                    page: this.nextPage
                }
            })
        }
    }
}
</script>
