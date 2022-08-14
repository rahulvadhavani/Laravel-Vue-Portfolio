<template>
    <div class="view-page-main">
    <Breadcrumb title="About"></Breadcrumb>
    <!-- <div class="video_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="video_wrap">
                        <div class="thumb">
                            <img src="web-assets/img/video/video_bg.png" alt="">
                            <div class="video_icon">
                                <a class="popup-video" href="https://www.youtube.com/watch?v=1Prw90PRiJE"> <i class="fa fa-play"></i> </a>
                            </div>
                        </div>
                        <div class="video_text text-center">
                            <p v-html="data.about_line"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="about_me">
        <div  class="about_large_title d-none d-lg-block">
            About
        </div>
         <div  class="container mt-5">
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
    <div class="counter_area">
        <div class="container">
             <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-65">
                        <span><h3>Resume</h3></span>
                    </div>
                </div>
            </div>
            <div class="container" >
                <Resume></Resume>
            </div>            
        </div>
    </div>
    <div class="counter_area">
        <div class="container">
             <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-65">
                        <span><h3>Skills</h3></span>
                    </div>
                </div>
            </div>
            <div class="container" >
                <div class="row align-items-top">
                    <div class="col-xl-6 col-md-6 d-none d-md-block">
                        <div class="about_img">
                            <div class="my_Pic">
                                <img class="w-100" alt="" src="public/web-assets/img/aravel_and_vue.svg">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                       <div class="skill-row">
                            <div v-for="skill in data.skills" :key="skill.id">
                                <Skills :skill='skill'></Skills>
                            </div>
                        </div>
                     </div>
                </div>
            </div>            
        </div>
    </div>
    <ProjectCount :job_sucesss="data.job_sucesss" :ruuning_project="data.ruuning_project" :project_count="data.project_count"></ProjectCount>
    <Testimonial></Testimonial>
    </div>
</template>
<script>
import Http from '../HTTP';
import Testimonial from '../components/Testimonial.vue';
import Breadcrumb from '../components/Breadcrumb.vue';
import Skills from '../components/Skills.vue';
import Resume from '../components/Resume.vue';
import ProjectCount from '../components/ProjectCount.vue';
import DownloadCv from '../components/DownloadCv.vue';
import { ref, onMounted} from 'vue';

export default {
    setup(){
        let data = ref([]);
        let setdata = async()=>{
            const res = await Http.get("/about").then(res =>{
                data.value = res.data;
            });
        }
        onMounted(setdata());
        return{
            data
        }
    },
    components:{
        Testimonial,
        Breadcrumb,
        Skills,
        ProjectCount,
        Resume,
        DownloadCv
    }
}
</script>
<style scoped>
.skill-row {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    grid-gap: 0;
    justify-content: space-around;
    margin-bottom: 15px;
}
</style>
