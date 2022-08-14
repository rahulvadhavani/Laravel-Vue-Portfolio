<template>
    <Breadcrumb title="Dashboard"></Breadcrumb>
      <section class="blog_area p-3 mt-2 mb-5">
        <div class="container">
            <div class="row d-flex align-items-center text-white justify-content-between bg-primary p-2 mb-4 mx-2 rounded">
                <h1 class="h3"></h1>
                <a title="Logout"  class="nav-item nav-link" style="cursor: pointer;" @click="logout"><i class="text-white fa fa-power-off" aria-hidden="true"></i></a>
            </div>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-12">
                        <div class="card box_shadow">
                            <label id="profile_img" style="height: 305px;">
                            <div class="profile-pic h-100" :style="inlineStyle">
                            <label for="fileToUpload"><i class="fa fa-pencil"></i></label>
                            </div>
                            </label>
                            <div class="card-body">
                                <h5 class="card-title"><b>Email: </b>{{profile_data.email}}</h5>
                                <h5 class="card-title"><b>Name: </b>{{profile_data.first_name +' '+ profile_data.last_name}}</h5>
                                <h5 class="card-title"><b>UserName: </b>{{profile_data.user_name}}</h5>
                                <h5 class="card-title"><b>UserName: </b>{{profile_data.phone}}</h5>
                            </div>
                        </div>
                    </div>
                    <!-- phone image email user_name last_name first_name  --> 
                    <div class="col-lg-8 col-md-12">
                        <div class="tab-content" id="pills-password">
                            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form enctype="multipart/form-data"  @submit.prevent="handleSubmitProfile" novalidate="novalidate">
                                <div class="card box_shadow">
                                    <input type="File" @change="onFileChange" id="fileToUpload" fileCount = $event.target.files.length>
                                    <div class="card-body">
                                        <div class="row clearfix">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control" placeholder="First name" v-model="profileForm.first_name" required autofocus autocomplete="off" type="text">
                                                <span class="text-danger" v-if="v$.first_name.$error">{{ v$.first_name.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Last Name</label>
                                                <input v-model="profileForm.last_name" required autofocus autocomplete="off" type="text" class="form-control" placeholder="Last Name">
                                                <span class="text-danger" v-if="v$.last_name.$error">{{ v$.last_name.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Username</label>
                                                <input v-model="profileForm.user_name" required autofocus autocomplete="off" type="text" class="form-control" placeholder="Username">
                                                <span class="text-danger" v-if="v$.user_name.$error">{{ v$.user_name.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone</label>
                                                <input v-model="profileForm.phone" required autofocus autocomplete="off" type="number" class="form-control" placeholder="Mobile">
                                                <span class="text-danger" v-if="v$.phone.$error">{{ v$.phone.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button :disabled="submitDisable" type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div><br>
                        <div class="tab-content" id="pills-password">
                            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form @submit.prevent="handleSubmitupdatePassword" novalidate="novalidate">
                                <div class="card box_shadow">
                                    <div class="card-body">
                                        <div class="row clearfix">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Old Password</label>
                                                
                                                <input class="form-control" placeholder="Old Password" v-model="passwordForm.old_password" required autofocus autocomplete="off" type="password">
                                                <span class="text-danger" v-if="r$.old_password.$error">{{ r$.old_password.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">New Password</label>
                                                <input v-model="passwordForm.password" required autofocus autocomplete="off" type="password" class="form-control" placeholder="New Password">
                                                <span class="text-danger" v-if="r$.password.$error">{{ r$.password.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Confirm Password</label>
                                                <input v-model="passwordForm.password_confirmation" required autofocus autocomplete="off" type="password" class="form-control" placeholder="Confirm Password">
                                                <span class="text-danger" v-if="r$.password_confirmation.$error">{{ r$.password_confirmation.$errors[0].$message }}</span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                         <button :disabled="submitDisable" type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><br>
</template>

<script>
import Breadcrumb from '../components/Breadcrumb.vue';
import Http from '../HTTP';
import { useToast } from "vue-toastification";
import {reactive, ref,onMounted,computed} from 'vue';
import useValidate from "@vuelidate/core";
import { required, email, minLength} from "@vuelidate/validators";
import { useRouter} from 'vue-router';

export default {
     setup() {
        //  
        const router = useRouter();
        const toast = useToast();
        let submitDisable = ref(false);
        let profile_data = ref([]);
        const pfile = ref('');
        let profileForm = reactive({
            first_name: '',
            last_name: '',
            user_name: '',
            phone: '',
        });
        let passwordForm = reactive({
            password_confirmation: '',
            password: '',
            old_password: '',
        });
        let profile_img = ref('');

        const rules = computed(() => {
            return {
                first_name: { required, minLength: minLength(2)},
                last_name: { required, minLength: minLength(2)},
                user_name: { minLength: minLength(2)},
                phone: {minLength: minLength(6)},
            };
        });
        const passwordrules = computed(() => {
            return {
                old_password: {required, minLength: minLength(6)},
                password: { required, minLength: minLength(6)},
                password_confirmation: { required, minLength: minLength(6)},
            };
        });
        const v$ = useValidate(rules, profileForm);
        const r$ = useValidate(passwordrules, passwordForm);
        const resetForm = ()=>{
            passwordForm.password= '';
            passwordForm.password_confirmation= '';
            passwordForm.old_password= '';
        };
      
        const logout = async(e)=> {
            const res = await Http.post("user/logout").then(res =>{
                if(res.data.status){
                    toast.success(res.data.message);
                    window.location.href = "/";
                }else{
                    toast.error(res.data.message);
                }
            });
        }
        const onFileChange = (e)=> {
            pfile.value = e.target.files[0];
            profile_img.value = URL.createObjectURL(pfile.value);
        }
         
        const getProfile = async()=> {
            const res = await Http.get("user/get-profile").then(res =>{
                if(res.data.status){
                    res.data = res.data.data;
                    profileForm.first_name = res.data.first_name;
                    profileForm.last_name = res.data.last_name;
                    profileForm.phone = res.data.phone;
                    profileForm.user_name = res.data.user_name;
                    profile_img.value = res.data.image;
                    profile_data.value = res.data;
                    
                }else{
                    if(res.data.code == 401){
                        router.push("/login");
                    }
                    this.toast.error(res.data.message);
                }
            });
        }

        const handleSubmitProfile = async(e)=>{
            v$.value.$validate();
            if (!v$.value.$error) {
                let formData = new FormData();
                formData.append('file', pfile.value);
                Object.keys(profileForm).forEach(key => {
                    formData.append(key,profileForm[key]);
                });
                console.log(formData);
                submitDisable = true;
                const res = await Http.post("/user/update-profile",formData,{ headers: {'Content-Type': 'multipart/form-data' }}).then(res =>{
                    if(res.data.status){
                        toast.success(res.data.message);
                        getProfile();
                        v$.value.$reset();
                        submitDisable = false;
                    }else{
                        if(res.data.code == 401){
                            router.push("/login");
                        }
                        toast.error(res.data.message);
                        submitDisable = false;
                    }
                });
            }
        }

        const handleSubmitupdatePassword = async(e)=>{
            r$.value.$validate();
            if (!r$.value.$error) {
                submitDisable = true;
                const res = await Http.post("/user/change-password",passwordForm).then(res =>{
                    if(res.data.status){
                        toast.success(res.data.message);
                        r$.value.$reset();
                        resetForm();
                        submitDisable = false;
                    }else{
                        toast.error(res.data.message);
                        submitDisable = false;
                    }
                });
            }
        }
        onMounted(getProfile());
        return {toast,logout,getProfile,v$,profileForm,resetForm,submitDisable,profile_img,onFileChange,profile_data,passwordForm,r$,handleSubmitProfile,handleSubmitupdatePassword};
  	},
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    },
    computed: {
        inlineStyle () {
            return {
            backgroundImage: `url(${this.profile_img})`,
            backgroundSize: 'contain',
            backgroundRepeat: 'no-repeat',
            }
        }
    },
    components:{
      Breadcrumb,
    },
}
</script>
<style scoped>
 #profile_img .profile-pic {
        /* border-radius: 50%; */
        height: 200px;
        width: 100%;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        vertical-align: middle;
        text-align: center;
        color: transparent;
        transition: all .3s ease;
        text-decoration: none;
        /* cursor: pointer; */
        overflow: hidden;
    }

    #profile_img .profile-pic {
        z-index: 10;
        color: black;
        transition: all .3s ease;
        text-decoration: none;
    }

    #profile_img .profile-pic label {
        display: flex;
        position: absolute;
        top: 5px;
        right: 6px;
        font-size: 20px;
        background:#4343437a;
        width: 40px;
        height: 40px;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }

    #fileToUpload{
            display: none;
            cursor: pointer;
    }
    #profile_img{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        border-bottom: 1px solid lightgray;
    }
</style>


