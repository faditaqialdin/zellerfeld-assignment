import {defineStore} from 'pinia';
import axios from '@/app/api.ts';
import storage from "@/app/storage.ts";

export default defineStore('user.show', {
    state: () => ({
        loading: false,
        error: '',
        success: '',
        user: {},
        canEdit: false,
    }),
    actions: {
        async reset() {
            this.loading = false;
            this.error = '';
            this.success = '';
            this.user = {};
            this.canEdit = false;
        },
        async loadInfo(userId) {
            this.loading = true;
            this.error = '';

            try {
                const {data} = await axios.get('/users/' + userId);
                this.user = data;
                if (this.user.id === storage.getProfile().id) {
                    this.canEdit = true;
                }
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
        async updateInfo() {

            if (this.user.id !== storage.getProfile().id) {
                return;
            }

            this.loading = true;
            this.error = '';
            this.success = '';

            const {['password']: password, ...userWithoutPassword} = this.user;
            const user = password ? this.user : userWithoutPassword;

            try {
                const {data} = await axios.put('/profile', user);
                this.user = data;
                this.success = 'User updated!';
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
    },
});
