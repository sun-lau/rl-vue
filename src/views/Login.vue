<template>
	<div class="login">
         <v-content>
            <v-container fill-height="fill-height">
                <v-layout>
                <v-flex class="login-form"> 
                    <v-card>
                        <v-card-text>
                            <div class="subheading">
                            <template v-if="options.isLoggingIn">
                                <h4>Login</h4>
                            </template>
                            <template v-else>
                                <h4>Crate a new account</h4>
                            </template>
                            </div>
                            <v-form @submit="onSubmit">
                                <v-text-field v-model="form.username" light="light" label="Username"></v-text-field>
                                <v-text-field v-if="!options.isLoggingIn" v-model="form.email" light="light" label="Email"></v-text-field>
                                <v-text-field v-model="form.password" light="light" label="Password (6+ characters)" type="password"></v-text-field>
                                <v-text-field v-if="!options.isLoggingIn" v-model="form.confirm_password" light="light" label="Confirm Password" type="password"></v-text-field>
                                <v-btn v-if="options.isLoggingIn" block="block" type="submit">Login</v-btn>
                                <v-btn v-else block="block" type="submit" >Register</v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                    <div class="mt-4 float-right" v-if="options.isLoggingIn">Don't have an account?<br>
                        <v-btn class="mt-4 float-right" light="light" @click="options.isLoggingIn = false">Register</v-btn>
                    </div>
                    <div class="mt-4 float-right" v-else>Already had an account?<br>
                        <v-btn class="mt-4 float-right" light="light" @click="options.isLoggingIn = true">Login</v-btn>
                    </div>
                </v-flex>
                </v-layout>
            </v-container>
        </v-content>
	</div>
</template>
<script>
	import moment from 'moment';
    import {Auth_APIService} from '@/services/Auth_APIService';
    const apiService = new Auth_APIService(process.env.VUE_APP_BASE_URL+'/../auth/');
	export default {
		name: 'login',
		components: {
		},
		data:function(){
			return{
                form: {
                    username: '',
                    email: '',
                    password: '',
                    confirm_password: ''
                },
                options: {
                    isLoggingIn: true,
                },
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
            onSubmit(evt) {
                var self = this;
                evt.preventDefault()
                self.overlay = true;
                if(self.options.isLoggingIn){   //login
                    apiService.login(self.form.username, self.form.password)
                    .then((response) => {
                        console.log("response");
                        console.log(response);
                        if(response.status == "fail"){
                            alert(response.message);
                        }else{
                            self.$cookies.set('auth_token', response.token);
                            self.$cookies.set('username', response.username);
                            console.log(self.$cookies.get('username'));
                            console.log(self.$cookies.get('auth_token'));
                            self.$router.go(-1);
                            self.$store.commit('showSnackBar', "Login Success");
                        }
                    })
                }
                else{   //register
                    apiService.register(self.form.username, self.form.email, self.form.password, self.form.confirm_password)
                    .then((response) => {
                        console.log("response");
                        console.log(response);
                        if(response.status == "fail"){
                            alert(response.message);
                        }else{
                            self.$store.commit('showSnackBar', "Register Success! You can login now.");
                            self.options.isLoggingIn = true;
                        }
                    })
                }
            },
		}
	}
</script>
<style>
.login-form{
  width: 500px
}
</style>