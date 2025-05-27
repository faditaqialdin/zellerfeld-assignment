import {defineStore} from 'pinia';
import axios from '@/app/api.ts';

export default defineStore('posts.index', {
    state: () => ({
        loading: false,
        error: '',
        posts: [],
        page: 0,
        lastPageReached: false,
    }),
    actions: {
        async reset() {
            this.loading = false;
            this.error = '';
            this.posts = [];
            this.page = 0;
            this.lastPageReached = false;
        },
        async loadMore(userId) {

            if (this.loading || this.lastPageReached) return;

            this.loading = true;
            this.error = '';

            try {
                this.page++;
                const {data} = await axios.get('/users/' + userId + '/posts?page=' + this.page);
                this.posts.push(...data.data);
                this.lastPageReached = data.last_page === this.page;
            } catch (error) {
                this.error = error.message;
            }

            this.loading = false;
        },
    },
});
