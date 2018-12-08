<template>
    <div>
        <Scroll height="100vh">
            <Menu theme="dark" active-name="0">
                <MenuGroup title="Prev files">
                     <router-link
                       v-for="(item, index) in uploaded_files" 
                       :to="{path: `/dashboard/${item.name}`}" 
                       :key="index"
                       replace
                      >
                        <MenuItem :name="index" @click.native="show_message(item.file_name)">
                            <Icon type="md-document" />
                            <span>{{item.name}}</span>
                        </MenuItem>
                     </router-link>
                </MenuGroup>
            </Menu>
        </Scroll>
    </div>
</template>

<script>
export default {
    props: {
        uploaded_files: Array,
        users: Array,
    },
    data() {
      return {

      }
    },
    computed: {
        menuitemClasses () {
            return [
                'menu-item',
                this.isCollapsed ? 'collapsed-menu' : ''
            ]
        }
    },
    methods: {
        show_message(file_name) {
            this.$router.push({ path: `/dashboard/${file_name}` })
            this.$emit('open_file', file_name);
        }
    }
}
</script>

<style scoped>
    .menu-item span{
        display: inline-block;
        overflow: hidden;
        width: 69px;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: bottom;
        transition: width .2s ease .2s;
    }
    .menu-item i{
        transform: translateX(0px);
        transition: font-size .2s ease, transform .2s ease;
        vertical-align: middle;
        font-size: 16px;
    }
    .collapsed-menu span{
        width: 0px;
        transition: width .2s ease;
    }
    .collapsed-menu i{
        transform: translateX(5px);
        transition: font-size .2s ease .2s, transform .2s ease .2s;
        vertical-align: middle;
        font-size: 22px;
    }
</style>