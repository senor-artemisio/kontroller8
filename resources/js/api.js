import store from './store';

import axios from 'axios';


export default {
    client() {
        let headers = {
            "X-Requested-With": "XMLHttpRequest",
        };


        const CSRFToken = document.head.querySelector('meta[name="csrf-token"]');

        if (CSRFToken) {
            headers['X-CSRF-TOKEN'] = CSRFToken.content;
        } else {
            console.error('CSRF token not found.');
        }

        const authToken = store.getters.token;

        if (authToken) {
            headers['Authorization'] = 'Bearer ' + authToken;
        }

        return axios.create({
            baseURL: '/api',
            headers
        });
    }
};
