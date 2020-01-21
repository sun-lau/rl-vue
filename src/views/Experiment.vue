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
                                <apexchart type="line" :options="options" :series="series"></apexchart>
                            </b-col>
                        </b-row>
                    </v-card>
                </b-col>
                <b-col cols="6">
                    <v-card>
                        <v-card-title>Laser State</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="laser_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('LASER|OFF')">Off</v-chip>
                                <v-chip @click="setCommand('LASER|RED')">Red</v-chip>
                                <v-chip @click="setCommand('LASER|GREEN')">Green</v-chip>
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
                        <v-card-actions class="ml-4">
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

                        <v-card-title>Slit Position</v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn @click="setCommand('SLIT|LEFT')" >
                                <font-awesome-icon icon="angle-left" /> 
                                Left
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('SLIT|RIGHT')">
                                <font-awesome-icon icon="angle-right" /> 
                                Right
                            </v-btn>
                        </v-btn-toggle>

                        <v-card-title>
                            Distance D 
                        </v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn @click="setCommand('DISTANCE|INCREASE')" >
                                <font-awesome-icon icon="angle-up" />
                                Increase
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('DISTANCE|DECREASE')">
                                <font-awesome-icon icon="angle-down" />
                                Decrease
                            </v-btn>
                        </v-btn-toggle>
                        <br>
                        <small>D = 990mm</small>
                        <br>
                        <div>
                            <div class="ma-4">
                                <v-btn @click="requestChart()">Measure</v-btn>
                                <v-btn @click="getValue()">Export</v-btn>
                            </div>
                        </div>
                    </v-card>
                </b-col>
            </b-row>
        </b-container>
        <v-dialog v-model="loading" fullscreen>
            <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
                <v-layout justify-center align-center>
                <v-progress-circular
                    indeterminate
                    color="primary">
                </v-progress-circular>
                </v-layout>
            </v-container>
        </v-dialog>
    </div>
</template>

<script>
// @ is an alias to /src

import moment from 'moment';
import LineChart from '@/components/LineChart.vue'
import {Experiment_APIService} from '@/services/Experiment_APIService';
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: 'experiment',
  components: {
      LineChart
  },
  data:function(){
      return{
        inte:null,
        laser_show:false,
        gain_show:false,
        laser_status:"",
        gain_status:"",
        loading: false,
        api:{
            value:""
        },
        options: {
        },
        series: [{
            data: []
        }],

      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        self.$refs.experiment_chart.renderChart([]);
  },
  methods:{
        getValue(callback){
            console.log("getValue");
            var self = this;
            apiService.getValue()
            .then((response) => {
                self.api.value = response.value;
                if(callback){
                    callback();
                }
            });
        },
        setCommand(command, callback){
            apiService.setCommand(command)
            .then((response) => {
                console.log("command is set");
                console.log("response");
                console.log(response);
                if(callback){
                    callback();
                }
            });
        },
        requestChart(){
            var self = this;
            self.loading = true;
            self.setCommand('MEASURE|START', function(){
                self.inte = setInterval(function(){
                    self.getValue(function(){
                        if(self.api.value == "complete"){
                            clearInterval(self.inte);
                            self.getChart();
                            self.loading = false;
                        }
                    });
                },2000);
            });
        },
        getChart(){
            console.log("getChart");
            var self = this;
            apiService.getChart()
            .then((response) => {
                self.api.chart = response;
                self.series = [{data:response}];
                console.log("self.series");
                console.log(self.series);
            });

        }
  }
}
</script>
