<template>
    <div :class="socail_class">
        <ul>
            <li><a v-bind:href="social_link.facebook" target="_blank"> <i class="fa fa-facebook"></i> </a></li>
            <li><a v-bind:href="social_link.linkedin" target="_blank"> <i class="fa fa-linkedin"></i> </a></li>
            <li><a v-bind:href="social_link.instagram" target="_blank"> <i class="fa fa-instagram"></i> </a></li>
            <li><a v-bind:href="social_link.twitter" target="_blank"> <i class="fa fa-twitter"></i> </a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                social_link:[]
            }
        },
        props: { sitedata:Object,socail_class:String},
        mounted(){
            this.social_link = this.sitedata;
        }
    }
</script>
