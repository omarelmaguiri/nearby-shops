<template>
    <div>
        <h1 class="text-center mt-5">Login - Registration</h1>
        <div class="container pt-3">
            <div class="row justify-content-sm-center">
                <div class="col-sm-10 col-md-6">
                    <div v-if="hasError">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="card border-info">
                        <div class="card-header">Sign in OR Sign up to continue</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form-signin">
                                        <input v-model="username" type="email" class="form-control mb-2" placeholder="Email" required autofocus>
                                        <input v-model="password" type="password" class="form-control mb-2" placeholder="Password" required>
                                        <button @click="performLogin()" :disabled="username.length === 0 || password.length === 0 || isLoading" class="btn btn-lg btn-primary btn-block mb-1" type="button">Sign in</button>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mx-auto text-center">
                                                    <span>OR</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button @click="performSignUp()" :disabled="username.length === 0 || password.length === 0 || isLoading" class="btn btn-lg btn-warning btn-block mb-1" type="button">Sign up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'login',
        data () {
            return {
                username: '',
                password: '',
            };
        },
        created () {
            if (this.$store.getters['security/isAuthenticated']) {
                let redirect = this.$route.query.redirect;
                this.$router.push({path: typeof redirect !== 'undefined' ? redirect : '/home'});
            }
        },
        computed: {
            isLoading () {
                return this.$store.getters['security/isLoading'];
            },
            hasError () {
                return this.$store.getters['security/hasError'];
            },
            error () {
                return this.$store.getters['security/error'];
            },
        },
        methods: {
            postLogin () {
                if (this.$store.getters['security/isAuthenticated']) {
                    this.$cookies.set('isAuthenticated', 1);
                    let redirect = this.$route.query.redirect;
                    this.$router.push({path: typeof redirect !== 'undefined' ? redirect : '/nearby'});
                }
            },
            performLogin () {
                this.$store.dispatch('security/login', this.$data).then(this.postLogin);
            },
            performSignUp () {
                let payload = {email: this.$data.username, plain_password: this.$data.password};
                this.$store.dispatch('security/signup', payload).then(this.postLogin);
            },
        },
    }
</script>
