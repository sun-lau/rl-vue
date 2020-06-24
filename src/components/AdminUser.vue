<template>
    <div class="adminUser">
        <v-card>
            <v-data-table dense :headers="headers" :items="api.users" item-key="username"></v-data-table>
        </v-card>
    </div>
</template>

<script>
	import moment from 'moment';
    import {Admin_APIService} from '@/services/Admin_APIService';
    const apiService = new Admin_APIService(process.env.VUE_APP_BASE_URL);
    export default {
    name: 'AdminUser',
    props: {
    },
    data:function(){
        return {
            api:{
                users:[]
            },
            headers: [
                { text: 'Username', value: 'username' },
                { text: 'Email', value: 'email' },
                { text: 'Last Login', value: 'last_login_at' }
            ],
            }
    },
    computed: {
    },
    methods:{
    },
    mounted:function(){
        var self = this;
        apiService.listAllUsers()
        .then((response) => {
            self.api.users = response.users;
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>