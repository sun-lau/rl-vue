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
        <div v-if="name=='green_house'">
            <GreenHouse />
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
    import GreenHouse from '@/components/GreenHouse.vue'
	export default {
		name: 'experiment',
		components: {
            ApparentDepth,
            VisibleSpectrum,
            Interference,
            BacteriaGrowth,
            EmInduction,
            GreenHouse,
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
            self.$ga.page('/experiment/'+self.$route.query.name);
            self.name = self.$route.query.name;
            self.kick_time = self.$cookies.get('kick_time');
            setInterval(function(){ //countdown protect
                self.kick_time = self.kick_time -1;
                if(self.kick_time < 0){
                    self.$ga.event('Experiment', 'kick_out', self.$route.query.name);
                    window.location.href = process.env.VUE_APP_BASE_URL;
                }
            },1000);
            var ga_counter = 0;
            setInterval(function(){
                ga_counter += 10;
                self.$ga.event('Experiment', 'stay_'+ga_counter+'_mins', self.$route.query.name);
            },10*60*1000);
		},
		methods:{
		}
	}
</script>
