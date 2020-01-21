<template>
	<div class="concept">
		<v-card
			class="mx-auto"
			outlined>
		<div v-if="$i18n.locale =='en'" class="ma-4">
			<h2>Concept</h2>
			<p>The design of the experiment platform is illustrated in the figure below. Registered users can securely login to a server hosted in PolyU, which grants access to the interfacing control program in a local console. This local console is responsible for manipulating various components of the experiment setup, data acquisition from sensors and the signal transmission to the user. Real-time video monitoring is also facilitated to visualize the experiment ‘in action’.Background as well as supporting materials will be also provided for students.</p>
			<v-img :src="images.concept" max-width="400px"/>
			<h2>Benefits</h2>
			<ul>
				<li>Highly flexible for adaptation in different learning and teaching modes (class demonstrations, individual/ group assignments, systematic investigations), as deemed suitable by instructors.</li>
				<li>Students and/or teachers can operate such setups in a way similar to running the experiment in school laboratories, at any time and from everywhere (as long as internet access is available).</li>
				<li>Automated data acquisition provides a scaffold for students to take and analyze a large number of good quality data, gives students a chance to learn how to analyze many data points and draw a reasonable conclusion based on such analysis.</li>
			</ul>
		</div>
		<div v-if="$i18n.locale =='zh-hk'" class="ma-4">
			<h2>概念</h2>
			<p>實驗平台的設計說明如下圖所示。已登記用戶可以安全地登入到位於香港理工大學的伺服器，進入控制台的介面控制程式。本控制台負責操縱各種實驗設置組件，收集來自感應器的數據並傳送至用戶。實驗設置的狀態和控制情況會以實時影片展示於用戶眼前。背景及配套資料亦會提供予學生。</p>
			<v-img :src="images.concept" max-width="400px"/>
			<h2>優勢</h2>
			<ul>
				<li>可供導師選擇不同的學習和教學模式（課堂演示，個人/分組研究），高度靈活。</li>
				<li>近乎真實的實驗室使用和管理，在任何時間，只要有網絡連接，就可從世界各地的方式進行操作實驗。</li>
				<li>自動化的數據收集可令學生收集及分析大量高質素的數據，讓學生有機會學習如何分析大量數據，並得出基於這樣的分析合理的結論。</li>
			</ul>
		</div>
		</v-card>
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
				images:{
					concept: require('@/assets/remotelab-concept.png'),
				},
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
		}
	}
</script>
