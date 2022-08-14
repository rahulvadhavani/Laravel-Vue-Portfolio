<template v-if="show">
    <section  id="resume" class="resume">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row" v-for="field in data.data" :key="field.id">
                <div class="row">
                   <div v-if="field.type == 'sumary'">
                      <h3 class="resume-title">{{field.type}}</h3>
                        <div class="resume-item pb-0">
                          <ul>
                              <div v-for="sumary in field.data" :key="sumary.id">
                              <li><strong>{{sumary.title}} : </strong> {{sumary.value}}</li>
                              </div>
                          </ul>
                      </div>
                    </div>
                    <div v-else-if="field.type == 'education'">
                      <h3 class="resume-title" >{{field.type}}</h3>
                      <div v-for="education in field.data" :key="education.id">
                        <div class="resume-item">
                          <h4>{{education.degree}}</h4>
                          <h5>{{education.year}}</h5>
                          <p class="px-2 py-1"><em>{{education.institute}} ,{{education.address}}</em></p>
                          <p class="px-2 py-1">{{education.description}}</p>
                        </div>
                      </div>
                    </div>
                    <div class="" v-else-if="field.type =='experience'">
                        <h3 class="resume-title">{{field.type}}</h3>
                        <div class="resume-item"  v-for="experience in field.data" :key="experience.id">
                          <h4>{{experience.job_title}}</h4>
                          <h5>{{experience.year}}</h5>
                          <p><em>{{experience.company}}, {{experience.address}}</em></p>
                          <p class="px-2 py-1">{{experience.description}}</p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </section>
</template>

<script>

import Http from '../HTTP';
import { ref, onMounted} from 'vue';

export default {
    

    setup(){
        let data = ref([]);
        let show = ref(false);
        let setdata = async()=>{
            const res = await Http.get("/resume-data").then(res =>{
               data.value = res.data;
               show.value = true;
            });
        }
        onMounted(setdata());
        return{
            data,show
        }
    },  
}
</script>
<style scoped>
.resume .resume-title {
  font-size: 26px;
  font-weight: 700;
  margin-top: 20px;
  margin-bottom: 20px;
  color: #45505b;
}
.resume .resume-item {
  padding: 0 0 20px 20px;
  margin-top: -2px;
  border-left: 2px solid #615CFD;
  position: relative;
}
.resume .resume-item h4 {
  line-height: 18px;
  font-size: 18px;
  font-weight: 600;
  text-transform: uppercase;
  font-family: "Poppins", sans-serif;
  color: #615CFD;
  margin-bottom: 10px;
}
.resume .resume-item h5 {
  font-size: 16px;
  background: #f7f8f9;
  padding: 5px 15px;
  display: inline-block;
  font-weight: 600;
  margin-bottom: 10px;
}
.resume .resume-item ul {
  padding-left: 20px;
}
.resume .resume-item ul li {
  padding-bottom: 10px;
}
.resume .resume-item:last-child {
  padding-bottom: 0;
}
.resume .resume-item::before {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  border-radius: 50px;
  left: -9px;
  top: 0;
  background: #fff;
  border: 2px solid #615CFD;
}

</style>