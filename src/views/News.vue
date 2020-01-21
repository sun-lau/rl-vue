<template>
	<div class="news">
		<v-container fluid>
		<v-row dense>
			<v-col
			v-for="card in cards"
			:key="card.title"
			:cols="card.flex"
			>
			<v-card>
				
				<div class="d-flex flex-no-wrap">
				<v-avatar
					class="ma-3"
					size="125"
					tile
				>
					<v-img
					:src="card.src"
					>
					</v-img>
				</v-avatar>
				<div>
					<v-card-title
					class="headline mt-1"
					v-text="card.title"
					></v-card-title>
					<v-card-subtitle v-text="card.date"></v-card-subtitle>

				</div>
				</div>
			</v-card>
			</v-col>
		</v-row>
		</v-container>
	</div>
</template>
<script>
	import moment from 'moment';
	export default {
		name: 'news',
		components: {
		},
		data:function(){
			return{
				cards: [
					{ 
						title: '24小時隨時做實驗 理大網上平台開放',
						date: '2016-12-28',
						src: require('@/assets/mingpao.png'),
						flex: 12 
					},
					{ 
						title: '創遙距物理實驗平台 理大獲國際教學獎',
						date: '2016-12-28',
						src: require('@/assets/singtao.png'),
						flex: 12 
					},
					{ 
						title: '理大遙距平台 隨時隨地做實驗',
						date: '2016-12-28',
						src: require('@/assets/takung.jpg'),
						flex: 12 
					},
					{ 
						title: '搭建「遙距實驗平台」 理大奪教學創新金獎',
						date: '2016-12-28',
						src: require('@/assets/wenweipo.jpg'),
						flex: 12 
					}
				],
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
		}
	}
</script>
