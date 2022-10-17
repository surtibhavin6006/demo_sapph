import { createWebHistory, createRouter } from 'vue-router';

const DashboardPage = () => import('@/pages/DashboardPage.vue');

const routes = [
    {
        name: "dashboard",
        path: "/",
        component: DashboardPage
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;

