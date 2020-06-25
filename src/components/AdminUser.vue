<template>
    <div class="adminUser">
        <v-card>
            <v-data-table dense :headers="headers" :items="api.users" item-key="username"></v-data-table>
            
        </v-card>
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">

        <v-btn class="ma-4" v-on="on">Batch Create Users</v-btn>
      </template>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Batch Create Users
        </v-card-title>
        <v-alert type="info">No space between, Password should be 6 digits+</v-alert>
        <v-card-text>
            <v-textarea
            name="input-7-1"
            label="username,email,password"
            v-model="batch_values"
            hint="line by line"
            ></v-textarea>
            Result:
            <p v-html="api.result_message"></p>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="batchCreateUsers()"
          >
            Create
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
                users:[],
                result_message:""
            },
            headers: [
                { text: 'Username', value: 'username' },
                { text: 'Email', value: 'email' },
                { text: 'Last Login', value: 'last_login_at' }
            ],
            batch_values:"",
            dialog: false
        }
    },
    computed: {
    },
    methods:{
        batchCreateUsers: function(){
            var self = this;
            console.log(self.batch_values);
            apiService.batchCreateUsers(self.$cookies.get('auth_token'), self.batch_values)
            .then((response) => {
                self.api.result_message = response.message;
                apiService.listAllUsers()
                .then((response) => {
                    self.api.users = response.users;
                });
            });
        }
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