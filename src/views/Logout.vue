<template>
	<div class="logout">
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
			}
		},
		mounted: function(){
            var self = this;
            self.$cookies.remove("auth_token");
            self.$cookies.remove("username");
            self.$router.push("/");
			// window.location.href = process.env.VUE_APP_BASE_URL;
		},
		methods:{
		}
	}
</script>