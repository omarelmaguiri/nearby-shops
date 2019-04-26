<template>
    <div class="container">
        <nav v-if="isAuthenticated" class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <router-link class="nav-item" tag="li" to="/nearby" active-class="active">
                        <a class="nav-link">Nearby Shops</a>
                    </router-link>

                    <router-link class="nav-item" tag="li" to="/favorite" active-class="active">
                        <a class="nav-link">My preferred Shops</a>
                    </router-link>

                    <li class="nav-item">
                        <a @click="logout()" class="nav-link" href="/api/security/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'app',
        created () {
            if (this.$cookies.isKey('isAuthenticated')) {
              this.$store.dispatch('security/onRefresh');
            }

            axios.interceptors.response.use(undefined, (err) => {
                return new Promise(() => {
                    if (err.response.status === 401 || err.response.status === 403) {
                        this.$router.push({path: '/login'})
                    }
                    throw err;
                });
            });
        },
        computed: {
            isAuthenticated () {
                return this.$store.getters['security/isAuthenticated']
            },
        },
        methods: {
            logout () {
                this.$cookies.remove('isAuthenticated');
            }
        },
    }
</script>
