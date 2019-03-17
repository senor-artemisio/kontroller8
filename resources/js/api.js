import Cookies from 'js-cookie';
import axios from 'axios';


let headers = {
    "X-Requested-With": "XMLHttpRequest",
};


const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
    headers['X-CSRF-TOKEN'] = csrfToken.content;
} else {
    console.error('CSRF token not found.');
}

const authToken = Cookies.get('X-AUTH-TOKEN');

if (authToken) {
    headers['Authorization'] = 'Bearer ' + authToken;
}


export default axios.create({
    baseURL: '/api',
    headers
});
