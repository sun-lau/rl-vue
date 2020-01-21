<template>
	<div class="about">
		<v-card
			class="mx-auto"
			outlined>
			<div v-if="$i18n.locale =='en'" class="ma-4">
				<h2>About</h2>
				<p>Laboratory teaching is an indispensible part of science education. The processes of making observations, performing systematic and quantitative investigations, data collection, analysis and logical interpretation of results and drawing relevant conclusions, are the skills fundamental to the training of all science subjects. Performing experiments also serve to reinforce students’ classroom learning experiences.</p>
				<p>Ironically, many of the scientific ideas are taught with only very limited support of the corresponding experiments, for a number of reasons. These could be cost, space and safety implications for implementing the experiments. Faced with these situations, teachers generally perform slide/video shows of the related experiments or to run computer simulations based on textbook equations and models. While such alternative learning and teaching (L&T) approaches provide supplementary information to students about the scientific principles involved, there are pitfalls associated with these techniques.</p>
				<p>Starting 2010, the Department of Applied Physics (AP) has launched a centralized depository of selected physics experiments. While the initial goal of the platform was for PolyU undergraduates admitted to AP’s service-teaching subjects, the idea has since gained popularity and is now also available for senior secondary school students. These are setups either not normally installed in secondary schools, or those that can pose danger for unskilled operators.</p>
				<p>Through the years, we have established a number of physics experiment setups:</p>
				<ul>
					<li>damped oscillations</li>
					<li>interference and diffraction of light</li>
					<li>radioactivity</li>
					<li>Earth’s magnetic field</li>
				</ul>
			</div>
			<div v-if="$i18n.locale =='zh-hk'" class="ma-4">
				<h2>關於遙距實驗室</h2>
				<p>實驗教學是科學教育中不可或缺的一部份。觀察、系統和定量研究、數據的收集、實驗結果的分析和邏輯演繹及得出相關結論皆為所有科學的基礎訓練。進行實驗亦有助加強學生的課堂學習經驗。</p>
				<p>諷刺的是，成本、空間、安全等原因導致科學理論只能透過短片或電腦模擬等形式教授予學生，令學生較少進行科學實驗。雖然短片或電腦模擬等的替代方案能為學生提供相關資訊，但對學生學習來說，仍是有不足</p>
				<p>由2010年開始，香港理工大學應用物理學系開始集中優化數個物理實驗，為其建立中央處理系統，希望為香港理工大學本科生提供優質教學。此計劃深受本科生歡迎，並已推廣至高中學生。本計劃的實驗裝置於正常情況下均不會安裝於中學內，以防止因不當操作產生危險。</p>
				<p>經過幾年努力，我們已經建立了一些物理實驗設置：</p>
				<ul>
					<li>阻尼振盪</li>
					<li>光的干擾和衍射</li>
					<li>放射活性</li>
					<li>地球磁場</li>
				</ul>
			</div>
		</v-card>
	</div>
</template>
<script>
	import moment from 'moment';
	export default {
		name: 'about',
		components: {
		},
		data:function(){
			return{
				logo:require('@/assets/remotelab-logo-small.png'),
			}
		},
		mounted: function(){
			var self = this;
		},
		methods:{
		}
	}
</script>
