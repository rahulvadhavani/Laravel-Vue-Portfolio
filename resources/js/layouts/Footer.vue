
<template>
    <div>
        <div class="discuss_projects">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="project_text text-center">
                            <router-link :to="{ name: 'home' }" class="navbar-brand">
                                  <img width="250" :src="sitedata.logo_image"  alt="">
                            </router-link>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="project_text text-center">
                            <h3>Let’s discuss for a project</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua.</p>
                            <router-link class="boxed-btn3" data-toggle="collapse" :to="{ name: 'contact' }">Start Talking</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer start -->
        <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-md-6">
                            <div class="menu_links">
                                <ul>
                                    <li>
                                        <router-link data-toggle="collapse" :to="{ name: 'home' }">Home</router-link>
                                    </li>
                                    <li>
                                        <router-link data-toggle="collapse" :to="{ name: 'about' }">About</router-link>
                                    </li>
                                    <li>
                                        <router-link data-toggle="collapse" :to="{ name: 'blogs' }">Blog</router-link>
                                    </li>
                                    <li>
                                        <router-link data-toggle="collapse" :to="{ name: 'services' }">Service</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <!-- social_links -->
                            <SocialLinks :sitedata="sitedata" socail_class="socail_links"></SocialLinks>
                            <!-- social_links -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right_text">
                <div class="container">
                    <div class="footer_border"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <p class="copy_right text-center">
                                Copyright &copy;{{ new Date().getFullYear() }} All rights reserved
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import SocialLinks from '../components/SocialLink.vue';
export default {
    props: { sitedata:Object},
    components:{
      'SocialLinks':SocialLinks,
    }
};
</script>