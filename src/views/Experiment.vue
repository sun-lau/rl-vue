<template>
    <div class="experiment">
        <b-container fluid>
            <b-row>
                <b-col cols="6">
                    <v-card>
                        <b-row>
                            <b-col cols="6">
                            <b-img 
                                src="http://158.132.254.152:8081/?action=stream"
                                fluid
                                rounded
                            />
                            </b-col>
                            <b-col cols="6">
                            <b-img 
                                src="http://158.132.254.152:8082/?action=stream"
                                fluid
                                rounded
                            />
                            </b-col>
                            <b-col cols="12">
                            <line-chart 
                                ref="experiment_chart"
                                :chartOptions="chartOptions"
                                :chartData="chartData"
                                style="width:100%; height:80px;"
                            />
                            </b-col>
                        </b-row>
                    </v-card>
                </b-col>
                <b-col cols="6">
                    <v-card>
                        <v-card-title>Laser State</v-card-title>
                        <v-card-actions>
                            <v-chip-group
                                v-model="laser_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('LASER|OFF')">Off</v-chip>
                                <v-chip @click="setCommand('LASER|OFF')">Red</v-chip>
                                <v-chip @click="setCommand('LASER|OFF')">Green</v-chip>
                            </v-chip-group>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                @click="laser_show = !laser_show"
                            >
                                <v-icon>{{ laser_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>

                        <v-expand-transition>
                        <div v-show="laser_show">
                            <v-divider></v-divider>

                            <v-card-text>
                            I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                            </v-card-text>
                        </div>
                        </v-expand-transition>
                    </v-card>
                    <v-card>
                        <v-card-title>Gain</v-card-title>
                        <v-card-actions>
                            <v-chip-group
                                v-model="gain_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('GAIN|VERY_LOW')">Very Low</v-chip>
                                <v-chip @click="setCommand('GAIN|LOW')">Low</v-chip>
                                <v-chip @click="setCommand('GAIN|HIGH')">High</v-chip>
                                <v-chip @click="setCommand('GAIN|VERY_HIGH')">Very High</v-chip>
                            </v-chip-group>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                @click="gain_show = !gain_show"
                            >
                                <v-icon>{{ gain_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>

                        <v-expand-transition>
                        <div v-show="gain_show">
                            <v-divider></v-divider>

                            <v-card-text>
                            I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                            </v-card-text>
                        </div>
                        </v-expand-transition>
                    </v-card>
                    <v-card>

                        <v-card-title>Gain</v-card-title>
                        <b-button-group>
                            <b-button variant="warning" @click="setCommand('GAIN|VERY_LOW')">Very Low</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN|LOW')">Low</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN|HIGH')">High</b-button>
                            <b-button variant="warning" @click="setCommand('GAIN|VERY_HIGH')">Very High</b-button>
                        </b-button-group>
                        <v-card-title>Slit Position</v-card-title>
                        <b-button-group>
                            <b-button variant="info" @click="setCommand('SLIT|LEFT')">
                                <font-awesome-icon icon="angle-left" />
                                Left
                            </b-button>
                            <b-button variant="info" @click="setCommand('SLIT|RIGHT')">
                                <font-awesome-icon icon="angle-right" />
                                Right
                            </b-button>
                        </b-button-group>
                        <v-card-title>Distance D</v-card-title>
                        <b-button-group>
                            <b-button variant="info" @click="setCommand('DISTANCE|INCREASE')">
                                <font-awesome-icon icon="angle-up" />
                                Increase
                            </b-button>
                            <b-button variant="info" @click="setCommand('DISTANCE|DECREASE')">
                                <font-awesome-icon icon="angle-down" />
                                Decrease
                            </b-button>
                        </b-button-group>
                        <br>
                        <small>D = 990mm</small>
                        <br>
                        <b-btn @click="setCommand('MEASURE|START')">Measure</b-btn>
                        <b-btn @click="getValue()">Export</b-btn>
                    </v-card>
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
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
// const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: 'experiment',
  components: {
      LineChart
  },
  data:function(){
      return{
          laser_show:false,
          gain_show:false,
          laser_status:"",
          gain_status:"",
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
