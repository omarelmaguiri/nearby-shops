<template>
    <div>
        <div class="row">
            <div class="mx-auto p-3">
                <h1>Nearby Shop</h1>
            </div>
        </div>

        <div v-if="display">
            <div class="row m-2">
                <div v-if="isLoading">
                    <p>Loading...</p>
                </div>

                <div v-else-if="hasError">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div v-else-if="!hasShops">
                    No Shops!
                </div>

                <div v-else class="card-deck">
                    <div v-for="shop in shops" class="col-sm-6 col-md-4 col-lg-3">
                        <NearbyShop :key="shop.id" :shop="shop"></NearbyShop>
                    </div>
                </div>
            </div>
            <div v-if="!isLoading" class="row m-3">
                <div class="mx-auto p-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" :class="page === 1 ? 'disabled' : ''">
                                <a @click="previousPage()" class="page-link" :href="'#'+page" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item" :class="!hasShops ? 'disabled' : ''">
                                <a @click="nextPage()" class="page-link" :href="'#'+page" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NearbyShop from '../components/NearbyShop';

    export default {
        name: 'nearby',
        components: {
            NearbyShop
        },
        data () {
            return {
                page: 1,
                display: false
            }
        },
        created () {
            this.fetchShops();
            this.$data.display = true;
        },
        computed: {
            isLoading () {
                return this.$store.getters['nearby/isLoading'];
            },
            hasError () {
                return this.$store.getters['nearby/hasError'];
            },
            error () {
                return this.$store.getters['nearby/error'];
            },
            hasShops () {
                return this.$store.getters['nearby/hasShops'];
            },
            shops () {
                return this.$store.getters['nearby/shops'];
            },
        },
        methods: {
            fetchShops() {
                navigator.geolocation.getCurrentPosition(this.fetchShopsWithPosition, this.fetchShopsWithoutPosition);
            },
            fetchShopsWithoutPosition (err) {
                this.$store.dispatch('nearby/fetchShops', this.$data.page);
            },
            fetchShopsWithPosition (position) {
                this.$store.dispatch('nearby/fetchShopsWithPosition', {position: position, page: this.$data.page});
            },
            previousPage () {
                this.$data.page = this.$data.page > 0 ? this.$data.page - 1 : 0;
                this.fetchShops();
            },
            nextPage () {
                this.$data.page++;
                this.fetchShops();
            },
        }
    }
</script>
