import axios from 'axios';

export default {
    getNearby () {
        return axios.get('/api/shops');
    },
    getNearbyWithLatLong (lat, long) {
        return axios.get('/api/shops', {
            params: {
              latitude: lat,
              longitude: long
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
