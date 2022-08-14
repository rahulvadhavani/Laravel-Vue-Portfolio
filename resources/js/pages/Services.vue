<template>
     <Breadcrumb title="Service"></Breadcrumb>
    <!-- service_area  -->
    <div class="service_area">
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
                            <img width="150" height="150"  :src="service.image" alt="">
                        </div>
                        <h3>{{service.title}}</h3>
                        <p>{{service.description}}</p>
                    </div>
                </div>
            </div>
        </div>
        <Portfolio></Portfolio>
        <div class="container">
            <div class="row mt-5">
                <div class="container py-5" >
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="section_title text-center mb-65">
                                <span>Expertise</span>
                                <h3>Skills & Tools</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-top">
                        <div class="col-xl-6 col-md-6 mb-3 p-3">
                            <div class="about_img">
                                <div class="my_Pic">
                                    <img class="w-100" alt="" src="public/web-assets/img/aravel_and_vue.svg">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 pt-sm-5 pt-md-0 mt-sm-5 mt-md-0">
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
    </div>
    <!-- testimonial_area  -->
    <Testimonial  :key="mykey"></Testimonial>

    <!-- /testimonial_area  -->
</template>

<script>

import Http from '../HTTP';
import Testimonial from '../components/Testimonial.vue';
import SocialLinks from '../components/SocialLink.vue';
import Breadcrumb from '../components/Breadcrumb.vue';
import Skills from '../components/Skills.vue';
import Portfolio from '../components/Portfolio.vue';
import { ref, onMounted} from 'vue';

export default {
    

    setup(){
        let data = ref([]);
        let mykey = ref(0);
        let setdata = async()=>{
            const res = await Http.get("/services").then(res =>{
               data.value = res.data;
               mykey.value = 1;
            });
        }
        onMounted(setdata());
        return{
            data,mykey
        }
    },
    components:{
      Testimonial,
      SocialLinks,
      Breadcrumb,
      Skills,
      Portfolio
    },
    
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