<template>
    <div class="card m-2">
        <div class="card-header">
            {{ shop.name }}
        </div>
        <img class="card-img-top" :src="shop.image" alt="Card image cap">
        <div class="card-body">
            <button @click="unfavorite(shop)" class="btn btn-danger float-left">Remove</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NearbyShop",
        props: ['shop'],
        methods: {
            unfavorite (shop) {
                this.$store.dispatch('favorite/unfavoriteShop', shop.id);
            },
        },
    }
</script>
