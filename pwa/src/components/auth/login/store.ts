import {defineStore} from 'pinia';
import axios from '@/app/api.ts';
import storage from '@/app/storage.ts';
import router from '@/router';

export default defineStore('login', {
    state: () => ({
        loading: false,
        error: '',
        user: {},
    }),
    actions: {
        async login() {
            this.loading = true;
            this.error = '';

            try {
                const {data} = await axios.post('/auth/token', this.user);
                storage.setAccessToken(data.access_token);
                await this.loadProfile();
                await router.push('/');
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
        async loadProfile() {
            const {data} = await axios.get('/profile');
            storage.setProfile(data);
        },
    },
});
