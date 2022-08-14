<template>
    <Breadcrumb title="Blog"></Breadcrumb>
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        <div v-if="blogData.length > 0">
                            <article v-bind:key="blog.id" v-for="blog in blogData" class="blog_item">
                                <div class="blog_item_img">
                                    <img loading="lazy" class="card-img rounded-0" :src="blog.image_thumbnail" alt="">
                                    <router-link :to="'/blog/' + blog.slug" class="blog_item_date">
                                        <p>{{blog.created_at}}</p>
                                    </router-link>
                                </div>
                                <div class="blog_details">
                                    <router-link :to="'/blog/' + blog.slug" class="d-inline-block">
                                        <h2 v-text="blog.title"></h2>
                                    </router-link>
                                    <p v-if="blogData.length > 0">{{blog.blog_content.meta_description??'-'}}</p>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-user"></i> {{blog.user.fullname}}, <b v-if="blogData.length > 0">{{blog.category.name}}</b></a></li>
                                        <li><a href="#"><i class="fa fa-comments"></i> {{blog.comments_count}} Comments</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div v-else>
                             <article class="blog_item">
                                <div class="blog_item_img">
                                    <img loading="lazy" class="card-img rounded-0" src="../../../public/assets/images/  " alt="">
                                </div>
                            </article>
                        </div>
                        <nav class="blog-pagination justify-content-center d-flex">
                            <!-- PAGINATION START -->
                            <div class="col-12 mt-4 pt-2">
                                <pagination :options="options" v-model="page" :records="records" :per-page="per_page" @paginate="setdata"/>
                            </div><!--end col-->
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4 sticky-sidebar">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget search_widget">
                            <form action="#">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input v-model="keyword" type="text" class="form-control" placeholder='Search Keyword'
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Search Keyword'">
                                        <div class="input-group-append">
                                            <button class="btn" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </aside>
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                 <li class="active">
                                    <a v-on:click.prevent.stop="getBlogByCategory(0)" href="#" class="d-flex">
                                        <h5>All</h5>
                                    </a>
                                 </li>
                                <li v-for="row in categories" :key="row.id">
                                    <a v-on:click.prevent.stop="getBlogByCategory(row.id)" href="#" class="d-flex">
                                        <h5>{{row.name}}</h5>
                                    </a>
                                </li>
                            </ul>
                        </aside>
                        <aside class="single_sidebar_widget popular_post_widget">
                            <recentPosts></recentPosts>
                        </aside>
                        <aside class="single_sidebar_widget newsletter_widget">
                            <Newsletter></Newsletter>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import Http from '../HTTP';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import recentPosts from '../components/RecentPosts.vue';
import Newsletter from '../components/Newsletter.vue';
import Breadcrumb from '../components/Breadcrumb.vue';


const wrapperWidth = ref(0)
const wrapper = ref(null)


export default {
    data() {
        return {
            keyword: null,
            selectedCategory: null,
            page: 1,
            per_page: 2,
            records: 0,
            blogData:[],
            categories:[],
            recentpost:[],
            options:{
                theme:"bootstrap4",
                chunksNavigation:"scroll",
            }
        }
    },
    watch: {
        keyword(after, before) {
            this.setdata();
        }
    },
    mounted(){
        let tag = this.$route.query.tag;
        this.setdata(1,tag);
        this.setCategory();
        this.setRescentPost();
    },
    methods:{
        setdata(page=1,tag=null){
            let apiurl = "/blogs?page="+page;
            if(this.keyword != null){
                apiurl = apiurl+'&search='+this.keyword;
            }
            if(this.selectedCategory != null){
                apiurl = apiurl+'&category='+this.selectedCategory;
            }
            if(tag != null){
                apiurl = apiurl+'&tag='+tag;
            }
            Http.get(apiurl).then(res =>{
                this.records = res.data.total;
                this.per_page = res.data.per_page;
                this.blogData =  res.data.data;
            });
        },
        setCategory(){
            Http.get("/categories").then(categoryRes =>{
                this.categories = categoryRes.data;
            });
        },
        setRescentPost(){
            Http.get("/recentpost").then(res =>{
                this.recentpost = res.data;
            });
        },
        getBlogByCategory(id){
            this.selectedCategory = null;
            if(id != 0){
                this.selectedCategory = id;
            }
            this.setdata();
        },
    },
    components:{
        recentPosts,
        Newsletter,
        Breadcrumb
    }
}

</script>

<style>
   .blog-pagination .page-item.active .page-link {
        color: #fff;
        background: #615CFD!important;
    }
    .sticky-sidebar{
        height: 200vh;
        min-height: 200px;
        overflow: auto;
        position: -webkit-sticky;
        position: sticky;
        top: 10%;
    }

</style>
