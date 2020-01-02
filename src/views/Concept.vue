<template>
	<div class="concept">
		<h2>{{ $t("concept.title1") }}</h2>
		<p>{{ $t("concept.description1") }}</p>
        <br>
		<h2>{{ $t("concept.title2") }}</h2>
		<p>{{ $t("concept.description2") }}</p>
	</div>
</template>
<script>
	import moment from 'moment';
	export default {
		name: 'concept',
		components: {
		},
		data:function(){
			return{
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
		}
	}
</script>
