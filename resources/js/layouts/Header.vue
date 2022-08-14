<template>
<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-2">
                        <div class="logo">
                            <router-link :to="{ name: 'home' }" class="navbar-brand">
                                <img width="50" :src="logo_image"  alt="">
                            </router-link>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <!-- <div class=""> -->
                            <nav class="main-menu d-lg-block">
                                <ul id="navigation_section">
                                    <li class="nav-item">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'home' }">Home</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'about' }">About</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link v-bind:class="(ClassActive)?'router-link-active router-link-exact-active':''" class="nav-link" data-toggle="collapse" :to="{ name: 'blogs' }">Blog</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'services' }">Services</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link v-bind:class="(portfolioClassActive)?'router-link-active router-link-exact-active':''" class="nav-link" data-toggle="collapse" :to="{ name: 'portfolios' }">Portfolio</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'contact' }">Contact</router-link>
                                    </li>
                                    <li v-if="!isLoggedIn" class="nav-item d-block d-lg-none">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'login' }">Login</router-link>
                                    </li>
                                    <li v-if="isLoggedIn" class="nav-item d-block d-lg-none">
                                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'dashboard' }">Dashboard</router-link>
                                    </li>
                                </ul>
                            </nav>
                        <!-- </div> -->
                    </div>
                    <div  class="col-xl-3 col-lg-3 d-none d-lg-block">
                        <div v-if="!isLoggedIn" class="Appointment">
                            <div class="book_btn d-none d-lg-block">
                                <router-link class="" data-toggle="collapse" :to="{ name: 'login' }">Login</router-link>
                            </div>
                        </div>
                        <div v-if="isLoggedIn" class="Appointment">
                            <div class="book_btn d-none d-lg-block">
                                <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'dashboard' }">Dashboard</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="navtoggleicon d-block d-lg-none">
                            <div class="navicon">
                            <div class="naviconbar"></div>
                            <div class="naviconbar1"></div>
                            <div class="naviconbar2"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
</template>

<script>
import Http from '../HTTP';

export default {
    computed: {
        ClassActive() {
            return this.$route.name === 'blog-detail';
        },
        portfolioClassActive() {
            return this.$route.name === 'portfolio-detail';
        }
    },
    props: { logo_image:String},
    data(){
        return{
            slow_menu:false,
            isLoggedIn: false,
        }
    },
    created() {
        console.log(window.Laravel.isLoggedin);
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            e.preventDefault()
            const res = Http.post("/logout")
            .then(response => {
                if (response.data.success) {
                    window.location.href = "/"
                } else {
                    console.log(response)
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        }
    },
};

</script>
