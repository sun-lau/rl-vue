<template>
	<div class="news">
		<v-container fluid>
		<v-row dense>
			<v-col
			v-for="(card, i) in cards"
			:key="i"
			:cols="card.flex"
			>
			<v-card @click="openNews(i)">
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
		<v-dialog
			v-model="dialog"
			width="90%"
			>

			<v-card>
				<v-card-text v-if="current_news_index == 0">
					<div class="container">
						<div class="page-header">
							<h1>
								24小時隨時做實驗 理大網上平台開放        </h1>
						</div>
						<div class="text-justify">
							<p>時間：2016-12-28 來源：<a href="http://news.mingpao.com/pns/dailynews/web_tc/article/20161228/s00002/1482862084485" target="_blank">明報</a></p>
						<br>
						<img class="w-50" src="http://fs.mingpao.com/pns/20161228/s00046/8f3a3f8ad1abbdc8b0d5d3db8978191e.jpg">
						<br>
						<p class="text-center">理工大學應用物理系副教授麥熾良（左圖）表示，有了24小時開放的遙距平台後，學生不用被實驗時間所限，更可隨時隨地做實驗。學生只要經互聯網遙控實驗室內的電腦，電腦即會控制儀器完成實驗。平台現時提供共6個物理實驗，以右圖「光的干擾和衍射實驗」為例，學生透過互聯網遙控實驗室的電腦，由於電腦早已連接圖中架上左方的兩支激光，及不同大小的「篷」，當學生選了激光顏色及篷後，不同的組合會投映出不同的光譜，藉以學習不同篷對光的干擾。（鍾林枝攝）</p>

						<p>【明報專訊】做實驗是科學教育關鍵一環，但實驗課時間有限，部分學生未能在堂上親身做實驗，有大學教師發明「遙距物理實驗平台」，讓學生可透過電腦隨時隨地做實驗。</p>
						<p>負責此項發明的理工大學應用物理學系副教授麥熾良表示，平台讓學生透過互聯網控制實驗室內連接儀器的電腦，由電腦調整儀器完成實驗。不過由於是遙距實驗，平台每小時只可供一個學生使用，因此團隊設定平台24小時開放，希望讓更多學生能使用平台。</p>
						<p>遙距控制儀器 奪國際獎項</p>
						<p>麥熾良表示，應用物理系重視實驗學習，培養學生分析能力，強化邏輯演繹，惟他說實驗課有時限，學生或只能完成一次實驗，若過程有錯，更沒有時間再從頭做起；當學生課後想再練習，亦因實驗室空間不足而卻步。近年他發現學生分析實驗數據或撰寫報告的能力偏弱，不利更高的學術發展，於是在約4年前，與系中部分教師，一同發明實驗平台，讓學生可多做實驗。</p>
						<p>機械操作 降危險實驗影響</p>
						<p>除了打破時地限制，麥表示，平台亦可減低某些危險實驗對學生的影響。他以放射實驗為例，實驗室內有一個載有不同物料的轉盤、輻射機及機械臂，以往學生量度不同物料的輻射吸收率時，要自行轉動轉盤及放輻射，歷時約2小時，有損健康。麥說有了平台後，學生只需在互聯網控制室內電腦，由電腦發信號控制轉盤。</p>
						<p>盼擴大使用 增文憑生做實驗機會</p>
						<p>除了輻射，平台現時還提供超聲波、地球磁場、量度電子荷質比、光電效應、以及光干擾和衍射實驗。除了理大學生，本港共有10間中學、逾300名高中生正使用平台。麥表示文憑試學生比舊時高考生少了做實驗的機會，不利學生的分析能力，他希望將來擴大平台，讓更多高中生使用。</p>
						<p>「遙距實驗平台」今年12月得到由美國華頓商學院及國際大學評級機構合辦的「全球教學創新大獎」的「亞洲地區組別金獎」。</p>
						<p>理大應用社會科學系亦憑「同儕教學法」及「課堂即時答問系統」奪得通訊科技工具銅獎，學生只要在電腦或電話上登入系統，並撰寫答案，既可透過同儕教學法系統與同學討論，亦可透過答問系統提交答案予教師，令大班教學中，教師亦可掌握每名學生的學習進度。</p>    </div>
					</div>
				</v-card-text>
				<v-card-text v-if="current_news_index == 1">
					<div class="container">
						<div class="page-header">
							<h1>
								創遙距物理實驗平台 理大獲國際教學獎        </h1>
						</div>
						<div class="text-justify">
							<p>時間：2016-12-28 來源：<a href="http://std.stheadline.com/daily/news-content.php?id=1526376&amp;target=2" target="_blank">星島日報</a></p>
							<br>
							<img class="w-50" src="http://static.stheadline.com/stheadline/news_res/2016/12/28/332379/i_425x283_850105889.jpg">
							<br>
							<p class="text-center">理大兩個教學方法早前獲國際教學獎。應用物理學系副教授麥熾良（右三）創立遙距物理實驗平台；應用社會科學科助理教授（研究）陳顯宏（左三）設立即時回應系統。</p>

							<p>(星島日報報道)教學講求用心，如善用應用科技，更可提高教與學的效能。理工大學有教授創立遠東地區首個遙距物理實驗平台，只要有網絡連接，就能讓學生隨時隨地、不限次數地進行實驗，亦能進行安全要求較高的放射等實驗，補足一般學校沒有配備的實驗裝置，更獲「全球教學創新大獎二○一六」亞洲地區組別金獎，表揚其創新的教學方法。<br><br>實驗是科學教育中不可或缺的一部分，但受制於成本、空間等因素，現時實驗大多只以模擬短片或由教授示範代替。理大近年獲優質教育基金撥款資助逾三百五十萬元，建立遠東地區首個遙距物理實驗平台，能供學生隨時隨地、不限次數地進行實驗，從而提升他們的學習體驗，遙距物理實驗平台更在今屆全球教學創新大獎中，勇奪亞洲地區組別金獎。<br><br>應用物理學系副教授麥熾良解釋，「學生只需將電腦連接上網絡，登入帳戶，就可通過觀看監控攝影機、控制機械臂來進行實時的實驗，配合相關的教學影片、理論解說和評估報告；可按個人進度，待自己準備充足，才到網上預約何時何地做實驗。」他又指，該平台能自動產生大量數據，讓學生學習如何分析數據、邏輯演繹，並作出合理結論，裝備他們科學科所需的基礎訓練。<br><br>麥熾良又指平台推出後，一些易生危險的裝置會放置於獨立房，「例如做放射實驗，學生毋須近距離接觸具輻射的物料長達兩個多小時，確保安全之餘，亦補足到一般學校基於安全考量而不購買的器材。」他指平台的應用已由大學一年級生推展至高中生，同學的反饋均表示滿意，形容其「富彈性，可選擇夜深才做實驗」；將來計畫擴大至手機上應用。<br><br>另一得獎的教學方法則結合了同儕教學法和課堂即時答問系統，應用社會科學系助理教授（研究）陳顯宏解釋，「學生與朋友互相發問和印證個人立場的過程中，能深化對課本知識的理解；老師藉即時回應系統，可立時知道同學不明白的地方，對大班教學尤其有用」，故最後取得整體大獎中的最佳資訊及通訊科技工具應用銅獎。<br><br>「全球教學創新大獎二○一六」由國際大學評級機構和美國華頓商學院合辦，旨在表揚業界藉應用學習科技，作出創新的教與學意念和方法，今年有逾五十個國家八百多個項目參賽，理大有四個項目獲獎。<br><br></p>    </div>
					</div>
				</v-card-text>
				<v-card-text v-if="current_news_index == 2">
					<div class="container">
						<div class="page-header">
							<h1>
								﻿理大遙距平台 隨時隨地做實驗        </h1>
						</div>
						<div class="text-justify">
							<p>時間：2016-12-28 03:15:41 來源：<a href="http://www.takungpao.com.hk/finance/text/2016/1228/49238.html" target="_blank">大公報</a></p>
					<br>
					<img class="img-responsive center-block" src="http://img.takungpao.com/2016/1228/20161228031541418.jpg">
					<br>
					<p class="text-center">圖：麥熾良稱遙距物理實驗平台最大特色，是隨時隨地進行教學</p>

					<p>【大公報訊】實習記者董一秀報道：香港理工大學在「全球教學創新大獎2016」（Reimagine Education Awards 2016）勇奪四獎，包括一項「亞洲地區組別」金獎及一項「最佳資訊及通訊科技工具應用」整體銅獎。其中，遙距物理實驗平台在2017/18學年即可用於在線實時實驗課程。</p><p>奪得「亞洲地區組別」金獎的遙距物理實驗平台最大特色在於「Anytime, Anywhere」（隨時隨地）。理大應用物理學系副教授麥熾良說，學生可以在此平台隨時隨地進行實驗，只需連接網絡，利用電腦控制實驗裝置，便可透過網絡攝影機實時監控以及收集實驗數據，「在時間選擇、使用次數以及實驗進程等方面有很高的靈活性」。</p><p>麥熾良表示，他們計劃在2017/18學年引入在線實時實驗課程，供應用物理學系本科生修讀，先將原來課程中的部分實驗放在遙距物理實驗平台上實現，再慢慢推廣到所有實驗。此平台現在已經設置了超聲波、地球磁場、量度電子荷質比、放射、光電效應、光的干擾和衍射等六種遙距實驗。</p><p>「香港的教學空間是個大問題。」麥熾良認為，遙距物理實驗平台能彌補在普通實驗室做不到的事。他以放射實驗為例，利用遙距物理實驗平台的封閉空間和遠程控制，學生毋須接觸輻射性材料，即使長時間操作也不會影響健康。麥補充，未來遙距物理實驗平台或將結合VR及AR技術，增強真實性。另外，他們還會應用智能電話科技，推出物理實驗應用程式（Physics experiment apps），將手機也打造成簡單的流動實驗室。</p><p>創新教學奪四國際獎</p><p>奪得「最佳資訊及通訊科技工具應用」整體銅獎的項目是「協作學習與科技─『同儕教學法』及『課堂即時答問系統』在大課堂的應用」。理大應用社會科學系助理教授（研究）陳顯宏表示，在一個二、三百人的大課堂，老師難以顧及每個學生，而且「老師單單傳授知識不及同學互相討論的學習效果好」。他說，「同儕教學法」透過課堂討論、同儕互問及回應的過程，幫助學生主動學習、釐清概念。「課堂即時答問系統」則是在「同儕教學法」基礎上研發，利用智能電話、平板電腦等電子裝置，讓學生在課堂上即時回應問題。</p><p>「全球教學創新大獎2016」由美國華頓商學院與國際大學評級機構合辦，今年吸引了56個國家的807個項目，最終有140項入圍決賽，理大勇奪四獎。</p>
						</div>
					</div>
				</v-card-text>
				<v-card-text v-if="current_news_index == 3">
					<div class="container">
						<div class="page-header">
							<h1>
								搭建「遙距實驗平台」 理大奪教學創新金獎        </h1>
						</div>

						<div class="text-justify">
							<p>時間：2016-12-28 來源：<a href="http://paper.wenweipo.com/2016/12/28/HK1612280033.htm" target="_blank">文匯報</a></p>
					<br>
					<img class="img-responsive center-block" src="http://image.wenweipo.com/2016/12/28/a09d.jpg" alt="■理大在「全球教學創新大獎2016」中，共奪得四個獎項。 吳希雯  攝">
					<br>
					<p class="text-center">理大在「全球教學創新大獎2016」中，共奪得四個獎項。 吳希雯  攝</p>

					<p>香港文匯報訊（記者  吳希雯）科學實驗成本高，部分更帶有危險性，為讓學生得到更多做實驗的機會，香港理工大學應用物理學系副教授麥熾良、梁志華等設計出「遙距物理實驗平台」，讓同學隨時隨地登入網頁，遙距控制實驗室儀器，練習做實驗收集數據，希望可幫助學生學習科學，因此獲頒「全球教學創新大獎2016」當中的「亞洲地區組別」金獎。
					</p><p>隔空測量數據  培養邏輯演繹
					</p><p>「全球教學創新大獎2016」由美國華頓商學院（Wharton School at the University of Pennsylvania）及國際大學評級機構（Quacquarelli Symonds/ QS）合辦，本年為第三屆。奪得「亞洲地區組別」金獎的「遙距物理實驗平台」是一個實時系統，須預先在實驗室內設置儀器、實驗品及攝影鏡頭等，學生在網上登入平台後，可透過實驗室內的鏡頭觀察，並以電腦遙距控制實驗室內的儀器，進行各種測量工作，獲取數據。
					</p><p>梁志華表示，觀察到同學一般在應試方面表現佳，但未能掌握實驗技巧，及學習科學必備的邏輯演繹能力，「學生未能在報告中，用圖表清晰展示數據，顯示他們收集及分析數據的能力低，原因或與新高中課程比舊課程少實驗機會有關。」
					</p><p>使用「遙距物理實驗平台」，同學即使在凌晨時分，亦可安坐家中做實驗。麥熾良解釋：「例如在測量地球磁場的實驗中，同學操控實驗室儀器量度數據，並需即時分析，找出下一步需測量的部分，如果第一部分出錯，會導致下一部分失敗。」雖然每次只能容納一定數量的學生同時進行實驗，但同學可重覆登入，多作練習。
					</p><p>隨了「跨時空」的便利外，平台還可讓同學「隔空」進行危險實驗，麥熾良指，「在放射實驗中，同學可花數小時，安全地遙距操控載有金屬片的轉盤，觀察以不同金屬阻隔輻射物、測量器所量得的不同數據。」實驗完結後，系統會自動關上設備，確保安全。此類實驗還需要配合棄置輻射物的處理工序，成本較高，一般中學未必可配置，麥熾良期望平台日後可惠及中學生。
					</p><p>學者研即時答問系統奪銅
					</p><p>在同一比賽中奪得整體大獎-「最佳資訊及通訊科技工具應用」銅獎的，是理大應用社會科學系助理教授（研究）陳顯宏領導的項目：協作學習與科技-「同儕教學法」及「課堂即時答問系統」在大班課堂的應用。利用課堂即時答問系統，老師在堂上問問題後，可即時收集過百名同學由手機提交的答案，陳顯宏加入「同儕教學法」概念，要求學生在首輪回答後，自行進行小組討論闡釋理據，然後以手機進行次輪回答，目前已有20學科逾5,350名學生參加，相信有效幫助學習，「以手機回答問題，免卻面對群眾壓力，有效鼓勵學生參與，而同儕之間的討論有助釐清概念。」
					</p><p>「全球教學創新大獎2016」有來自56個國家和地區，共807項項目參賽，當中527項獲大會接納，140項入圍決賽，理大共奪得4項獎項，除以上項目外，還有服務領袖（整體大獎-「領導道德」銅獎），及服務領袖（「社會企業組別」銅獎）。
					</p>    </div>
					</div>
				</v-card-text>

				<v-divider></v-divider>

			</v-card>
			</v-dialog>
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
				dialog: false,
				current_news_index: 0,
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
			openNews(index){
				var self = this;
				self.dialog = true;
				self.current_news_index = index;

			}
		}
	}
</script>
