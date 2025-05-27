import {defineStore} from 'pinia';
import storage from "@/app/storage.ts";
import router from "@/router";

export default defineStore('navbar', {
    state: () => ({
        user: false,
    }),
    actions: {
        async logout() {
            storage.clear();
            await router.push('/login');
        },
    },
});
