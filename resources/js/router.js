import * as Vue from 'vue';
import * as VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Blog from './pages/Blog.vue';
import Portfolio from './pages/Portfolio.vue';
import Services from './pages/Services.vue';
import Contact from './pages/Contact.vue';
import NotFound from './pages/NotFound';
import BlogDetail from './pages/BlogDetail.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Dashboard from './pages/Dashboard.vue';
import ForgotPassword from './pages/ForgotPassword.vue';
import ResetPassword from './pages/ResetPassword.vue';
import PortfolioDetail from './pages/PortfolioDetail.vue';


let routes =  [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/blogs',
        name: 'blogs',
        component: Blog
    },
    {
        path: '/services',
        name: 'services',
        component: Services
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact
    },
    {
        path: '/forgot-password',
        name: 'forgotpassword',
        component: ForgotPassword
    },
    {
        path: '/password/reset/:token?',
        name: 'resetpassword',
        component: ResetPassword
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/blog/:slug?',
        name: 'blog-detail',
        component: BlogDetail
    },
    {
        path: '/portfolios',
        name: 'portfolios',
        component: Portfolio
    },
    {
        path: '/portfolio/:slug?',
        name: 'portfolio-detail',
        component: PortfolioDetail
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: NotFound
    },
]
const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
  scrollBehavior() {
    document.getElementById('app').scrollIntoView({ behavior: 'smooth' });
  },
});

export default router;