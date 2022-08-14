<template>
    <div class="testimonial_area portfolio_bg_area" style="margin-top:70px">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 text-center text-white pb-4">
                    <span class="text-uppercase">Recent Work</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12" v-if="showDiv">
                    <carousel :items-to-show="1" :autoplay="3000" dir="ltr" pauseAutoplayOnHover="true"  :wrap-around="true">
                        <slide v-for="project in data" :key="project.id" class="testmonial_active row">
                            <div class="col-md-6 col-12">
                                <img style="width:100%" :src="project.image" alt="">
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="single_testmonial text-center">
                                    <p style="font-size:35px">{{project.title}}</p>
                                    <p>{{project.description}}</p>
                                    <div class="more_portfolio text-center">
                                        <router-link :to="'/portfolio/' + project.slug" class="line_btn">More Info</router-link>
                                    </div>
                                </div>
                            </div>
                        </slide>
                        <template #addons>
                            <navigation />
                        </template>
                    </carousel>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import { ref, onMounted} from 'vue';
import Http from '../HTTP';

export default {
  name: 'App',
  components: {
    Carousel,
    Slide,
    Navigation,
  },

  setup(){
        let data = ref([]);
        let showDiv = ref(false);
        let setdata = async()=>{
            const res = await Http.get("/projects?recent=true").then(res =>{
                if(res.status){
                    data.value = res.data.data;
                    showDiv.value = true;
                }
            });
        }
        onMounted(setdata());
        return{
            data,showDiv
        }
    },
};
</script>
<style scoped>
.testimonial_area{
    margin-top: 1px;
}


</style>
