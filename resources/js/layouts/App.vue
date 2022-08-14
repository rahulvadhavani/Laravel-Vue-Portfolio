<template>
  <div>
    <my-header :logo_image="site_data.logo_image"></my-header>
    <div>
      <router-view :key="$route.fullPath"></router-view>
    </div>
    <my-footer v-if="showfooter" :sitedata='site_data'></my-footer>
  </div>
</template>

<script>
import Header from './Header.vue';
import Footer from './Footer.vue';
import Http from '../HTTP';

export default {
  watch: {
    $route() {
      $("#navbarCollapse").collapse("hide");
    },
  },
  components:{
      'my-header':Header,
      'my-footer':Footer
  },
  data() {
      return {
          site_data:[],
          showfooter:false
      }
  },
  created(){
      this.setdata();
  },
  methods:{
    setdata(){
        const res =  Http.get("/app-data").then(res =>{
        this.site_data = res.data;
        this.showfooter =true;
      });
    }
  },
};
</script>

<style>
/* nprogress */
#nprogress .bar{
  background: linear-gradient(-45deg, #f002f8,#9953ea,#4a38d2,#421af5)!important;
  height: 5px!important;
}
#nprogress .peg {
  box-shadow: 0 0 10px #f002f8, 0 0 5px #421af5!important;
}

 #nprogress .spinner-icon {
    /* width: 70px!important;
    height: 70px!important;
    box-sizing: border-box!important;
    border: solid 2px transparent!important; */
    border-top-color: #615cfd!important;
    border-left-color: #421bf3!important;
}


/*#nprogress .spinner {
    position: fixed;
    z-index: 1031;
    top: 0px!important;
    right: 0px!important;
    display: flex!important;
    justify-content: center;
    align-items: center;
    width: 100%!important;
    height: 100vh!important;
    padding: 0px;
}
#nprogress .spinner:before {
    color: red!important;
    opacity: 0.5;
    content: "\f121"!important;
    font-size: 0px!important;
    background-color: #fde7f9!important;
    background-image: linear-gradient(315deg, #fde7f9 0%, #aacaef 74%)!important;
    position: absolute!important;
    width: 100%!important;
    height: 100vh!important;
} */


/* nprogress */
a.router-link-active.router-link-exact-active.nav-link {
    border-bottom: 2px solid #ffff;
    border-radius: 2px;
}
html {
  scroll-behavior: smooth;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width:10px;
}
 
::-webkit-scrollbar-track {
    background-color: #ffff;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #615cfd; 
}
a#scrollUp {
    position: absolute;
    bottom: 30px;
    right: 30px;
    background: #615cfd;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    font-size: 25px;
     box-shadow: 0px 0px 5px #615cfd;
}

.Appointment .book_btn a {
    background: #615cfd!important;
    padding: 7px 12px!important;
    font-size: 14px!important;
    font-weight: 500!important;
    border: 1px solid transparent!important;
    color: #fff!important;
    -webkit-border-radius: 0px!important;
    -moz-border-radius: 0px!important;
    border-radius: 0px!important;
}
#scrollUp{
  background: #615cfd;
  color:#ffff;
}
</style>