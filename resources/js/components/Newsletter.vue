<template>
   <h4 class="widget_title">Newsletter</h4>
    <form action="#" @submit.prevent="submitData">
        <div class="form-group">
            <input class="form-control" v-model="form.email"  type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder = 'Enter email address'>
            <span class="text-danger" v-if="v$.email.$error">{{ v$.email.$errors[0].$message }}</span>
        </div>
        <button :disabled="submitDisable" class="button mt-1 rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">Subscribe</button>
    </form>
</template>

<script>
import Http from '../HTTP';
import {reactive, ref,computed} from 'vue';
import { useToast } from "vue-toastification";
import useValidate from "@vuelidate/core";
import { required, email} from "@vuelidate/validators";
export default {
     setup(){
        const toast = useToast();
        let submitDisable = ref(false);
        var errors = ref([]);
        let form = reactive({
            'email':""
        });

        const rules = computed(() => {
        return {
            email: { required, email },
            };
        });
        const v$ = useValidate(rules, form);
        return {v$,form,toast,submitDisable};
    },
    methods: {
  		async submitData() {
        this.v$.$validate();
        if (!this.v$.$error) {
        this.submitDisable = true;
            const res = await Http.post("/newsletter",this.form).then(res =>{
                if(res.data.status){
                this.toast.success(res.data.message);
                this.form.email = "";
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
