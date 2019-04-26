<template>
    <div>
        <div class="row">
            <div class="mx-auto p-3">
                <h1>My Preferred Shops</h1>
            </div>
        </div>

        <div class="row">
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
                    <FavoriteShop :key="shop.id" :shop="shop"></FavoriteShop>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FavoriteShop from '../components/FavoriteShop';

    export default {
        name: 'favorite',
        components: {
            FavoriteShop
        },
        created () {
            this.$store.dispatch('favorite/fetchShops');
        },
        computed: {
            isLoading () {
                return this.$store.getters['favorite/isLoading'];
            },
            hasError () {
                return this.$store.getters['favorite/hasError'];
            },
            error () {
                return this.$store.getters['favorite/error'];
            },
            hasShops () {
                return this.$store.getters['favorite/hasShops'];
            },
            shops () {
                return this.$store.getters['favorite/shops'];
            },
        },
    }
</script>
