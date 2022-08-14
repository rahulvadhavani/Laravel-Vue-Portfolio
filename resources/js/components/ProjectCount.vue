<template>
     <div class="counter_area">
        <div class="container">
             <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-65">
                        <span><h3>Projects</h3></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="single_counter text-center">
                        <h3>
                            <span class="counter" >{{project_count}} </span><span>+</span>
                        </h3>
                        <p>Total Projects</p>
                    </div>
                </div>
                <div  class="col-xl-4 col-md-4">
                    <div class="single_counter text-center">
                        <h3>
                            <span class="counter">{{ruuning_project}} </span>
                        </h3>
                        <p>On Going Projects</p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="single_counter text-center">
                        <h3>
                            <span class="counter" >{{job_sucesss}} </span> <span>%</span>
                        </h3>
                        <p>Job Success</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
     props: ['job_sucesss','ruuning_project','project_count'],
}
</script>