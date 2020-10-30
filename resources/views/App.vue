<template>
    <div class="container">
        <header>
            <div class="text-center my-4">
                <h1>Vue Router Demo App</h1>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <router-link active-class="active" class="nav-link" exact :to="{ name: 'home' }">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link active-class="active" class="nav-link" :to="{ name: 'hello' }">Hello World</router-link>
                </li>
                <li class="nav-item">
                    <router-link active-class="active" class="nav-link" :to="{ name: 'users.index' }">Users</router-link>
                </li>
            </ul>
        </header>

        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
    export default {}
</script>
