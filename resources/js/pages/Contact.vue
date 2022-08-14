<template>
    <Breadcrumb title="Contact"></Breadcrumb>
      <!-- ================ contact section start ================= -->
  <section class="contact-section section_padding">
    <div class="container">
      <div class="d-none d-sm-block mb-5 pb-4">
        <div id="map" style="height: 480px;">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2947.603593633349!2d72.88681352273551!3d21.211431891178627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04fc86dcdc49f%3A0x15f9dc223e77362d!2sSavaliya%20circale!5e0!3m2!1sen!2sin!4v1646486378940!5m2!1sen!2sin" width="100%" height="480" style="border:0;" allowfullscreen="true" loading="lazy"></iframe>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h2 class="contact-title">Get in Touch</h2>
        </div>
        <div class="col-lg-8">
          <form class="form-contact contact_form" @submit.prevent="submitData" novalidate="novalidate">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    <textarea v-model="form.message" class="form-control w-100"  cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder = 'Enter Message'></textarea>
                    <span class="text-danger" v-if="v$.message.$error">{{ v$.message.$errors[0].$message }}</span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" v-model="form.name"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder = 'Enter your name'>
                  <span class="text-danger" v-if="v$.name.$error">{{ v$.name.$errors[0].$message }}</span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" v-model="form.email"  type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder = 'Enter email address'>
                  <span class="text-danger" v-if="v$.email.$error">{{ v$.email.$errors[0].$message }}</span>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <input class="form-control" v-model="form.subject"  type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder = 'Enter Subject'>
                  <span class="text-danger" v-if="v$.subject.$error">{{ v$.subject.$errors[0].$message }}</span>
                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <button :disabled="submitDisable" type="submit" class="button button-contactForm btn_4 boxed-btn">Send Message</button>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>{{data.address}}</h3>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
            <div class="media-body">
              <h3><a href="tel:{{data.contact}}">{{data.contact}}</a></h3>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
            <h3><a href="mailTo:{{data.support_email}}">{{data.support_email}}vue</a></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ contact section end ================= -->    
</template>
<script>

import Http from '../HTTP';
import Breadcrumb from '../components/Breadcrumb.vue';
import {reactive, ref,onMounted,computed} from 'vue';
import { useToast } from "vue-toastification";
import useValidate from "@vuelidate/core";
import { required, email, minLength} from "@vuelidate/validators";

export default {
  components:{
    Breadcrumb,
    },
    setup() {
      const toast = useToast();
      
      let data = ref([]);
      let submitDisable = ref(false);
      let setdata = async()=>{
        const res = await Http.get("/contact").then(res =>{
        data.value = res.data;
        });
      }
      onMounted(setdata());
      let form = reactive({
        email: '',
        subject: '',
        name: '',
        message: '',
      });

      const rules = computed(() => {
        return {
          email: { required, email },
          subject: { required, minLength: minLength(6)},
          message: { required, minLength: minLength(10)},
          name: { required},
        };
      });
      const v$ = useValidate(rules, form);
      const resetForm = ()=>{
        form.email= '';
        form.subject= '';
        form.name= '';
        form.message= '';
      };
      return {data,v$,form,toast,resetForm,submitDisable};
  	},
    methods: {
  		async submitData() {
        this.v$.$validate();
  				if (!this.v$.$error) {
            this.submitDisable = true;
            const res = await Http.post("/contact-us",this.form).then(res =>{
              if(res.data.status){
                this.toast.success(res.data.message);
                this.resetForm();
                this.v$.$reset();
                this.submitDisable = false;
              }else{
                this.toast.error(res.data.message);
                this.submitDisable = false;
              }
            });
  				}
  		}
  	}
}

</script>
