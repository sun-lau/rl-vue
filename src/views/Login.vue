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
                            <template v-else="v-else">Crate a new account</template>
                            </div>
                            <v-form @submit="onSubmit">
                            <v-text-field v-model="form.username" light="light" label="Name"></v-text-field>
                            <!-- <v-text-field v-model="form.email" light="light" label="Email" type="email"></v-text-field> -->
                            <v-text-field v-model="form.password" light="light" label="Password" type="password"></v-text-field>
                            <v-btn v-if="options.isLoggingIn" block="block" type="submit">Sign in</v-btn>

                            <v-btn v-else="v-else" block="block" type="submit" @click.prevent="options.isLoggingIn = true">Sign up</v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                    <!-- <div class="mt-4" v-if="options.isLoggingIn">Don't have an account?
                        <v-btn light="light" @click="options.isLoggingIn = false">Sign up</v-btn>
                    </div> -->
                </v-flex>
                </v-layout>
            </v-container>
        </v-content>
	</div>
</template>
<script>
	import moment from 'moment';
    import {Root_APIService} from '@/services/Root_APIService';
    const apiService = new Root_APIService(process.env.VUE_APP_BASE_URL+'/api/accounts');
	export default {
		name: 'login',
		components: {
		},
		data:function(){
			return{
                rules: {
                required: value => !!value || 'Required.',
                min: v => v.length >= 8 || 'Min 8 characters',
                emailMatch: () => ('The email and password you entered don\'t match'),
                },
                form: {
                    username: '',
                    password: ''
                },
                user: {
                // email: 'admin@example.com',
                // password: 'admin',
                // name: 'John Doe',
                },
                options: {
                    isLoggingIn: true,
                    shouldStayLoggedIn: true,
                },
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
            onSubmit(evt) {
                var self = this;
                console.log("on submit");
                evt.preventDefault()
                self.overlay = true;
                apiService.postLogin(self.form.username, self.form.password)
                .then((response) => {
                    console.log("response");
                    console.log(response);
                    if(response.error){
                        alert(response.error);
                    }else{
                        self.$cookies.set('auth_token', response.auth_token);
                        self.$cookies.set('nickname', response.nickname);
                        console.log(self.$cookies.get('auth_token'));
                        // self.$root.updateAuth();
                        // self.$router.push("/");
                        window.location.href = process.env.VUE_APP_BASE_URL;
                    }
                })
            },
		}
	}
</script>
<style>
.login-form{
  width: 500px
}
</style>