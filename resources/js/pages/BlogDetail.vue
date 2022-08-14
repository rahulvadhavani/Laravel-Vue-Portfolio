<template>

    <!-- bradcam_area  -->
    <Breadcrumb :title="blogDetail.title"></Breadcrumb>
    <!-- /bradcam_area  -->
     <!--================Blog Area =================-->
    <section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 posts-list">
               <div class="single-post">
                  <div class="feature-img">
                     <img class="img-fluid" :src="blogDetail.image_thumbnail" alt="">
                  </div>
                  <div class="blog_details">
                     <h2>{{blogDetail.title}}</h2>
                     <ul class="d-flex justify-content-between blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-user"></i>{{user.fullname}} {{category.name}}</a></li>
                        <li><a href="#"><i class="fa fa-comments"></i> {{blog_comment_count}} Comments</a></li>
                        <li class=""><a href="#"><i class="fa fa-calendar"></i>{{blogDetail.created_at}}</a></li>
                     </ul>
                     <p class="excert" v-html="code"></p>
                  </div>
               </div>
               <div class="navigation-top">
                  <div class="d-sm-flex justify-content-between text-center">
                     <p class="like-info"><span @click="postLike" class="align-middle"><i :class="likeClass" class="fa fa-heart"></i></span>{{likes_count ?? 0}}
                        people like this</p>
                     <div class="col-sm-4 text-center my-2 my-sm-0">
                        <p class="comment-count"><span class="align-middle"><i class="fa fa-comment"></i></span>{{blog_comment_count}} Comments</p>
                     </div>
                     <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                     </ul>
                  </div>
               </div>
               <div class="blog-author">
                  <div class="media align-items-center">
                     <img style="border-radius:50%" :src="user.image" alt="">
                     <div class="media-body">
                        <a href="#">
                           <h4>{{user.fullname}}</h4>
                        </a>
                        <p>Back-end web-developer, code-optimizer, self driven developer</p>
                     </div>
                  </div>
               </div>
               <br>
               <h4>{{blog_comment_count}} Comments</h4>
               <div class="comments-area" v-if="comments.length > 0">
                     <div class="comment-list"  v-for="comment in comments" :key="comment.id">
                        <div class="single-comment justify-content-between d-flex">
                        <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                 <img :src="comment.user.image" alt="User Image">
                              </div>
                              <div class="desc">
                                 <p class="comment">
                                    {{comment.comment}}
                                 </p>
                                 <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                    <h5>
                                          <a href="#">{{comment.user.first_name +" "+ comment.user.last_name}}</a>
                                    </h5>
                                    <p class="date">{{comment.created_at}}</p>
                                    </div>
                                 </div>
                              </div>
                        </div>
                        </div>
                     </div>
               </div>
               <div class="comments-area" v-else >
                     <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                        <p class="text-center">No Comments</p>
                        </div>
                     </div>
               </div>
               <div class="comment-form">
                  <h4>Leave a Reply</h4>
                  <form class="form-contact comment_form" @submit.prevent="postComment">
                     <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                 <input type="hidden" v-model="formData.blog_id">
                                 <textarea v-model="formData.comment" class="form-control w-100"  cols="30" rows="9" placeholder = 'Enter comment'></textarea>
                              </div>
                        </div>
                     </div>
                     <div class="form-group">
                     <button :disabled="submitDisable" type="submit" class="button button-contactForm btn_1 boxed-btn">Post Comment</button>
                     </div>
                  </form>
               </div>
               <!--  -->
               <!-- <BlogComment :comments="blogDetail.comments"></BlogComment> -->
            </div>
            <div class="col-lg-4">
               <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget popular_post_widget">
                        <RecentPosts></RecentPosts>
                    </aside>
                  <aside class="single_sidebar_widget tag_cloud_widget">
                     <h4 class="widget_title">Tags</h4>
                     <ul class="list">
                        <li v-for="tag in blogContent.tags" :key="tag.id">
                            <router-link :to="'/blogs?tag='+tag" class="blog_item_date">
                                {{tag}}
                            </router-link>
                        </li>
                     </ul>
                  </aside>
                  <aside class="single_sidebar_widget newsletter_widget">
                    <Newsletter></Newsletter>
                  </aside>
               </div>
            </div>
         </div>
      </div>
    </section>
    <!--================Blog Area =================-->
</template>
<script>

import Http from '../HTTP';
import RecentPosts from '../components/RecentPosts.vue';
import Newsletter from '../components/Newsletter.vue';
import Breadcrumb from '../components/Breadcrumb.vue';
import Prism from '../../../public/web-assets/js/prism.js';
import { useToast } from "vue-toastification";
import {reactive, ref,onMounted,computed} from 'vue';
import { useRouter, useRoute } from 'vue-router';

export default {
    setup() {
      const router = useRouter();
      const route = useRoute();
      const toast = useToast();
      let submitDisable = ref(false);
      let formData = reactive({
        comment: '',
        blog_id: '',
      });
      let blogDetail = ref([]);
      let blogContent = ref([]);
      let category = ref([]);
      let user = ref([]); 
      let slug = ref('');
      let comments = ref([]);
      let code = ref('');
      let likes_count = ref(0);
      let blog_comment_count = ref(0);
      let likeClass = ref('');
      const resetForm = ()=>{
        formData.comment= '';
      };
      const postComment = async()=>{
         submitDisable.value = true;
         let apiurl = "user/post-comment";
         if(formData.comment.length  <= 0){
            submitDisable.value = false;
            toast.warning('Comment field is requried');
            return true;
         }
         await Http.post(apiurl,formData).then(res =>{
            if(res.data.status){
               toast.success(res.data.message);
               resetForm();
               comments.value = res.data.data;
               blog_comment_count.value =  res.data.data.length;
               submitDisable.value = false;
            }else{
               toast.error(res.data.message);
               if(res.data.code == 401){
                  router.push("/login");
               }
               submitDisable.value = false;
            }
         });
      }

      const postLike = async()=>{
         let apiurl = "user/post-like";
         await Http.post(apiurl,{'blog_id': formData.blog_id}).then(res =>{
            if(res.data.status){
               likes_count.value = res.data.data.like_count;
               if(res.data.data.like_status){
                  toast.success(res.data.message);
                  likeClass.value = "text-danger";
               }else{
                  likeClass.value = "";
               }
            }else{
               toast.error(res.data.message);
               if(res.data.code == 401){
                  router.push("/login");
               }
               submitDisable.value = false;
            }
         });
      }
      const setdata = async(slug)=>{
         let apiurl = "/blog/"+slug;
         await Http.get(apiurl).then(res =>{
            if(res.data.status == false){
               router.push({ name: 'not-found' })
            }
            let blogDetailVal = res.data.data
            blogDetail.value =  blogDetailVal;
            blogContent.value =  blogDetailVal.blog_content;
            blog_comment_count.value =  blogDetailVal.comments.length;
            user.value = blogDetailVal.user;
            category.value = blogDetailVal.category;
            comments.value = blogDetailVal.comments;
            code.value = blogDetailVal.blog_content.blog_body;
            formData.blog_id = blogDetailVal.id;
            likes_count.value = blogDetailVal.likes_count;
            if(blogDetailVal.like_status){
               likeClass.value = "text-danger";
            }else{
               likeClass.value = "";
            }
         })
      }
      onMounted(setdata(route.params.slug));
      return {formData,likes_count,likeClass,postLike ,toast,resetForm,submitDisable,postComment,blog_comment_count,comments,slug,user,category,blogContent,blogDetail,code};
  	},
   components:{
      Newsletter,
      RecentPosts,
      Breadcrumb
   },
   updated: function() {
   Prism.highlightAll();
   }    
}

</script>
<style scoped>
.comments-area .thumb img {
   height: 70px!important;
}
.comments-area {
   max-height: 500px;
   overflow-y: scroll;
}
.single-post-area .navigation-top .like-info i, .single-post-area .navigation-top .like-info span {
   cursor: pointer;
}
</style>