<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <router-link class="nav-item" tag="li" to="/nearby" active-class="active">
                        <a class="nav-link">Nearby Shops</a>
                    </router-link>

                    <router-link class="nav-item" tag="li" to="/favorite" active-class="active">
                        <a class="nav-link">My preferred Shops</a>
                    </router-link>
                </ul>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: 'app',
    }
</script>
