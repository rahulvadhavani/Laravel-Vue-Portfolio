<template>
    <div class="view-page-main">
        <div class="slider_area">
            <div class="single_slider  d-flex align-items-center slider_bg_1">
                <div id="stars"></div>
                <div id="stars2"></div>
                <div id="stars3"></div>
                <SocialLinks v-if="loadComponent" :sitedata="data" socail_class="social_links"></SocialLinks>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="slider_text text-center">
                                <h3 >
                                    Hello This is {{data.devloper_name}}
                                </h3>
                                <div>
                                    <span>{{data.profession}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loadComponent" class="service_area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_title text-center mb-65">
                            <span>Service Provided</span>
                            <h3>Build your brand <br>& digital projects</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div v-for="service in data.services" :key="service.id" class="col-xl-4 col-md-4">
                        <div class="single_service text-center">
                            <div class="icon">
                                <img width="150"  :src="service.image" alt="">
                            </div>
                            <h3>{{service.title}}</h3>
                            <p>{{service.description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- blog_area -->
        <div class="portfolio_area portfolio_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section_title white_text text-center">
                            <span>Latest Blogs</span>
                            <h3>Some of my awesome <br>
                                    stuffs here</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ blog_area -->

        <!-- blog_image_area  -->
        <div class="portfolio_image_area">
            <div class="container">
                <div class="row">
                    <div v-for="blog in data.blogs" :key="blog.id" class="col-xl-4 col-md-6 col-lg-4">
                        <router-link :to="'/blog/' + blog.slug">
                        <div class="single_Portfolio">
                            <div class="portfolio_thumb" style="height:220px">
                                <img width="150" :src="blog.image_thumbnail" alt="blog_img">
                            </div>
                            <div class="portfolio_hover">
                                <div class="title">
                                    <h3>{{blog.title}}</h3>
                                </div>
                            </div>
                        </div>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="more_portfolio text-center">
                            <router-link class="line_btn" to="/blogs">Explore More</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ blog_image_area  -->
        <div class="about_me">
            <div class="about_large_title d-none d-lg-block">About</div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6">
                        <div class="about_e_details">
                            <h3>About me</h3>
                            <p>{{data.about}}</p>
                            <DownloadCv></DownloadCv>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="about_img">
                            <div class="color_pattern d-none d-lg-block">
                                <img src="web-assets/img/about/color_grid.png" alt="">
                            </div>
                            <div class="my_Pic">
                                <img :src="data.user_image" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Portfolio></Portfolio>
        <ProjectCount  :job_sucesss="data.job_sucesss" :ruuning_project="data.ruuning_project" :project_count="data.project_count"></ProjectCount>
        <Testimonial></Testimonial>
    </div>
    <!-- page-main -->
</template>

<script>

import { ref, onMounted} from 'vue';
import Http from '../HTTP';
import Testimonial from '../components/Testimonial.vue';
import SocialLinks from '../components/SocialLink.vue';
import Portfolio from '../components/Portfolio.vue';
import ProjectCount from '../components/ProjectCount.vue';
import DownloadCv from '../components/DownloadCv.vue';
export default {
    setup(){
        let data = ref([]);
        let loadComponent = ref(false);
        let setdata = async()=>{
            const res = await Http.get("/home").then(res =>{
                console.log(res);
                data.value = res.data;
                loadComponent.value = true;
            });
        }
        let downloadCv = async()=>{
            const res = await Http.get("/download-cv").then(res =>{
                console.log(res);
            });
        }
        onMounted(setdata());
        return{
            loadComponent,
            data,
            downloadCv
        }
    },
    components:{
      Testimonial,
      SocialLinks,
      ProjectCount,
      Portfolio,
      DownloadCv
    },
    
}


</script>
