<template>
  <div class="lineChart">
    <canvas></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
export default {
  name: 'LineChart',
  props: {
    chartData: Object,
    chartOptions: Object,
    chart: Object
  },
  data:function(){
    return {
      myChart:this.chart
    }
  },
  methods:{
    renderChart(data) {
      const ctx = this.$el.querySelector('canvas');
      this.chartData.datasets[0].data = data; //only one dataset
      if(typeof this.myChart != 'undefined'){
        this.myChart.destroy();
      }
      this.myChart = new Chart(ctx, {
        type: 'line',
        data: this.chartData,
        options: this.chartOptions
      });
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>