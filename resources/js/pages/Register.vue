<template>
    <Breadcrumb title="Register"></Breadcrumb>
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form class="auth-form" @submit.prevent="handleSubmit" novalidate="novalidate">
                        <div class="row mx-auto">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-12 col-form-label">First Name <span class="text-danger"> * </span></label>
                                    <div class="col-sm-12">
                                        <input type="text" id="first_name" name="first_name" v-model="form.first_name" required placeholder="First Name" autofocus autocomplete="off" class="single-input">
                                        <span class="text-danger" v-if="v$.first_name.$error">{{ v$.first_name.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="last_name" class="col-sm-12 col-form-label">Last Name <span class="text-danger"> * </span> </label>
                                    <div class="col-sm-12">
                                        <input type="text" id="last_name" name="last_name" v-model="form.last_name" required placeholder="Last Name" autofocus autocomplete="off" class="single-input">
                                        <span class="text-danger" v-if="v$.last_name.$error">{{ v$.last_name.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label">Email <span class="text-danger"> * </span> </label>
                                    <div class="col-sm-12">
                                        <input id="email" type="email" class="single-input" placeholder="Email" v-model="form.email" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.email.$error">{{ v$.email.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-12 col-form-label">Phone</label>
                                    <div class="col-sm-12">
                                        <input id="phone" type="number" class="single-input" placeholder="Phone" v-model="form.phone" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.phone.$error">{{ v$.phone.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="password" class="col-sm-12 col-form-label">Password <span class="text-danger"> * </span></label>
                                    <div class="col-sm-12">
                                        <input id="password" type="password" class="single-input" placeholder="Password" v-model="form.password" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.password.$error">{{ v$.password.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="confirm_password" class="col-sm-12 col-form-label">Confirm Password <span class="text-danger"> * </span></label>
                                    <div class="col-sm-12">
                                        <input id="confirm_password" type="password" placeholder="Confirm Password" class="single-input" v-model="form.confirm_password" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.confirm_password.$error">{{ v$.confirm_password.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                           <br>
                            <div class="col-sm-12 mt-4">
                                <div class="col-sm-12 text-center">
                                    <button :disabled="submitDisable" type="submit" class="button button-contactForm btn_4 boxed-btn">
                                        Register
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <div class="col-sm-12 text-center">
                                    Already have account? <router-link class="" data-toggle="collapse" :to="{ name: 'login' }">Login</router-link>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Breadcrumb from '../components/Breadcrumb.vue';
import {reactive, ref,onMounted,computed} from 'vue';
import { useToast } from "vue-toastification";
import useValidate from "@vuelidate/core";
import { required, email, minLength} from "@vuelidate/validators";
import Http from '../HTTP';
export default {
    setup() {
        const toast = useToast();
        let submitDisable = ref(false);
        let form = reactive({
            email: '',
            first_name: '',
            last_name: '',
            phone: '',
            password: '',
            confirm_password: '',
        });

        const rules = computed(() => {
            return {
                email: { required, email },
                first_name: { required, minLength: minLength(2)},
                last_name: { required, minLength: minLength(2)},
                phone: {minLength: minLength(6)},
                password: { required,minLength: minLength(6)},
                confirm_password: { required,minLength: minLength(6)},
            };
        });
        const v$ = useValidate(rules, form);
        const resetForm = ()=>{
            form.email= '';
            form.first_name= '';
            form.last_name= '';
            form.phone= '';
            form.password= '';
            form.confirm_password= '';
        };
        return {v$,form,toast,resetForm,submitDisable};
  	},
    methods: {        
        async handleSubmit(e) {
            this.v$.$validate();
            if (!this.v$.$error) {
                this.submitDisable = true;
                const res = await Http.post("/register",this.form).then(res =>{
                    if(res.data.status){
                        this.toast.success(res.data.message);
                        this.resetForm();
                        this.v$.$reset();
                        this.submitDisable = false;
                        window.location.href = "/login"
                    }else{
                        this.toast.error(res.data.message);
                        this.submitDisable = false;
                    }
                });


            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('home');
        }
        next();
    },
    components:{
      Breadcrumb,
    },
}
</script>
<style scoped>
.auth-form{
    padding: 40px 30px;
    border-radius: 11px;
    background: #f0eefc;
}
</style>

export default {

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