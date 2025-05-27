import {defineStore} from 'pinia';
import axios from '@/app/api.ts';
import storage from "@/app/storage.ts";
import router from "@/router";

export default defineStore('register', {
    state: () => ({
        loading: false,
        error: '',
        success: '',
        user: {},
    }),
    actions: {
        async register() {
            this.loading = true;
            this.error = '';
            this.success = false;

            try {
                await axios.post('/users', this.user);
                this.success = 'User registered successfully, please login.';
                setTimeout(async function () {
                    await router.push('/login');
                }, 2000);
            } catch (error) {
                this.userError = error.message;
            }

            this.userLoading = false;
        },
    },
});
