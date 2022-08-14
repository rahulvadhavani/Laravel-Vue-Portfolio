<template>
    <Breadcrumb title="Reset Password"></Breadcrumb>
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <form class="auth-form" @submit.prevent="handleSubmit" novalidate="novalidate">
                        <div class="row mx-auto">
                            <div class="col-sm-12">
                                <input type="hidden" v-model="form.token">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label">Email <span class="text-danger"> * </span> </label>
                                    <div class="col-sm-12">
                                        <input id="email" type="email" class="single-input" placeholder="Email" v-model="form.email" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.email.$error">{{ v$.email.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="password" class="col-sm-12 col-form-label">Password <span class="text-danger"> * </span></label>
                                    <div class="col-sm-12">
                                        <input id="password" type="password" class="single-input" placeholder="Password" v-model="form.password" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.password.$error">{{ v$.password.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-12 col-form-label">Confirm Password <span class="text-danger"> * </span></label>
                                    <div class="col-sm-12">
                                        <input id="password_confirmation" type="password" placeholder="Confirm Password" class="single-input" v-model="form.password_confirmation" required autofocus autocomplete="off">
                                        <span class="text-danger" v-if="v$.password_confirmation.$error">{{ v$.password_confirmation.$errors[0].$message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <div class="col-sm-12 text-center">
                                    <button :disabled="submitDisable" type="submit" class="button button-contactForm btn_4 boxed-btn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <div class="col-sm-12 text-center">
                                   Login Account ! <router-link class="" data-toggle="collapse" :to="{ name: 'login' }">Login</router-link>
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
    created(){
        this.setForm(this.$route.params.token,this.$route.query.email);
    },
   
    setup() {
        const toast = useToast();
        let submitDisable = ref(false);
        let form = reactive({
            email: '',
            password_confirmation: 'sfdd',
            password: '',
            token: '',
        });

        const rules = computed(() => {
            return {
                email: { required, email },
                password: { required,minLength:minLength(6)},
                password_confirmation: { required,minLength:minLength(6)},
            };
        });
        const v$ = useValidate(rules, form);
        const resetForm = ()=>{
            form.email= '';
            form.password_confirmation= '';
            form.password= '';
            form.token= '';
        };
        const setForm = (token,email="")=>{
            form.token = token;
            form.email = email;
        };
        return {v$,form,toast,resetForm,setForm,submitDisable};
  	},
    methods: {      
        async handleSubmit(e) {
            this.v$.$validate();
            if (!this.v$.$error) {
                this.submitDisable = true;
                const res = await Http.post("/reset-password",this.form).then(res =>{
                    if(res.data.status){
                        this.toast.success(res.data.message);
                        this.resetForm();
                        this.v$.$reset();
                        this.submitDisable = false;
                        this.$router.push('/dashboard'); 
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
            return next('/dashboard');
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