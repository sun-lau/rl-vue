<template>
	<div class="experiment">
        <div v-if="name=='apparent_depth'">
            <ApparentDepth />
        </div>
        <div v-if="name=='visible_spectrum'">
            <VisibleSpectrum />
        </div>
        <div v-if="name=='interference'">
            <Interference />
        </div>
        <div v-if="name=='bacteria_growth'">
            <BacteriaGrowth />
        </div>
        <div v-if="name=='em_induction'">
            <EmInduction />
        </div>
        
		<v-btn
            absolute
            dark
            top
            right
            color="green"
            class="mt-4"
		>
            <v-icon>mdi-clock</v-icon> {{parseInt(kick_time/60)}} mins left
		</v-btn>
	</div>
</template>
<script>
	import moment from 'moment';
    import ApparentDepth from '@/components/ApparentDepth.vue'
    import VisibleSpectrum from '@/components/VisibleSpectrum.vue'
    import Interference from '@/components/Interference.vue'
    import BacteriaGrowth from '@/components/BacteriaGrowth.vue'
    import EmInduction from '@/components/EmInduction.vue'
	export default {
		name: 'experiment',
		components: {
            ApparentDepth,
            VisibleSpectrum,
            Interference,
            BacteriaGrowth,
            EmInduction
		},
		data:function(){
			return{
                name:"",
                kick_time: null,
                role:null
			}
		},
		mounted: function(){
			var self = this;
            self.name = this.$route.query.name;
            self.kick_time = self.$cookies.get('kick_time');
            setInterval(function(){ //countdown protect
                self.kick_time = self.kick_time -1;
                if(self.kick_time < 0){
                    window.location.href = process.env.VUE_APP_BASE_URL;
                }
            },1000);
		},
		methods:{
		}
	}
</script>
