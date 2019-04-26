import axios from 'axios';

export default {
    signup (user) {
        return axios.post('/api/public/signup', user);
    },
    login (user) {
        return axios.post('/api/login', {}, {
            auth: user
        });
    },
}
