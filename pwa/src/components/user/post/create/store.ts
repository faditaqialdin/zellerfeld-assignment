import {defineStore} from 'pinia';
import axios from '@/app/api.ts';
import storage from "@/app/storage.ts";
import router from '@/router';

export default defineStore('user.post.store', {
    state: () => ({
        loading: false,
        error: '',
        content: '',
        userId: null,
        canPost: false,
    }),
    actions: {
        async loadUserId(userId) {
            this.userId = storage.getProfile().id;
            if (userId === this.userId) {
                this.canPost = true;
            }
            if (!userId) {
                this.canPost = true;
            }
        },
        async createPost() {
            this.loading = true;
            this.error = '';

            try {
                await axios.post('/users/' + this.userId + '/posts', {content: this.content});
                this.content = '';
                await router.push('#' + Number(new Date));
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
    },
});
