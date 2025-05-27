import {createRouter, createWebHistory} from 'vue-router'
import routes from '@/router/routes'
import storage from "@/app/storage.ts";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        ...routes
    ]
})

router.beforeEach(async (to, from, next) => {

    if (storage.getAccessToken() && ['/login', '/register'].includes(to.path)) {
        return next('/');
    }

    if (!storage.getAccessToken() && !['/login', '/register'].includes(to.path)) {
        return next('/login');
    }

    next();
});

export default router
