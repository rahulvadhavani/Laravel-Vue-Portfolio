<template>
    <Breadcrumb title="Portfolio"></Breadcrumb>
    <!-- portfolio_image_area  -->
    <div class="portfolio_image_area dec_margin">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6" v-for="project in data" :key="project.id">
                    <div class="single_Portfolio">
                        <div class="portfolio_thumb">
                            <img :src="project.image" alt="portfolio">
                        </div>
                        <div class="portfolio_hover">
                            <div class="title">
                                <h1 class="text-white text-capitalize" v-text="project.title"></h1>
                                <h3 v-text="project.category.name"></h3>
                                <div class="more_portfolio text-center">
                                    <router-link :to="'/portfolio/' + project.slug" class="line_btn primary-border">More Info</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ portfolio_image_area  -->
</template>
<script>
import Http from '../HTTP';
import { ref, onMounted} from 'vue';
import Breadcrumb from '../components/Breadcrumb.vue';


const wrapperWidth = ref(0)
const wrapper = ref(null)


export default {
    data() {
        return {
            data:[],
        }
    },
    mounted(){
        this.setdata(1);
    },
    methods:{
        setdata(){
            Http.get('projects').then(res =>{
                this.data =  res.data.data;
            });
        },
    },
    components:{
        Breadcrumb
    }
}

</script>
<style scoped>
.line_btn {
    color: #ffff;
    border: 1px solid #ffff;
}
</style>

