<template>
   <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>{{title}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
     props: ['title'],
}
</script>
<style scoped>
.bradcam_bg_1 {
    height: 0px!important;
}
.bradcam_area {
    padding:100px 0px!important;
}

.bradcam_bg_1 {
    background: linear-gradient(-45deg, #f3344d,#9953ea,#4a38d2,#421af5);
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
    height: 70vh;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}
</style>
