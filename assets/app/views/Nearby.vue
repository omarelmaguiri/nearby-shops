<template>
    <div>
        <div class="row col">
            <h1>Nearby Shop</h1>
        </div>

        <div class="row col">
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
    </div>
</template>

<script>
    import NearbyShop from '../components/NearbyShop';

    export default {
        name: 'nearby',
        components: {
            NearbyShop
        },
        created () {
            navigator.geolocation.getCurrentPosition(this.fetchShopsWithPosition, this.fetchShopsWithoutPosition);
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
            fetchShopsWithoutPosition (err) {
                this.$store.dispatch('nearby/fetchShops');
            },
            fetchShopsWithPosition (position) {
                this.$store.dispatch('nearby/fetchShopsWithPosition', position);
            },
        }
    }
</script>
