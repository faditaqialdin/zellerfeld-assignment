import axios from 'axios';
import {ENTRYPOINT} from './config'

const instance = axios.create({
    baseURL: ENTRYPOINT,
});

instance.interceptors.request.use(config => {
    const token = localStorage.getItem('access_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default instance;
