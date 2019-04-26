<template>
    <div class="card m-2">
        <div class="card-header">
            {{ shop.name }}
        </div>
        <img class="card-img-top" :src="shop.image" alt="Card image cap">
        <div class="card-body">
            <button @click="dislike(shop)" class="btn btn-danger float-left">Dislike</button>
            <button @click="like(shop)" class="btn btn-success float-right">Like</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NearbyShop",
        props: ['shop'],
        methods: {
            dislike (shop) {
                this.$store.dispatch('nearby/dislikeShop', shop.id);
            },
            like (shop) {
                this.$store.dispatch('nearby/likeShop', shop.id);
            },
        },
    }
</script>
