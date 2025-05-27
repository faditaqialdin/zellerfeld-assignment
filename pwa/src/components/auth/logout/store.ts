import {defineStore} from 'pinia';
import axios from '@/app/api.ts';
import router from '@/router';
import storage from "@/app/storage.ts";

export default defineStore('logout', {
    state: () => ({
        loading: false,
        error: '',
    }),
    actions: {
        async logout() {
            this.loading = true;
            this.error = '';

            try {
                await axios.delete('/auth/token');
                storage.clear();
                await router.push('/login');
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
    },
});
