<template>
    <h3 class="widget_title">Recent Post</h3>
    <div v-for="row in recentpost" :key="row.id" class="media post_item">
        <img height="50" :src="row.image_thumbnail" alt="post">
        <div class="media-body">
            <router-link :to="'/blog/' + row.slug" class="blog_item_date">
                <h3>{{row.title}}</h3>
            </router-link>
           
            <p>{{row.created_at}}</p>
        </div>
    </div>
</template>

<script>
   import Http from '../HTTP';
   export default {
    data() {
        return {  
            recentpost:[],
        }
    },
    created(){
        this.setRescentPost();
    },
    methods:{
        setRescentPost(){
            Http.get("/recentpost").then(res =>{
                this.recentpost = res.data;
            });
        },
    },
}
</script>
