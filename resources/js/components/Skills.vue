<template>
    <div class="text-center skill-maine-div">
        <div class="skill-box">
            <div class="f-item">
            <img class="skill-icon" :src="skill.image" :alt="skill.title">
            </div>
            <div class="skill-text">
            <h5>{{skill.title}}</h5>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
      skill: {
          type: Object
      }
    },
}
</script>
<style scoped>
.skill-maine-div {
    margin-bottom: 30px;
    position: relative;
}
.f-item {
    box-shadow: 0 0 20px rgb(37 43 55 / 20%);
    padding: 25px;
    margin-bottom: 15px;
    display: inline-block;
    transition: all .4s;
    position: relative;
    top: 0;
    z-index: 9;
    border-radius: 50%;
    background: #fff;
}
.f-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.328);
}
.skill-icon {
    width: 35px;
}

@media only screen and (max-width : 511px) {
.f-item {
    padding: 12px;
}
.skill-icon {
    width: 30px;
}
}
@media only screen and (max-width : 996px) {
.f-item {
    padding: 12px;
}
.skill-icon {
    width: 30px;
}
}

</style>