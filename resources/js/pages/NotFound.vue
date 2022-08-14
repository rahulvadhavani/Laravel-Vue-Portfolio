<template>
     <Breadcrumb title="404"></Breadcrumb>
      <section class="blog_area section-padding">
        <div class="container">
            <div class="row center-align">
                <img loading="lazy" class="card-img rounded-0 w-50" src="/public/assets/images/404.svg" alt="">
            </div>
        </div>
    </section>
</template>

<script>
import Http from '../HTTP';
import Breadcrumb from '../components/Breadcrumb.vue';

export default {
    components:{
      Breadcrumb,
    },
}
</script>
<style scoped>

.center-align{
  display: flex !important;
  justify-content:center!important;;
}
</style>
