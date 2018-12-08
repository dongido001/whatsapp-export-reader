<template>
    <div class="wrapper">
        <div class="header"> 
            <h2>WhatsApp Export Reader</h2>
        </div>
        <Card class="content" style="height: 100%;">
            <div style="text-align:center">
                <Upload
                    accept=".txt"
                    type="drag"
                    action="/upload_file"
                    :on-success="gotoDashboard"
                >
                    <div class="drop-area">
                        <div></div>
                        <p>
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <br />
                            Click or drag files here to upload (.txt files only)
                        </p>
                    </div>
                </Upload>
            </div>
        </Card>
        <div class="footer"> &copy; 2018  </div>
    </div>
</template>

<script>
    export default {
        name: "upload-file",
        data(){
            return {
                files: []
            }
        },
        methods: {
            gotoDashboard(response, file, fileList) {
               if (response.status == "success") {
                   this.files.push({name: file.name, file_name: response.data});

                   try {    
                        localStorage.setItem('files', JSON.stringify(this.files)) 
                   } catch(e) {
                       localStorage.setItem('files', JSON.stringify([])) 
                   }
                   this.$router.push({ path: `/dashboard/${response.data}` });
               }
            }
        },
        mounted() {
            try {   
                this.files = JSON.parse(localStorage.getItem('files')) || [] 
            } catch(e) {
                localStorage.setItem('files', JSON.stringify([]))
                this.files = [] 
            }
        }
    }
</script>

<style>
   body, html {
       background: rgb(112, 60, 60);
   }
    .wrapper {
        display: grid;
        height: 100vh;
        /* grid-template-columns: repeat(3, 1fr); */
        grid-template-rows: 60px 1fr 30px;
        grid-template-areas:
           ". header header ."
           ". content content ."
           ". footer footer .";
        text-align: center;
    }
    .header {
        grid-area: header;
        align-self: center;
        justify-self: center;
        color: white;
        font-size: 19px;
    }
    .footer {
        grid-area: footer;
        align-self: center;
        justify-self: center;
        color: white;
        font-size: 19px;
    }
    .content {
        text-align: center;
        width: 100%;
        height: 100%;
        grid-area: content;
        align-self: center;
        justify-self: center;
    }
    .drop-area {
        display: grid;
        height: 70vh;
        font-size: 23px;
    }
</style>