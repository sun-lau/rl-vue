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
	</div>
</template>
<script>
	import moment from 'moment';
    import ApparentDepth from '@/components/ApparentDepth.vue'
    import VisibleSpectrum from '@/components/VisibleSpectrum.vue'
    import Interference from '@/components/Interference.vue'
	export default {
		name: 'experiment',
		components: {
            ApparentDepth,
            VisibleSpectrum,
            Interference,
		},
		data:function(){
			return{
                name:""
			}
		},
		mounted: function(){
			var self = this;
            self.name = this.$route.query.name;
		},
		methods:{
		}
	}
</script>
