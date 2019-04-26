import axios from 'axios';

export default {
    getNearby (page) {
        return axios.get('/api/shops', {
            params: {
                page: page,
            }
        });
    },
    getNearbyWithLatLong (lat, long, page) {
        return axios.get('/api/shops', {
            params: {
                latitude: lat,
                longitude: long,
                page: page,
            }
        });
    },
    getFavorites () {
        return axios.get('/api/shops/favorites');
    },
    dislike (id) {
        return axios.put('/api/shops/'+id+'/dislike');
    },
    favorite (id) {
        return axios.put('/api/shops/'+id+'/favorite');
    },
    unfavorite (id) {
        return axios.put('/api/shops/'+id+'/unfavorite');
    },
}
