<template>
    <Scroll height="100vh">
        <Card 
           dis-hover v-for="(item, index) in messages" 
           :key="index" 
           :class="[(item.username == users[0]) 
                    ? 'message-left'
                    : (item.username  == 'from_whatsapp') ? 'from-whatsapp' : 'message-right']"
        >
           <nl2br tag="p" :text="`${item.username}: ${item.message}`" />
        </Card>
    </Scroll>
</template>
<script>
import Nl2br from 'vue-nl2br';

    export default {
        name: "Message",
        components: {
            Nl2br
        },
        props: {
            messages: Array,
            users: Array,
        },
        data () {
            return {
            }
        },
        methods: {
        },
        mounted(){
            console.log();
        }
    }
</script>
<style scoped>
    .from-whatsapp {
        margin: 8px 10% 8px 10%;
        background: #a4b0b1;
        color: white;
        font-size: 15px;
    }
    .message-left {
        margin: 16px 30% 16px 5px;
        background: #e8e8e8;
        color: #50596f;
        font-size: 15px;
    }
    .message-right {
        margin: 16px 5px 16px 30%;
        background: #436667;
        color: white;
        font-size: 15px;
    }
    
</style>