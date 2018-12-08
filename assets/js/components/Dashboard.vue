<template>
    <Layout :style="{minHeight: '100vh'}">
        <Sider 
            ref="side1" 
            hide-trigger 
            collapsible 
            :collapsed-width="74" 
            v-model="isCollapsed"
        >
            <Files 
               :uploaded_files="uploaded_files" 
               @open_file="showMessage"
            />
        </Sider>
        <Layout>
            <Header :style="{padding: 0}" class="layout-header-bar">
                <Icon @click.native="collapsedSider" :class="rotateIcon" :style="{margin: '0 20px'}" type="md-menu" size="24"></Icon>
                <router-link to="/">
                    <Button size="large" type="default">Upload</Button>
                </router-link>
                
                <Dropdown style="margin-left: 20px">
                    <Button type="primary">
                        Export chat
                        <Icon type="ios-arrow-down"></Icon>
                    </Button>
                    <DropdownMenu slot="list">
                        <router-link to="/export/csv"> 
                            <DropdownItem>CSV</DropdownItem>
                        </router-link>
                        <router-link to="/export/json"> 
                            <DropdownItem>JSON</DropdownItem>
                        </router-link>
                    </DropdownMenu>
                </Dropdown>
            </Header>
            <Content :style="{margin: '20px', background: '#fff', minHeight: '260px'}">
                <Messages :messages="messages" :users="users" />
            </Content>
        </Layout>
    </Layout>
</template>

<script>
import Messages from './Messages';
import Files from './Files';
import wretch from 'wretch';

export default {
    name: "Dashboard",
    components :{
        Messages,
        Files
    },
    data () {
        return {
            isCollapsed: false,
            messages: [],
            uploaded_files: [],
            users: [],
        }
    },
    watch: {

    },
    computed: {
        rotateIcon () {
            return [
                'menu-icon',
                this.isCollapsed ? 'rotate-icon' : ''
            ];
        },
    },
    mounted() {
        try {    
            // Store file in session sata                    
            let files = JSON.parse(localStorage.getItem('files')) || []
            this.uploaded_files = files
        } catch(e) { console.log(e) }

        this.showMessage(this.$route.params.file_id);
    },
    methods: {
        collapsedSider () {
            this.$refs.side1.toggleCollapse();
        },
        showMessage(file_name) {
            fetch('/messages', {
                    method: "POST",
                    body: `file_name=${file_name}`,
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                })
                    .then( response => response.json())
                    .then( (response) => {
                        if (response.status == "success") {
                            this.messages = response.messages;
                            // Remove the user named from_whatsapp.
                            // messages from `from_whatsapp` are not sent from any of the user.
                            // These care message like - "Messages you sent here are now encrypted"
                            this.users = response.users.filter(user => user !== 'from_whatsapp');
                        }
                    });
        }
    }
}
</script>

<style scoped>
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .layout-header-bar{
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.1);
    }
    .layout-logo-left{
        width: 90%;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        margin: 15px auto;
    }
    .menu-icon{
        transition: all .3s;
    }
    .rotate-icon{
        transform: rotate(-90deg);
    }
</style>
