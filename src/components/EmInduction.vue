<template>
    <div class="">
        <v-container fluid>
            <v-row>
                <v-col xs="12" sm="6">
                    <v-card>
                        <v-card-title>Live</v-card-title>
                        <v-row class="ml-2 mr-2 mt-4">
                            <v-col  xs="12" sm="6">
                            <b-img 
                                :src="api.camera_0"
                                fluid
                            />
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card>
                        <v-card-title>Measure Result</v-card-title>
                        <apexchart type="line" :options="options" :series="series"></apexchart>
                    </v-card>
                </v-col>
                <v-col xs="12" sm="6">
                    <v-card>
                        <v-card-title>Magnet (thickness)</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="magnet"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('device_0','MAGNET|1')">1</v-chip>
                                <v-chip @click="setCommand('device_0','MAGNET|2')">2</v-chip>
                                <v-chip @click="setCommand('device_0','MAGNET|3')">3</v-chip>
                            </v-chip-group>
                        </v-card-actions>

                    </v-card>
                    <v-card>
                        <v-card-title>Coil (turn)</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="coil"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('device_0','COIL|1')">1</v-chip>
                                <v-chip @click="setCommand('device_0','COIL|2')">2</v-chip>
                                <v-chip @click="setCommand('device_0','COIL|3')">3</v-chip>
                            </v-chip-group>
                        </v-card-actions>
                    </v-card>
                    <v-card>
                        <v-card-title>Speed (rpm)</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="speed"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('device_0','SPEED|1')">1</v-chip>
                                <v-chip @click="setCommand('device_0','SPEED|2')">2</v-chip>
                                <v-chip @click="setCommand('device_0','SPEED|3')">3</v-chip>
                            </v-chip-group>
                        </v-card-actions>
                    </v-card>
                    <v-card>
                        <div class="ma-4">
                            <v-btn block @click="requestChart()">Measure</v-btn>
                            <br>
                            <!-- <v-btn block @click="getValue()">Export</v-btn> -->
                        </div>
                        <br>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
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
  name: 'EmInduction',
  components: {
      LineChart
  },
  data:function(){
      return{
            inte:null,
            magnet:"",
            coil:"",
            speed:"",
            loading: false,
            api:{
                value:"",
                value_got_at:null,
                value_set_at:null,
                camera_0:"",
            },
            options: {
                width:'100%'
            },
            series: [{
                data: []
            }],
            loop_flag: false

      }
  },
  mounted: function(){
        var self = this;
        self.experiment_name = "EM_INDUCTION";
        // self.setCommand("device_0","RESTART|1");
        // self.setCommand("device_0","RESTART|1");
        self.getValue("camera_0", function(){
            self.api.camera_0 = self.api.value.url;
        });
        // self.loading = true;
        // setTimeout(function(){
        //     self.loading = false;
        // },5000);
        self.getValue("device_0");
        setInterval(function(){ //loop distance value
            if(self.loop_flag){
                self.getValue("device_0", function(){
                    if(self.api.value_set_at >= self.api.value_got_at){
                        self.loop_flag = false;
                    }
                });
            }
        },1000);
  },
  methods:{
        getValue(device_id, callback){
            console.log("getValue");
            var self = this;
            apiService.getValue(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id)
            .then((response) => {
                self.api.value_got_at = response.value_got_at;
                self.api.value_set_at = response.value_set_at;
                self.api.command_got_at = response.command_got_at;
                self.api.command_set_at = response.command_set_at;
                self.api.value = JSON.parse(response.value)
                console.log("self.api.value");
                console.log(self.api.value);
                if(callback){
                    callback();
                }
            });
        },
        getChart(device_id){
            console.log("getChart");
            var self = this;
            apiService.getChart(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id)
            .then((response) => {
                self.api.chart = response;
                self.series = [{data:response}];
                console.log("self.series");
                console.log(self.series);
                self.loading = false;
            });
        },
        setCommand(device_id, command, callback){
            console.log("set command");
            var self = this;
            apiService.setCommand(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id, command)
            .then((response) => {
                console.log("command is set");
                console.log(self.experiment_name);
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
            self.setCommand('device_0', 'MEASURE|START', function(){
                self.inte = setInterval(function(){
                    self.getValue("device_0",function(){
                        console.log("self.api.value");
                        console.log(self.api.value);
                        if(self.api.value.chart_at >= self.api.command_set_at){
                            clearInterval(self.inte);
                            self.getChart('device_0');
                        }
                    });

                },4000);
            });
        }
  }
}
</script>
