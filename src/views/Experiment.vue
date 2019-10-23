<template>
    <div class="experiment">
        <b-container fluid>
            <b-row>
                <b-col cols="7">
                    <b-card>
                            <!-- <b-img 
                                src="http://158.132.254.152:8081/?action=stream"
                                fluid
                                rounded
                            />
                            <b-img 
                                src="http://158.132.254.152:8082/?action=stream"
                                fluid
                                rounded
                            /> -->
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
                        <p>Laser State</p>
                        <b-button-group>
                            <b-button variant="" @click="setCommand('LASER','OFF')">OFF</b-button>
                            <b-button variant="danger" @click="setCommand('LASER','RED')">Red</b-button>
                            <b-button variant="success" @click="setCommand('LASER','GREEN')">Green</b-button>
                        </b-button-group>
                        <p>Gain</p>
                        <b-button-group>
                            <b-button variant="warning" @click="setCommand('GAIN','VERY_LOW')">Very Low</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN','LOW')">Low</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN','HIGH')">High</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN','VERY_HIGH')">Very High</b-button>
                        </b-button-group>
                        <p>Slit Position</p>
                        <b-button-group>
                            <b-button variant="info" @click="setCommand('SLIT','LEFT')">
                                <font-awesome-icon icon="angle-left" />
                                Left
                            </b-button>
                            <b-button variant="info" @click="setCommand('SLIT','RIGHT')">
                                <font-awesome-icon icon="angle-right" />
                                Right
                            </b-button>
                        </b-button-group>
                        <p>Distance D</p>
                        <b-button-group>
                            <b-button variant="info" @click="setCommand('DISTANCE','INCREASE')">
                                <font-awesome-icon icon="angle-up" />
                                Increase
                            </b-button>
                            <b-button variant="info" @click="setCommand('DISTANCE','DECREASE')">
                                <font-awesome-icon icon="angle-down" />
                                Decrease
                            </b-button>
                        </b-button-group>
                        <br>
                        <small>D = 990mm</small>
                    </b-card>
                    <b-card
                        header="Control"
                    >
                        <b-btn @click="setCommand('MEASURE','START')">Measure</b-btn>
                        <b-btn @click="getValue()">Export</b-btn>
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
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL, 'dummy');
// const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: 'experiment',
  components: {
      LineChart
  },
  data:function(){
      return{
          chartData: {
                datasets: [{
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
                            type: 'linear'
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
        self.$refs.experiment_chart.renderChart([]);
  },
  methods:{
        getValue(){
            console.log("getValue");
            var self = this;
            apiService.getValue()
            .then((response) => {
                console.log("response.value");
                console.log(response);
                self.$refs.experiment_chart.renderChart(response.value);
            });
        },
        setCommand(command, value){
            apiService.setCommand(command, value)
            .then((response) => {
                console.log("command is set");
                console.log("response");
                console.log(response);
            });
        }
  }
}
</script>
