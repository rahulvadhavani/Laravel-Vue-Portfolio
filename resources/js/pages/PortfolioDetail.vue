<template>

    <!-- bradcam_area  -->
    <Breadcrumb :title="data.title"></Breadcrumb>
    <!-- /bradcam_area  -->
    <section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 posts-list">
               <div class="single-post">
                  <div class="feature-img">
                     <img class="img-fluid" :src="data.image" alt="">
                  </div>
                  <div class="blog_details">
                     <h2>{{data.title}}</h2>
                     <p class="excert" v-text="data.description"></p>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="blog_right_sidebar">
                  <aside class="single_sidebar_widget">
                     <h4 class="widget_title">Details</h4>
                     <ul class="list detail-list">
                        <li><span class="font-weight-bold">Category : </span> {{category.name}}</li>
                        <li><span class="font-weight-bold">Team size : </span> {{data.team_size}}</li>
                        <li><span class="font-weight-bold">Date of Create : </span> {{data.created_at}}</li>
                        <li v-if="data.project_url != null"><span class="font-weight-bold"> Project Url : </span>
                            <a v-bind:href="data.project_url" target="_blank"> <i class="fa fa-link text-warning" ></i></a>
                        </li>
                        <li v-if="data.source_code != null"><span class="font-weight-bold">Source code : </span>
                            <a v-bind:href="data.source_code" target="_blank"> <i class="fa fa-github text-primary"></i></a>
                        </li>
                     </ul>
                  </aside>
                  <aside class="single_sidebar_widget tag_cloud_widget">
                     <h4 class="widget_title">Technologies</h4>
                     <ul class="list">
                        <li v-for="technology in data.technologies" :key="technology.id">
                            <a href="#" class="blog_item_date">
                                {{technology}}
                            </a>
                        </li>
                     </ul>
                  </aside>
               </div>
            </div>
         </div>
      </div>
    </section>
</template>
<script>

import Breadcrumb from '../components/Breadcrumb.vue';
import { ref, onMounted} from 'vue';
import Http from '../HTTP';
import { useRoute,useRouter } from 'vue-router';

export default {
    setup(){
        let data = ref([]);
        let category = ref([]);
        const router = useRouter();
        const route = useRoute();
        let setdata = async(slug)=>{
            let apiurl = "/portfolio/"+slug;
            const res = await Http.get(apiurl).then(res =>{
                if(res.data.status == false){
                    router.push({ name: 'not-found' });
                }
                data.value = res.data.data;
                category.value = res.data.data.category;
            });
        };
        onMounted(setdata(route.params.slug));
        return{
            data,
            category
        };
    },
    components:{
        Breadcrumb
    }, 
}

</script>

<style scoped>
.detail-list li {
    padding:8px 0px;
}
</style>