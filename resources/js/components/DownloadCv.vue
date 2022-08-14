<template>
<div class="download_cv">
    <a class="boxed-btn3" @click="downloadCv()">Download CV</a>
</div>
</template>
<script>
import Http from '../HTTP';
export default {
     setup(){
        let downloadCv = async()=> {
            const res = await Http.get("/download-cv",{ responseType: 'blob' }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'file.pdf');
                document.body.appendChild(fileLink);
                fileLink.click();
            });
        }
        return{
            downloadCv
        }
    },
}
</script>
