<template>
    <div class="experiment">
        <b-container fluid>
            <b-row>
                <b-col cols="7">
                    <b-card>
                            <b-img 
                                src="http://158.132.254.152:8081/?action=stream"
                                fluid
                                rounded
                            />
                            <b-img 
                                src="http://158.132.254.152:8082/?action=stream"
                                fluid
                                rounded
                            />
                            <line-chart 
                                ref="experiment_chart"
                                :chartOptions="chartOptions"
                                :chartData="chartData"
                                style="width:100%; height:80px;"
                            />
                    </b-card>
                </b-col>
                <b-col cols="5">
                    <b-card
                        header="Control"
                    >
                        <b-button-group>
                            <b-button variant="success">Success</b-button>
                            <b-button variant="info">Info</b-button>
                            <b-button variant="warning">Warning</b-button>
                        </b-button-group>
                    </b-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
// @ is an alias to /src

import moment from 'moment';
import LineChart from '@/components/LineChart.vue'
import {Experiment_APIService} from '@/services/Experiment_APIService';
// const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL, 'dummy');
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: 'experiment',
  components: {
      LineChart
  },
  data:function(){
      return{
          chartData: {
                labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
                datasets: [{
                label: 'Usage',
                backgroundColor: [
                    'rgba(0, 123, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(134,192,255,1)'
                ],
                borderWidth: 1
                }]
            },
            chartOptions: {
                animation: false,
                layout: {
                    padding: {
                    left: 0,
                    right: 0,
                    top: 10,
                    bottom: 0
                    }
                },
                legend: {
                    display: false,
                },
                scales: {
                    xAxes:[
                        {
                            type: 'time',
                            time: {
                                unit: 'minute'
                            }
                        }
                    ],
                    yAxes: [{
                        ticks: {
                            display: true,
                            beginAtZero:true
                        }
                    }]
                }
            }
      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        self.getChart();

  },
  methods:{

        getChart(){
            var self = this;
            apiService.getChart()
            .then((response) => {
                console.log("response.value");
                console.log(response);
                self.$refs.experiment_chart.renderChart(response.value);
            });
        },
  }
}
</script>
