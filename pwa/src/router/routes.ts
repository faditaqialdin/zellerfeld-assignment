export default [
    {
        name: 'Login',
        path: '/login',
        component: () => import('@/views/LoginView.vue')
    },
    {
        name: 'Register',
        path: '/register',
        component: () => import('@/views/RegisterView.vue')
    },
    {
        name: 'User',
        path: '/users/:user_id',
        component: () => import('@/views/UserView.vue')
    },
    {
        name: 'Home',
        path: '/',
        component: () => import('@/views/HomeView.vue')
    },
]
