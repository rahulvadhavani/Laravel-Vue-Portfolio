<template>
    <div class="testimonial_area ">
        <div class="container">
            <div class="row">
                <div class="col-xl-12" v-if="showDiv">
                    <carousel :items-to-show="1" :autoplay="3000" dir="rtl" pauseAutoplayOnHover="true"  :wrap-around="true">
                        <slide v-for="testimonial in data" :key="testimonial.id" class="testmonial_active">
                            <div class="single_testmonial text-center">
                                <div class="quote">
                                    <img src="/web-assets/img/testmonial/quote.svg" alt="">
                                </div>
                                <p>{{testimonial.description}}</p>
                                <div class="testmonial_author">
                                    <div class="thumb">
                                            <img width="42" height="42" :src="testimonial.image" alt="">
                                    </div>
                                    <h3>{{testimonial.name}}</h3>
                                    <span>{{testimonial.business}}</span>
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
            const res = await Http.get("/testimonial").then(res =>{
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
